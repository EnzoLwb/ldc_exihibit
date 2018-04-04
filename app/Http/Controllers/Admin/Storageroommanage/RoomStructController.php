<?php

namespace App\Http\Controllers\Admin\Storageroommanage;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\RoomStructPost;
use App\Models\Storageroommanage\StorageRoom;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
			$room_data=StorageRoom::where('room_number','like',"%{$request->room_number}%")->paginate(parent::PERPAGE);
		}else{
			$room_data=StorageRoom::paginate(parent::PERPAGE);
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
			return $this->error('保存失败(库房编号不能重复)');
		}
		return $this->success(route('admin.storageroommanage.roomstruct'),'成功');
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
	/**
	 * 导出excel
	 */
	public function excel()
	{
		$apply_ids = request('apply_ids');
		$storageRoom=new StorageRoom();
		//选中的所有数据
		$res = $storageRoom->whereIn("room_id", $apply_ids)->get()->toArray();
		$xls_data = array();
		$header = ['库房库位名称','库房库位编号','是否库位',
			'库房类型','存储方式','库房大小','是否生效','位置','负责人'];
		$xls_data[] = $header;
		foreach($res as $k=> $v)
		{
			$xls_data[] = array(
				$v['room_name'],
				$v['room_number'],
				$v['ifstorage']=='1'?'是':'否',
				$v['room_type'],
				$v['save_type'],
				$v['room_size'],
				$v['status']=='1'?'是':'否',
				$v['position'],
				$v['leader']
			);
		}
		Excel::create('库房表', function ($excel) use ($xls_data) {
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