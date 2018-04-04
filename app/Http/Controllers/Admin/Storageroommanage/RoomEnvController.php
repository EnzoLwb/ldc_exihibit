<?php

namespace App\Http\Controllers\Admin\Storageroommanage;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Storageroommanage\RoomEnv;
use App\Models\Storageroommanage\StorageRoom;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class RoomEnvController
 * 库房环境
 * @author lwb 2018 0330
 * @package App\Http\Controllers\Admin\Storageroommanage
 */
class RoomEnvController extends BaseAdminController
{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 库房环境管理列表
	 *
	 * @author lwb 2018 0330
	 * @param  Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
	{

		//搜索项 搜索库房编号
		if (!empty( $request->room_number)){
			$room_data=RoomEnv::where('room_number','like',"%{$request->room_number}%")->paginate(parent::PERPAGE);
		}else{
			$room_data=RoomEnv::paginate(parent::PERPAGE);
		}
		return view('admin.storageroommanage.roomenv', [
			'data' => $room_data
		]);
	}

	/**
	 * add
	 *
	 * @author lwb
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function add()
	{
		//库房编号显示供选择(查库房表)
		$room_number=StorageRoom::groupBy('room_number')->pluck('room_number');

		return view('admin.storageroommanage.roomenv_form',[
			'storage'=>$room_number
		]);
	}

	/**
	 * edit
	 *
	 * @author lwb 20180402
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit($id)
	{
		$room_env=RoomEnv::find($id);
		//库房编号显示供选择(查库房表)
		$room_number=StorageRoom::groupBy('room_number')->pluck('room_number');
		return view('admin.storageroommanage.roomenv_form', [
			'data' => $room_env,'storage'=>$room_number
		]);
	}

	/**
	 * save
	 *
	 * @author lwb 20180402
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function save(Request $request)
	{
		// 验证
		$this->validate($request,[
			'room_number'=>'required',
			'book_time'=>'required|date',
		],[
			'required'=>':attribute 为必填项',
			'date'=>':attribute 规范日期格式',
		],[
			'room_number'=>'库房编号',
			'book_time'=>'登记时间',
		]);
		try {
			$roomEnv = RoomEnv::find($request->book_id);
			if(!$roomEnv){
				//新增
				$roomEnv=new RoomEnv();
				$roomEnv::create($request->all());
			}else{
				//更改
				$roomEnv->update($request->except('book_id','_token'));
			}
		} catch (\Exception $e) {
			//写入日志 保存失败
			report($e);
			return $this->error('保存失败');
		}
		return $this->success(route('admin.storageroommanage.roomenv'),'成功');
	}

	/**
	 * delete
	 *
	 * @author lwb 20180402
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function delete($id)
	{
		// 删除
		try {
			if (RoomEnv::destroy($id)){
				return redirect(route('admin.storageroommanage.roomenv'));
			}
		} catch (\Exception $e) {
			//写入日志 保存失败
			report($e);
		}
		return $this->success('', 's_del');
	}
	/**
	 * 导出excel
	 */
	public function excel()
	{
		$apply_ids = request('apply_ids');
		$room_env=new RoomEnv();
		//选中的所有数据
		$res = $room_env->whereIn("book_id", $apply_ids)->get()->toArray();
		$xls_data = array();
		$header = ['库房编号','库房温度','库房湿度',
			'空气净化程度','库房光照率','登记人','登记日期','备注'];
		$xls_data[] = $header;
		foreach($res as $k=> $v)
		{
			$xls_data[] = array(
				$v['room_number'],
				$v['temp'],
				$v['damp'],
				$v['air'],
				$v['light'],
				$v['booker'],
				$v['book_time'],
				$v['remark']
			);
		}
		Excel::create('库房环境表', function ($excel) use ($xls_data) {
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