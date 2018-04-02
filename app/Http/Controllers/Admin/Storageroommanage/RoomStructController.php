<?php

namespace App\Http\Controllers\Admin\Storageroommanage;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\RoomStructPost;
use App\Models\Storageroommanage\StorageRoom;
use Illuminate\Http\Request;

/**
 * Class RoomStructController
 *
 * @author lxp
 * @package App\Http\Controllers\Admin\Storageroommanage
 */
class RoomStructController extends BaseAdminController
{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * index
	 *
	 * @author lxp
	 * @param  Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
	{
		//搜索项 搜索库房编号
		if (!empty( $request->room_number)){
			$room_data=StorageRoom::where('room_number','like',"%{$request->room_number}%")->paginate(15);
		}else{
			$room_data=StorageRoom::paginate(15);
		}
		return view('admin.storageroommanage.roomstruct', [
			'data' => $room_data
		]);
	}

	/**
	 * add
	 *
	 * @author lwb 20180402
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function add()
	{

		return view('admin.storageroommanage.roomstruct_form');
	}

	/**
	 * edit
	 *
	 * @author lwb
	 * @param $id 2018 0402 库房id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit($id)
	{
		$storage_detail=StorageRoom::find($id);
		return view('admin.storageroommanage.roomstruct_form', [
			'data' => $storage_detail
		]);
	}

	/**
	 * save
	 *
	 * @author lwb 20180402
	 * @param RoomStructPost $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function save(RoomStructPost $request)
	{

		// 保存数据
		try {
			$rs = StorageRoom::find($request->room_id);
			if(!$rs){
				$rs=new StorageRoom();
				$rs::create($request->all());
			}else{
				$rs->update($request->except('room_id','_token'));
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
	 * @author lwb 201800402
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function delete($id)
	{
		// 删除
		try {
			if (StorageRoom::destroy($id)){
				return redirect(route('admin.storageroommanage.roomstruct'));
			}
		} catch (\Exception $e) {
			//写入日志 保存失败
			report($e);
		}
		return $this->error('删除失败');
	}

}