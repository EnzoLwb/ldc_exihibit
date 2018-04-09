<?php

namespace App\Http\Controllers\Admin\Exhibitshow;

use App\Dao\ConstDao;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Exhibit;
use App\Models\ShowPosition;
use Illuminate\Http\Request;
use App\Models\PositionAndExhibit;
use Illuminate\Support\Facades\DB;

/**
 * Class ShowController
 *
 * @author lxp
 * @package App\Http\Controllers\Admin\Setting
 */
class ShowController extends BaseAdminController
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
            $pos_list = ShowPosition::where('is_valid',ConstDao::SHOW_POSITION_IS_VALID)->paginate(parent::PERPAGE);
        }else{
            $pos_list = ShowPosition::where('name','like','%'.$title.'%')->where('is_valid',ConstDao::SHOW_POSITION_IS_VALID)->paginate(parent::PERPAGE);
        }
        foreach($pos_list as $k=>$v){
            $position_id = $v->show_position_id;
            $raw_ = PositionAndExhibit::join('exhibit','exhibit.exhibit_sum_register_id','=','position_and_exhibit.exhibit_sum_register_id')
                ->where('show_position_id', $position_id)->select('exhibit.name')->get();

            $names = '';
            foreach($raw_ as $exhibit){
                $names .= $exhibit->name.',';
            }
            $pos_list[$k]->names = $names;
        }
        $res['data'] = $pos_list;
		return view('admin.exhibitshow.show', $res);
	}

	/**
	 * add
	 *
	 * @author lxp
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function add()
	{
		return view('admin.exhibitshow.show_form');
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
		return view('admin.exhibitshow.show_form', [
			'data' => []
		]);
	}

    /**
     * 展位和展品的关联关系展示
     */
	public function position_relative(){
	    $position_id = \request('show_position_id');
	    $show_position = ShowPosition::find($position_id);
	    if(empty($show_position)){
	        return $this->error('参数有误');
        }
        $res['info'] = $show_position;
	    $exhibit_list = Exhibit::all();
	    $list = PositionAndExhibit::where('show_position_id', $position_id)->select('exhibit_sum_register_id')->get();
	    $check_exhibnt_ids = array();
	    foreach($list as $item){
	        $check_exhibnt_ids[] = $item->exhibit_sum_register_id;
        }
	    foreach($exhibit_list as $k=>$exhibit){
            if(in_array($exhibit->exhibit_sum_register_id, $check_exhibnt_ids)){
                $exhibit_list[$k]->is_checked = 1;
            }else{
                $exhibit_list[$k]->is_checked = 0;
            }
        }
	    $res['list'] = $exhibit_list;
	    return view('admin.exhibitshow.pos_exhibit_show', $res);
    }

    /**
     * 保存关联关系
     */
    public function  position_relative_save(){
        $show_position_id = \request('show_position_id');
        $exhibit_sum_register_id = \request('exhibit_sum_register_id');
        DB::transaction(function () use($show_position_id,$exhibit_sum_register_id ) {
            //解除以前的关联关系
           PositionAndExhibit::where('show_position_id', $show_position_id)->delete();
           foreach ($exhibit_sum_register_id as $item){
               $model = new PositionAndExhibit();
               $model->show_position_id = $show_position_id;
               $model->exhibit_sum_register_id = $item;
               $model->save();
           }
        });
        return response_json(1,[],'操作成功');
    }

    /**
     * 解除以前的关联关系
     * @return \Illuminate\Http\JsonResponse
     */
    public function  position_relative_clear(){
        $show_position_id = \request('show_position_id');
        PositionAndExhibit::where('show_position_id', $show_position_id)->delete();
        return response_json(1,[],'操作成功');
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
		// 验证
		$this->validate($request, []);
		// 保存数据
		return $this->success(get_session_url('index'));
	}

	/**
	 * delete
	 *
	 * @author lxp
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function delete($id)
	{
		// 删除
		return $this->success('', 's_del');
	}
}