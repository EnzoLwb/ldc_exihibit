<?php

namespace App\Http\Controllers\Admin\ExhibitCollect;
use App\Dao\ConstDao;
use App\Dao\ExchibitDao;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\CollectApply;
use App\Models\CollectExhibit;
use App\Models\Exhibit;
use Illuminate\Http\Request;
use App\Models\CollectRecipe;

class ExhibitController extends BaseAdminController
{
    /**
     * 征集申请web页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function apply(){
        $title = request('title');
        if(!empty($title)){
            $list = CollectApply::where('collect_apply_num','like','%'.$title."%")->where('status', ConstDao::EXHIBIT_COLLECT_APPLY_DRAFT)->paginate(parent::PERPAGE);
        }else{
            $list = CollectApply::where('status', ConstDao::EXHIBIT_COLLECT_APPLY_DRAFT)->paginate(parent::PERPAGE);
        }
        $res['exhibit_list'] = $list;
        return view('admin.exhibitcollect.apply', $res);
    }

    /**
     * 新增征集申请
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){
        $res['title'] = '新增';
        $collect_apply_id =  request('collect_apply_id');
        if(!empty($collect_apply_id)){
            $res['title'] = '修改';
            $res['info'] = CollectApply::find($collect_apply_id);
        }
        return view('admin.exhibitcollect.add', $res);
    }

    /**
     * 申请保存信息
     */
    public function apply_save(Request $request){
        $collect_apply = CollectApply::findOrNew(request('collect_apply_id'));
        $all = $request->all();
        $except_propertys = array('collect_apply_id','_token','file');
        foreach($all as $key=>$v){
            if(! in_array($key,$except_propertys)){
                $collect_apply->$key = $v;
            }
        }
        $desc = request('collect_project_desc');
        $reason = request('collect_reason');
        if(empty($desc)){
            $collect_apply->collect_project_desc = '';
        }
        if(empty($reason)){
            $collect_apply->collect_reason = '';
        }
        $collect_apply->status = ConstDao::EXHIBIT_COLLECT_APPLY_DRAFT;
        $collect_apply->save();
        return $this->success( get_session_url('apply'),'保存成功');
    }

    /**
     * 删除申请
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|
     */
    public function apply_del(){
        $collect_apply_ids = request('collect_apply_ids');
        if(!empty($collect_apply_ids) && is_array($collect_apply_ids)){
            CollectApply::whereIn('collect_apply_id',$collect_apply_ids)->delete();
        }else{
            CollectApply::where('collect_apply_id',$collect_apply_ids)->delete();
        }
        return $this->success('','删除成功');
    }

    /**
     * 申请提交审核
     */
    public function apply_submit(){
        $collect_apply_ids = request('collect_apply_ids');
        if(!empty($collect_apply_ids) && is_array($collect_apply_ids)){
            CollectApply::whereIn('collect_apply_id',$collect_apply_ids)->update(array('status'=>ConstDao::EXHIBIT_COLLECT_APPLY_WAITING_AUDIT));
        }
        return $this->success('','已经提交申请');
    }

    /**
     * 图文模式
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pic_mode(){
        $title = request('title');
        if(!empty($title)){
            $list = CollectApply::where('collect_apply_num','like','%'.$title."%")->where('status', ConstDao::EXHIBIT_COLLECT_APPLY_DRAFT)->paginate(parent::PERPAGE);
        }else{
            $list = CollectApply::where('status', ConstDao::EXHIBIT_COLLECT_APPLY_DRAFT)->paginate(parent::PERPAGE);
        }
        $res['exhibit_list'] = $list;
        return view('admin.exhibitcollect.apply_pic_mode', $res);
    }


    /**
     * 征集入馆的单子
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getin(){
        $type = request('type', ConstDao::EXHIBIT_COLLECT_RECIPE_SRC_BY_DIRECT);
        $type = request('type', 1);
        if($type == ConstDao::EXHIBIT_COLLECT_RECIPE_SRC_BY_DIRECT){
            //直接入馆
            $list = CollectRecipe::where('collect_apply_id',0)->paginate(parent::PERPAGE);
        }else{
            $list = CollectRecipe::where('collect_apply_id','!=',0)->paginate(parent::PERPAGE);
        }
        $res['exhibit_list'] = $list;
        return view('admin.exhibitcollect.getin',$res);
    }

    /**
     * 显示征集单子添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getin_add(){
        $res['item_list'] = array();
        $res['operation'] = \request('operation');
        $res['info'] = CollectRecipe::where('collect_recipe_id', \request('collect_recipe_id'))->first();
        $res['apply_list'] = CollectApply::where('status', ConstDao::EXHIBIT_COLLECT_APPLY_AUDITED)
            ->select('collect_apply_project_name', 'collect_apply_id')->get()->toArray();;
        $res['collect_exhibit_list'] = CollectExhibit::where('collect_recipe_id', request('collect_recipe_id'))->get();
        return view('admin.exhibitcollect.getin_add', $res);
    }

    public function get_item_info(){
        $exhibit_sum_register_id = \request('exhibit_sum_register_id');
        $exhibit = Exhibit::findOrNew($exhibit_sum_register_id);
        return response_json(1, $exhibit->toArray());
    }

    /**
     * 保存入馆信息
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function getin_save(Request $request){
        $collect_recipe_id = \request('collect_recipe_id', 0);
        $collect_type = CollectRecipe::findOrNew($collect_recipe_id);
        ///开始处理主要的征集申请单子
        $collect_type->collect_apply_id = \request('collect_apply_id');
        $collect_type->collect_recipe_num = \request('collect_recipe_num');
        $collect_type->collect_recipe_name = \request('collect_recipe_name');
        $collect_type->collect_date = \request('collect_date');
        $collect_type->recipe_num = \request('recipe_num');
        $mark = \request('mark');
        if(empty($mark)){
            $mark = '';
        }
        $collect_type->mark = $mark;
        //开始处理明细
        $list = \request('list', array());
        if(empty($list)){
            return $this->error('请添加明细后保存');
        }
        $collect_type->save();
        foreach($list as $item){
            $exhibit = CollectExhibit::findOrNew($item['exhibit_sum_register_num']);
            foreach($item as $k=>$v){
                $exhibit->$k = $v;
            }
            $exhibit->collect_recipe_id = $collect_type->collect_recipe_id;
            $exhibit->save();
        }
        return $this->success( get_session_url('getin'), '保存成功');
    }

    /**
     * 提交进伪总账
     * @return \Illuminate\Http\JsonResponse
     */
    public function into_sum_account(){
        $ids = \request('ids');
        //判断是否所有的提交单子都是未进入总账的
        $count = CollectRecipe::where('status', ConstDao::EXHIBIT_COLLECT_RECIPE_STATUS_SUBMITED)->whereIn('collect_recipe_id',$ids)->count();
        if($count > 0){
            return response_json(0,array(),'提交内容中包含已提交过的单据');
        }
        //修改状态
        foreach($ids as $id){
            ExchibitDao::CopyRecipe2Exhibit($id);
        }
        return response_json(1,array(),"操作成功");
    }
}
