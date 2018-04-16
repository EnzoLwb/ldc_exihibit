<?php

namespace App\Http\Controllers\Admin\Storageroommanage;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Frame;
use App\Models\Storageroommanage\StorageRoom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FrameController extends BaseAdminController
{
    /**
     * 排架列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $frame_name = \request('frame_name');
        $res['data'] = Frame::join('storage_room', 'storage_room.room_number', '=', 'frame.room_number')
            ->where('frame_name', 'like', '%'.$frame_name.'%')
            ->select('room_name', 'frame_number','frame_id',
            'frame.frame_name', DB::Raw('ldc_frame.room_number'))->paginate(parent::PERPAGE);
        return view('admin.storageroommanage.framelist', $res);
    }

    /**
     * 显示form页面
     */
    public function add(){
        $frame_id = \request('frame_id');
        $res['storage'] = StorageRoom::all();
        $res['info'] = Frame::where('frame_id', $frame_id)->first();
        return view('admin.storageroommanage.frame_form', $res);
    }

    /**
     *  保存排架信息
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function save(){
        $frame_id = \request('frame_id');
        $frame_model = Frame::findOrNew($frame_id);
        $frame_model->room_number = \request('room_number');
        $frame_model->frame_number = \request('frame_number');
        $frame_model->frame_name = \request('frame_name');
        $frame_model->save();
        return $this->success(get_session_url('index'), '保存成功');
    }

    public function del(){
        $frame_id = \request('frame_id');
        $frame_model = Frame::findOrNew($frame_id);
        $frame_model->delete();
        return $this->success(get_session_url('index'), '删除成功');
    }
}
