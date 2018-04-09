<?php

namespace App\Http\Controllers\Admin\Exhibitshow;

use App\Dao\ConstDao;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\ShowPosition;
use Illuminate\Http\Request;
use App\Models\ShowApply;

/**
 * Class ApplyController
 *
 * @author lxp
 * @package App\Http\Controllers\Admin\Setting
 */
class ApplyController extends BaseAdminController
{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * index
	 *
	 * @author lxp
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
	    $title = \request('title');
	    if(empty($title)){
            $list = ShowApply::paginate(parent::PERPAGE);
        }else{
	        $list = ShowApply::where('applyer','like','%'.$title.'%')->paginate(parent::PERPAGE);
        }
	    $res['data'] = $list;
		return view('admin.exhibitshow.apply',$res);
	}

	/**
	 * add
	 *
	 * @author lxp
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function add()
	{
	    $show_apply_id = \request('show_apply_id');
	    if(empty($show_apply_id)){
	        $show_apply_id = -1;
        }
	    $show_apply_model = ShowApply::where('show_apply_id', $show_apply_id)->first();
	    $res['info'] = $show_apply_model;
        $res['show_apply_id'] = $show_apply_id;
	    $res['pos_list'] = ShowPosition::where('is_valid', ConstDao::SHOW_POSITION_IS_VALID)->get();
		return view('admin.exhibitshow.apply_form', $res);
	}

    /**
     * 提交审核
     */
	public function submit(){
        $show_apply_id = \request('show_apply_id');
        //判断是否有已经审核
        if(empty($show_apply_id) && !is_array($show_apply_id)){
            return response_json(0,array(),'参数有误');
        }
        $count = ShowApply::where('status','!=', ConstDao::SHOW_APPLY_STATUS_DRAFT)->whereIn('show_apply_id', $show_apply_id)->count();
        if($count>0){
            return response_json(0,array(),'包含项中有已提交的项');
        }
        ShowApply::whereIn('show_apply_id', $show_apply_id)->update(array('status'=>ConstDao::SHOW_APPLY_STATUS_WAITING_AUDIT));
        return response_json(1,array(),'操作成功');
    }
	/**
	 * edit
	 *
	 * @author lxp
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit($id)
	{
		return view('admin.exhibitshow.apply_form', [
			'data' => []
		]);
	}

	/**
	 * save
	 *
	 * @author lxp
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function save(Request $request)
	{
        $show_apply_id = \request('show_apply_id');
        $show_apply_model = ShowApply::findOrNew($show_apply_id);
        $except = array('_token','show_position_id');
        $all = $request->all();
        foreach ($all as $k=>$v){
            if(!in_array($k, $except)){
                $show_apply_model->$k = $v;
            }
        }
        $show_apply_model->status = ConstDao::SHOW_APPLY_STATUS_DRAFT;
        $show_apply_model->save();
        //保存信息
        $show_position_id = \request('show_position_id');
        if(!empty($show_position_id) && is_array($show_position_id)){
            ShowPosition::whereIn('show_position_id', $show_position_id)->update(array('show_apply_id'=>$show_apply_model->show_apply_id));
        }

		return $this->success(get_session_url('index'));
	}

	/**
	 * delete
	 *
	 * @author lxp
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function delete()
	{
		$show_apply_id = \request('show_apply_id');
        $apply = ShowApply::find($show_apply_id);
        if(empty($apply)){
            return response_json(0,[],'参数有误');
        }
        $apply->delete();
        ShowPosition::where('show_apply_id', $show_apply_id)->update(array('show_apply_id'=>0));
		return $this->success('', 's_del');
	}
}