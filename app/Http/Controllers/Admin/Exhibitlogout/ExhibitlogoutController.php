<?php

namespace App\Http\Controllers\Admin\Exhibitlogout;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\CollectExhibit;
use App\Models\ExhibitLogout;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class ExhibitlogoutContrller
 *
 * @author lxp
 * @package App\Http\Controllers\Admin\Setting
 */
class ExhibitlogoutController extends BaseAdminController
{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * index
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
	{
		$exhibit_Logout=new ExhibitLogout();
		//搜索项 搜索藏品名称
		if (!empty( $request->logout_num)){
			$data=$exhibit_Logout->joinLeft()->where('name','like',"%{$request->logout_num}%")->paginate(parent::PERPAGE);
		}else{
			$data=$exhibit_Logout->joinLeft()->paginate(parent::PERPAGE);
		}
		return view('admin.exhibitlogout.exhibitlogout', [
			'data' => $data
		]);
	}

	/**
	 * add
	 *
	 * @author lxp
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function add()
	{
		//返回所有藏品id和名字
		$exhibit_Logout=new ExhibitLogout();
		return view('admin.exhibitlogout.exhibitlogout_form',[
			'exhibits'=>$exhibit_Logout->collectName()
		]);
	}

	/**
	 * 提交申请
	 */
	public function apply_submit(Request $request)
	{

		$logout_ids = $request->logout_ids;

		if(!empty($logout_ids) && is_array($logout_ids)){
			//选取未提交过的申请 提交
			ExhibitLogout::where('status','0')->whereIn('logout_id',$logout_ids)->update(array('status'=>'1'));
		}else{
			return $this->error('申请失败');
		}
		return $this->success('','已经提交申请');
	}
	/**
	 * edit
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit($id)
	{
		$exhibit_Logout=new ExhibitLogout();
		$detail=$exhibit_Logout->joinLeft()->find($id);
		//返回所有藏品id和名字
		$exhibits=$exhibit_Logout->collectName();
		return view('admin.exhibitlogout.exhibitlogout_form', [
			'data' => $detail,'exhibits'=>$exhibits
		]);
	}

	/**
	 * 藏品注销
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function save(Request $request)
	{
		// 验证
		$this->validate($request, [
			'logout_num'=>'required',
			'logout_name'=>'required',
			'logout_date'=>'required|date',
			'logout_pizhun_num'=>'required',
		],[
			'required'=>':attribute 为必填项',
			'date'=>':attribute 填写规范日期格式',
		],[
			'logout_num'=>'注销凭证号',
			'logout_name'=>'注销凭证名称',
			'logout_date'=>'注销日期',
			'logout_pizhun_num'=>'注销批准文号',
		]);
		// 保存数据
		try {
			$logout = ExhibitLogout::find($request->logout_id);
			if(!$logout){
				$logout=new ExhibitLogout();
				$logout::create($request->all());
			}else{
				$logout->update($request->except('logout_id','_token'));
			}
		} catch (\Exception $e) {
			//写入日志 保存失败
			report($e);
			return $this->error('保存失败');
		}
		return $this->success(route('admin.exhibitlogout'),'成功');
	}

	/**
	 * delete
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function delete($id)
	{
		// 删除
		try {
			if (ExhibitLogout::destroy($id)){
				return $this->success(route('admin.exhibitlogout'),'成功');
			}
		} catch (\Exception $e) {
			//写入日志 保存失败
			report($e);
		}
		return $this->error('删除失败');
	}
	/**
	 * 导出excel
	 */
	public function excel()
	{
		$apply_ids = request('apply_ids');
		$exhibit_Logout=new ExhibitLogout();
		//选中的所有数据
		$res = $exhibit_Logout->joinLeft()->whereIn("logout_id", $apply_ids)->get()->toArray();
		$xls_data = array();
		$header = ['藏品名称','注销凭证号','注销凭证名称','注销日期',
			'注销批准文号','注销原因','详情描述','申请状态','登记人','登记日期'];
		$xls_data[] = $header;
		foreach($res as $k=> $v)
		{
//			unset($res[$k]['files']); 删除附件之类的数据
			$xls_data[] = array(
				$v['name'],
				$v['logout_num'],
				$v['logout_name'],
				$v['logout_date'],
				$v['logout_pizhun_num'],
				$v['logout_reason'],
				$v['logout_desc'],
				$exhibit_Logout->applyStatus($v['status']),
				$v['register'],
				$v['register_date']
			);
		}
		Excel::create('藏品注销', function ($excel) use ($xls_data) {
			$excel->sheet('score', function ($sheet) use ($xls_data) {
				$sheet->setWidth(array(
					'A'     => 20,
					'B'     =>  25,
					'C'     =>  25,
					'D'     =>  25,
					'E'     =>  25,
					'F'     =>  25,
					'G'     =>  25,
					'H'     =>  25,
					'I'     =>  25,
					'J'     =>  25,
				));
				$sheet->rows($xls_data);
			});
		})->export('xls');

	}
}