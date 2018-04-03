<?php

namespace App\Http\Controllers\Admin\ExhibitIdentify;

use App\Dao\ConstDao;
use App\Models\IdentifyApply;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseAdminController;

/**
 * 鉴定相关功能
 * Class ExhibitController
 * @package App\Http\Controllers\Admin\ExhibitIdentify
 */
class ExhibitController extends BaseAdminController
{
    /**
     * 申请列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function apply(){
        $res['exhibit_list'] = IdentifyApply::paginate(parent::PERPAGE);
        return view('admin.exhibitidentify.apply', $res);
    }

    /**
     * 鉴定申请保存，信息编辑
     */
    public function apply_save(Request $request){
        $identify_apply_id = \request('identify_apply_id');
        $info = IdentifyApply::findorNew($identify_apply_id);
        $data = $request->all();
        foreach($data as $key=>$v){
            if($key == "_token") continue;
            $info->$key = $v;
        }
        $info->status = ConstDao::EXHIBIT_IDENTIFY_APPLY_DRAFT;
        $info->save();
        return $this->success('apply','操作完成');
    }

    /**
     * 申请提交审核
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function apply_submit(){
        $ids = \request('identify_apply_id');
        //判断申请是否都是草稿状态
        $count = IdentifyApply::where('status','!=', ConstDao::EXHIBIT_IDENTIFY_APPLY_DRAFT)->whereIn('identify_apply_id', $ids)->count();
        if($count>0){
            return $this->error('抱歉所选申请中包含已经提交过的申请');
        }
        IdentifyApply::whereIn('identify_apply_id', $ids)->update(array('status'=>ConstDao::EXHIBIT_IDENTIFY_APPLY_WAITING_AUDIT));
        return $this->success('apply','操作完成');
    }



    /**
     * 申请删除
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function apply_del(){
        $identify_apply_id = \request('identify_apply_id');
        IdentifyApply::where('identify_apply_id', $identify_apply_id)->delete();
        return $this->success('apply','操作成功');
    }


    public function add_identify_result(){
        return view('admin.exhibitidentify.add_identify_result');
    }

    /**
     * 展示添加按钮
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){
        $identify_apply_id = \request('identify_apply_id');
        $res['info'] = IdentifyApply::findorNew($identify_apply_id);
        return view('admin.exhibitidentify.add', $res);
    }

    /**
     * 鉴定管理
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manage(){
        $item['date'] = '2018-01-26';
        $item['depart_name'] = '祺皇贵太妃之...';
        $item['identify_date'] = '2018-03-26';
        $item['identify_author'] = '里拉';
        $item['identify_danwei'] = 'A单位';
        $item['status'] = '审核通过';
        $item['author'] = '系统管理员';
        $res['exhibit_list'] = array($item);
        return view('admin.exhibitidentify.manage', $res);
    }

    /**
     * 鉴定专家管理
     */
    public function expert(){
        $item['name'] = '里拉';
        $item['sex'] = '男';
        $item['status'] = '已启用';
        $item['job'] = '主任';
        $item['rank'] = '专家';
        $item['depart'] = '文物部门';
        $item['depart'] = '文物部门';
        $item['result'] = '结果如下...';
        $item['goodat'] = '文物鉴定';
        $item['phone'] = '84849847';
        $res['exhibit_list'] = array($item);
        return view('admin.exhibitidentify.expert', $res);
    }

    /**
     * 新增鉴定专家
     */
    public function expert_add(){
        return view('admin.exhibitidentify.expert_add');
    }
}
