<?php

namespace App\Http\Controllers\Admin\Storageroommanage;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Storageroommanage\RoomEnv;
use App\Models\Storageroommanage\StorageRoom;
use Illuminate\Http\Request;

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
			$room_data=RoomEnv::where('room_number','like',"%{$request->room_number}%")->paginate(15);
		}else{
			$room_data=RoomEnv::paginate(15);
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
		return $this->success(get_session_url('index'));
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
}