<?php

namespace App\Http\Controllers\Admin\InfoRegister;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Subsidiary;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SubsidiaryController extends BaseAdminController
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
		//审核通过的不能显示
		if (!empty( $request->exhibit_sum_register_num)){
			$data=Subsidiary::where('exhibit_sum_register_num','like',"%{$request->exhibit_sum_register_num}%")
				->where('apply_status','<>','2')->paginate(parent::PERPAGE);
		}else{
			$data=Subsidiary::where('apply_status','<>','2')->paginate(parent::PERPAGE);
		}

		return view('admin.inforegister.subsidiary', [
			'exhibit_list' => $data
		]);
	}

	/**
	 * add
	 *
	 * @author lwb 20180410
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function add()
	{
		return view('admin.inforegister.add_subsidiary',[
		]);
	}

	/**
	 * 提交申请
	 */
	public function apply_submit(Request $request)
	{

		$subsidiary_id = $request->subsidiary_id;

		if(!empty($subsidiary_id) && is_array($subsidiary_id)){
			//选取未提交过的申请 提交
			Subsidiary::where('apply_status','0')->whereIn('subsidiary_id',$subsidiary_id)->update(array('apply_status'=>'1'));
		}else{
			return $this->error('申请失败');
		}
		return $this->success('','已经提交申请');
	}
	/**
	 * edit
	 * @param $id Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit(Request $request,$id)
	{
		$detail=Subsidiary::find($id);
		return view('admin.inforegister.add_subsidiary', [
			'data' => $detail,'disabled'=>$request->disabled
		]);
	}

	/**
	 * 藏品注销
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function save(Request $request)
	{
		// 保存数据

		try {
			$subsidiary = Subsidiary::find($request->subsidiary_id);
			if(!$subsidiary){
				$subsidiary=new Subsidiary();
				$subsidiary::create($request->all());
			}else{
				$subsidiary->update($request->except('subsidiary_id','_token'));
			}
		} catch (\Exception $e) {
			//写入日志 保存失败
			report($e);
			return $this->error('保存失败');
		}
		return $this->success(route('admin.inforegister.subsidiary'),'成功');
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
			if (Subsidiary::destroy($id)){
				return $this->success(route('admin.inforegister.subsidiary'),'成功');
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
		$subsidiary=new Subsidiary();
		//选中的所有数据
		$res = $subsidiary->whereIn("subsidiary_id", $apply_ids)->get()->toArray();
		$xls_data = array();
		$header = [ '收藏单位', '总登记号', '原编号', '分类号',
	'入馆登记号', '名称', '原名', '年代类型', '具体年代', '历史阶段', '质地类型1', '质地类型2', '具体质地', '普查质地', '类别范围'];
		$xls_data[] = $header;
		foreach($res as $k=> $v)
		{
			//			unset($res[$k]['files']); 删除附件之类的数据
			$xls_data[] = array(
				$v['collect_depart'],
				$v['exhibit_sum_register_num'],
				$v['ori_num'],
				$v['type_num'],
				$v['collect_recipe_num'],
				$v['name'],
				$v['ori_name'],
				$v['age_type'],
				$v['age'],
				$v['history_step'],
				$v['textaure1'],
				$v['textaure2'],
				$v['textaure'],
				$v['common_textaure'],
				$v['range_type'],
			);
		}
		Excel::create('其它文物信息登记', function ($excel) use ($xls_data) {
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
