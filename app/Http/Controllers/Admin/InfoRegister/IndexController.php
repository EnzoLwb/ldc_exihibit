<?php

namespace App\Http\Controllers\Admin\InfoRegister;

use App\Dao\ConstDao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Http\Controllers\Admin\BaseAdminController;
use App\Models\FakeExhibit;

class IndexController extends BaseAdminController
{
    /**
     * 馆藏文物管理
     */
    public function exhibitmanage(){
        $list = FakeExhibit::paginate(parent::PERPAGE);
        $res['exhibit_list'] = $list;
        return view('admin.inforegister.exhibit',$res);
    }

    /**
     * 新增文物信息
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_exhibit(){
        $info = FakeExhibit::find(\request('fake_exhibit_sum_register_id'));
        if(empty($info)){
            return $this->error('参数有误');
        }
        $res['info'] = $info;
        return view('admin.inforegister.add_exhibit', $res);
    }

    /**
     * 保存伪总账信息
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function fake_exhibit_save(Request $request){
        $fake_exhibit_sum_register_id = \request('fake_exhibit_sum_register_id');
        $fake_exhibit = FakeExhibit::find($fake_exhibit_sum_register_id);
        if(empty($fake_exhibit)){
            return $this->error('参数错误');
        }
        $except = array('_token','fake_exhibit_sum_register_id');
        $all = $request->all();
        foreach($all as $k=>$v){
            if(!in_array($k, $except)){
                $fake_exhibit->$k = $v;
            }

        }
        $fake_exhibit->save();
       return $this->success('exhibitmanage','保存成功');
    }

    /**
     * 提交进审核
     * @return \Illuminate\Http\JsonResponse
     */
    public function fake_exhibit_submit(){
        $fake_exhibit_sum_register_id = \request('fake_exhibit_sum_register_id');
        if(empty($fake_exhibit_sum_register_id) || !is_array($fake_exhibit_sum_register_id)){
            return response_json(0,[],'参数有误');
        }
        $count = FakeExhibit::whereIn('fake_exhibit_sum_register_id', $fake_exhibit_sum_register_id)->where('audit_status','!=', ConstDao::FAKE_EXHIBIT_STATUS_DRAFT)->count();
        if($count>0){
            return response_json(0,[],'包含已审核的项');
        }
        FakeExhibit::whereIn('fake_exhibit_sum_register_id', $fake_exhibit_sum_register_id)->update(array('audit_status'=>ConstDao::FAKE_EXHIBIT_STATUS_WAITING_AUDIT));
        return response_json(1,[],'提交成功');
    }


    /**
     * 选择辅助账种类
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function subsidiary(){
        $item['collect_depart'] = '文物部';
        $item['sum_num'] = '0036';
        $item['class_num'] = '01';
        $item['in_museum_num'] = 'RG003';
        $item['name'] = '玉立人';
        $item['ori_name'] = '玉立人';
        $item['niandai_leixing'] = '出土年代';
        $item['juti_niandai'] = '新石器时代';
        $item['history_'] = '';

        $item1['collect_depart'] = '文物部';
        $item1['sum_num'] = 'ZZDJH002';
        $item1['class_num'] = '002';
        $item1['in_museum_num'] = 'RG00056';
        $item1['name'] = '经箱';
        $item1['ori_name'] = '经箱';
        $item1['niandai_leixing'] = '出土年代';
        $item1['juti_niandai'] = '开元年';
        $item1['history_'] = '';
        $res['exhibit_list'] = array($item,$item1);
        return view('admin.inforegister.subsidiary', $res);
    }

    /**
     * 添加辅助账种类
     */
    public function add_subsidiary(){
        return view('admin.inforegister.add_subsidiary');
    }
}
