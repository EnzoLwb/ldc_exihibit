<?php

namespace App\Http\Controllers\Admin\Storageroommanage;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Storageroommanage\RoomList;
use App\Models\Storageroommanage\StorageRoom;
use Illuminate\Http\Request;

/**
 * Class RoomlistController
 * 库房盘点任务
 * @author lwb 2018 0403
 * @package App\Http\Controllers\Admin\Storageroommanage
 */
class RoomlistController extends BaseAdminController
{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * index
	 * 库房盘点申请列表  包括历史盘点任务
	 * @author lwb 20180403
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
	{
		//搜索项 搜索库房编号
		if (!empty( $request->plan_member)){
			$room_data=RoomList::where('plan_member','like',"%{$request->plan_member}%")->paginate(parent::PERPAGE);
		}elseif($request->finished){
			//历史盘点任务
			$room_data=RoomList::where('check_status','1')->paginate(parent::PERPAGE);
			$finish='done';
		}else{
			//未完成的盘点任务
			$room_data=RoomList::where('check_status','!=','1')->paginate(parent::PERPAGE);
		}
		return view('admin.storageroommanage.roomlist', [
			'data' => $room_data,'finished'=>$finish??'0'
		]);
	}

	/**
	 * add
	 *
	 * @author lwb 20180403
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function add()
	{
		//库房编号显示供选择(查库房表)
		$room_number=StorageRoom::groupBy('room_number')->pluck('room_number');

		return view('admin.storageroommanage.roomlist_form',[
			'storage'=>$room_number
		]);
	}

	/**
	 * edit
	 *
	 * @author lwb 20180403
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit($id)
	{
		$object=new RoomList();
		$roomlist = $object->find($id);
		//库房编号显示供选择(查库房表)
		$room_number = StorageRoom::groupBy('room_number')->pluck('room_number');
		return view('admin.storageroommanage.roomlist_form', [
			'data' => $roomlist,
			'storage' => $room_number,
			'check_status'=>$object->check_status
		]);
	}

	/**
	 * save
	 *
	 * @author lwb 20180403
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function save(Request $request)
	{
		// 验证
		$this->validate($request,[
			'room_number'=>'required',
			'plan_member'=>'required',
			'plan_date'=>'required|date',
		],[
			'required'=>':attribute 为必填项',
			'date'=>':attribute 规范日期格式',
		],[
			'room_number'=>'库房编号',
			'plan_member'=>'计划盘点人员',
			'book_time'=>'登记时间',
		]);
		// 保存数据
		try {
			$roomList = RoomList::find($request->check_id);
			if(!$roomList){
				//新增
				$roomList=new RoomList();
				$roomList::create($request->all());
			}else{
				//更改
				$roomList->update($request->except('check_id','_token'));
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
	 * @author lwb 2018 0403
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function delete($id)
	{
		// 删除
		try {
			if (RoomList::destroy($id)){
				return redirect(route('admin.storageroommanage.roomlist'));
			}
		} catch (\Exception $e) {
			//写入日志 删除失败
			report($e);
		}
		return $this->success('', 's_del');
	}
}