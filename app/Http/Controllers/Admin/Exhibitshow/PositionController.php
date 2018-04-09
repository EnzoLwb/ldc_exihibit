<?php

namespace App\Http\Controllers\Admin\Exhibitshow;

use App\Dao\ConstDao;
use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use App\Models\ShowPosition;
/**
 * Class PositionController
 *
 * @author lxp
 * @package App\Http\Controllers\Admin\Setting
 */
class PositionController extends BaseAdminController
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
            $list = ShowPosition::paginate(parent::PERPAGE);
        }else{
            $list = ShowPosition::where('name','like','%'.$title.'%')->paginate(parent::PERPAGE);
        }
		return view('admin.exhibitshow.position', [
			'data' => $list
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
	    $show_position_id = \request('show_position_id');
	    $res['info'] = ShowPosition::find($show_position_id);
		return view('admin.exhibitshow.position_form', $res);
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
		return view('admin.exhibitshow.position_form', [
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
        $show_position_id = \request('show_position_id');
        $show_position_model = ShowPosition::findOrNew($show_position_id);
        $except = array('_token');
        $all = $request->all();
        foreach($all as $k=>$v){
            if(!in_array($k, $except)){
                $show_position_model->$k = $v;
            }
        }
        $show_position_model->save();
		return $this->success(get_session_url('index'));
	}

    /**
     * 修改选中的状态
     */
	public function status_change(){
        $status = \request('status');
        $show_position_id = \request('show_position_id');
        if(!in_array($status, array_keys(ConstDao::$show_position_valid_desc)) || empty($show_position_id) || !is_array($show_position_id)){
            return response_json(0,[], '参数有误');
        }
        //修改状态
        ShowPosition::whereIn('show_position_id', $show_position_id)->update(array('is_valid'=>$status));
        return response_json(1,[], '操作成功');
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
		$show_position_id = \request('show_position_id');
		$show_position = ShowPosition::find($show_position_id);
		if(empty($show_position)){
		    return response_json(0,array(),'参数有误');
        }
        $show_position->delete();
		return response_json(1, array(),'操作成功');
	}
}