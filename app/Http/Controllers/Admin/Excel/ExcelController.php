<?php

namespace App\Http\Controllers\Admin\Excel;

use App\Dao\ConstDao;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\CollectApply;
use App\Models\CollectExhibit;
use App\Models\CollectRecipe;
use App\Models\ExhibitUse;
use App\Models\ExhibitUsedApply;
use App\Models\FakeExhibit;
use App\Models\IdentifyApply;
use App\Models\ReturnStorage;
use App\Models\ShowApply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Exhibit;
use App\Models\Disinfection;
use Illuminate\Support\Facades\DB;
use App\Models\Accident;
use App\Models\ShowPosition;
use App\Models\PositionAndExhibit;
use App\Models\Frame;

class ExcelController extends BaseAdminController
{


    /**
     * 导出征集申请的行数据
     */
    public function export_collect_apply(){
        $collect_apply_ids = request('collect_apply_ids');
        $res = CollectApply::whereIn("collect_apply_id", $collect_apply_ids)->get()->toArray();
        $xls_data = array();
        $header = ['登记日期','征集申请单号','征集申请单位名称',
            '征集采购对象','征集项目名称','申请部门','所需征集经费',
            '申请征集数量','申请人','具体征集项目介绍','征集原因'];
        $xls_data[] = $header;
        foreach($res as $key=> $item)
        {
            unset($res[$key]['files']);
            $xls_data[] = array(
                $item['register_date'],
                $item['collect_apply_num'],
                $item['collect_apply_depart_name'],
                $item['collect_buy_object'],
                $item['collect_apply_project_name'],
                $item['apply_depart'],
                $item['need_fee'],
                $item['collect_exhibit_count'],
                $item['applyer'],
                $item['collect_project_desc'],
                $item['collect_reason'],
            );
        }
        Excel::create('展品征集申请表', function ($excel) use ($xls_data) {
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
                    'K'     =>  25,
                ));
                $sheet->rows($xls_data);
            });
        })->export('xls');
    }

    /**
     * 导出征集单据
     */
    public function export_collect_recipe(){
        $collect_apply_ids = request('collect_recipe_ids');
        $res = CollectRecipe::whereIn("collect_recipe_id", $collect_apply_ids)->get()->toArray();
        $xls_data = array();
        $header = ['入馆凭证号','入馆凭证名称','入馆日期',
            '收据号','备注','藏品名称'];
        $xls_data[] = $header;
        foreach($res as $key=> $item)
        {
            $recipe_id = $item['collect_recipe_id'];
            $exhibit_list = CollectExhibit::where('collect_recipe_id', $recipe_id)->get();
            $names = '';
            foreach ($exhibit_list as $exhibit){
                $names .= $exhibit->name."#";
            }
            unset($res[$key]['files']);
            $xls_data[] = array(
                $item['collect_recipe_num'],
                $item['collect_recipe_name'],
                $item['collect_date'],
                $item['recipe_num'],
                $item['mark'],
                $names
            );
        }

        Excel::create('入馆凭证单据', function ($excel) use ($xls_data) {
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
                    'K'     =>  25,
                ));
                $sheet->rows($xls_data);
            });
        })->export('xls');
    }


    /**
     * 导出鉴定申请的单子
     */
    public function  export_identify_apply(){
        $collect_apply_ids = request('identify_apply_ids');
        $res = IdentifyApply::whereIn("identify_apply_id", $collect_apply_ids)->get()->toArray();
        $xls_data = array();
        $header = ['登记日期','鉴定申请单位名称','拟检定日期',
            '拟鉴定专家','拟鉴定单位','状态','登记人','关联展品'
            ];
        $xls_data[] = $header;
        foreach($res as $key=> $item)
        {
            $exhibit_sum_register_id = $item['exhibit_sum_register_id'];
            $exhibit_sum_register_ids = explode(',',$exhibit_sum_register_id);

            $new_names = '';
            if(!empty($exhibit_sum_register_ids)){
                $list = Exhibit::whereIn('exhibit_sum_register_id',$exhibit_sum_register_ids)->select('name')->get();

                foreach($list as $item1){
                    $name = $item1->name;
                    $new_names = $new_names.$name.",";
                }
            }

            $xls_data[] = array(
                $item['register_date'],
                $item['identify_apply_depart'],
                $item['identify_date'],
                $item['identify_expert'],
                $item['identify_depart'],
                ConstDao::$identify_desc[$item['status']],
                $item['register'],
                $new_names
            );
        }
        Excel::create('鉴定申请表', function ($excel) use ($xls_data) {
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
                ));
                $sheet->rows($xls_data);
            });
        })->export('xls');
    }


    /**
     * 导出消毒记录的单子
     */
    public function export_disinfection(){
        $disinfection_ids = \request('disinfection_id');
        $xls_data = array();
        $header = ['藏品名称','总登记号','清洁方式',
            '消毒方式','清洁日期','记录人'
        ];
        $xls_data[] = $header;
        $list = Disinfection::join('exhibit','disinfection.exhibit_sum_register_id','=','exhibit.exhibit_sum_register_id')
            ->whereIn('disinfection_id', $disinfection_ids)
            ->orderBy('clean_date','desc')->get();
        foreach ($list as $item){
            $xls_item = array($item->name, $item->exhibit_sum_register_num, $item->clean_way, $item->disinfection_way, $item->clean_date,$item->recorder );
            $xls_data[] = $xls_item;
        }
        Excel::create('消毒记录表', function ($excel) use ($xls_data) {
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
                ));
                $sheet->rows($xls_data);
            });
        })->export('xls');
    }

    /**
     * 导出出库申请单子
     */
    public function export_outer_apply(){
        $exhibit_used_apply_id = \request('exhibit_used_apply_id');
        $xls_data = array();
        $header = ['申请部门名称','经办人','联系人',
            '联系方式','出库时间','出库目的','展品列表','状态'
        ];
        $xls_data[] = $header;
        $list = ExhibitUsedApply::whereIn('exhibit_used_apply_id', $exhibit_used_apply_id)->get();
        foreach($list as $key=>$item){
            $exhibit_ids = $item->exhibit_list;
            $exhibit_ids = explode(',', $exhibit_ids);
            $exhibits = Exhibit::whereIn('exhibit_sum_register_id', $exhibit_ids)->get();
            $names = '';
            foreach($exhibits as $mm_item){
                $names = $names.$mm_item->name.',';
            }
            $list[$key]->names = $names;
        }
        foreach ($list as $item){
            $xls_item = array($item->apply_depart_name, $item->executer, $item->connectioner, $item->phone, $item->outer_time,
                $item->outer_destination,$item->names , ConstDao::$exhibit_used_apply_desc[$item->status]);
            $xls_data[] = $xls_item;
        }
        Excel::create('出库申请单', function ($excel) use ($xls_data) {
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
                ));
                $sheet->rows($xls_data);
            });
        })->export('xls');
    }

    /**
     * 导出出库单子
     */
    public function export_exhibit_outer(){
        $exhibit_use_ids = \request('exhibit_use_id');
        if(empty($exhibit_use_ids)){
            return $this->error('参数有误');
        }
        $list = ExhibitUse::join('exhibit_use_item','exhibit_use_item.exhibit_use_id','=','exhibit_use.exhibit_use_id')
            ->join('exhibit', 'exhibit.exhibit_sum_register_id', '=', 'exhibit_use_item.exhibit_sum_register_id')
            ->select('depart_name','outer_destination','outer_time','outer_sender','outer_taker','date','name',DB::Raw('ldc_exhibit_use_item.num as num'),
                'backup_time', DB::Raw('ldc_exhibit_use_item.backup as backup'),'exhibit_sum_register_num')
            ->whereIn('exhibit_use.exhibit_use_id', $exhibit_use_ids)->get();
        $xls_data = array();
        $header = ['提供部门','出库目的','出库日期',
            '库房点叫人','提取经手人','日期','藏品名称','件数','归还时间','备注','总登记号'
        ];
        $xls_data[] = $header;
        foreach ($list as $item){
            $xls_item = array($item->depart_name, $item->outer_destination, $item->outer_time, $item->outer_sender,
                $item->outer_taker,$item->date, $item->name,$item->num,$item->backup_time, $item->backup , $item->exhibit_sum_register_num);
            $xls_data[] = $xls_item;
        }
        Excel::create('出库记录表', function ($excel) use ($xls_data) {
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
                ));
                $sheet->rows($xls_data);
            });
        })->export('xls');

    }

    /**
     * 导出事故登记的单子
     */
    public function export_accident(){
        $accident_id = \request('accident_id');
        $xls_data = array();
        $header = ['文物名称','总登记号','事故时间',
            '事故人','事故描述','处理依据','处理意见','状态'
        ];
        $xls_data[] = $header;
        $list = Accident::join('exhibit','accident.exhibit_sum_register_id','=','exhibit.exhibit_sum_register_id')
            ->whereIn('accident_id', $accident_id)
            ->select('accident_id','name','exhibit_sum_register_num','accident_time','accident_maker','accident_desc','proc_dependy'
                ,'proc_suggestion','accident.status')->get();
        foreach ($list as $item){
            $xls_item = array($item->name, $item->exhibit_sum_register_num, $item->accident_time, $item->accident_maker, $item->accident_desc,$item->proc_dependy,
                $item->proc_suggestion, ConstDao::$accident_desc[$item->status]);
            $xls_data[] = $xls_item;
        }
        Excel::create('事故登记表', function ($excel) use ($xls_data) {
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
                ));
                $sheet->rows($xls_data);
            });
        })->export('xls');
    }

    /**
     * 导出展品记录
     */
    public function export_exhibit(){
        $exhibit_sum_register_id = \request('exhibit_sum_register_id');
        if(empty($exhibit_sum_register_id) && !is_array($exhibit_sum_register_id)){
            return $this->error('参数有误');
        }

        $xls_data = array();
        $header = ['总登记号','入馆凭证号','名称',
            '数量','年代','级别','尺寸','重量','完残情况','入馆日期','来源','备注'
        ];
        $xls_data[] = $header;
        $list = Exhibit::whereIn('exhibit_sum_register_id',$exhibit_sum_register_id)->get();

        foreach ($list as $item){
            $xls_item = array($item->exhibit_sum_register_num, $item->collect_recipe_num, $item->name, $item->num, $item->age,$item->exhibit_level,
                $item->size, $item->quality,$item->complete_degree, $item->in_museum_time, $item->src, $item->backup);
            $xls_data[] = $xls_item;
        }
        Excel::create('入库管理表', function ($excel) use ($xls_data) {
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
                ));
                $sheet->rows($xls_data);
            });
        })->export('xls');
    }

    public function export_returnstorage(){
        $return_storage_id = \request('return_storage_id');
        if(empty($return_storage_id) && !is_array($return_storage_id)){
            return $this->error('参数有误');
        }

        $xls_data = array();
        $header = ['藏品名称',
            '退还人','点收人','退还日期','备注','状态'
        ];
        $xls_data[] = $header;
        $list = ReturnStorage::join('exhibit','exhibit.exhibit_sum_register_id','=', 'return_storage.exhibit_sum_register_id')
            ->whereIn('return_storage_id', $return_storage_id)->select('name','returner','taker','return_date','mark',DB::Raw('ldc_return_storage.status as status'))->get();

        foreach ($list as $item){
            $xls_item = array($item->name, $item->returner, $item->taker, $item->return_date, $item->mark,ConstDao::$returnstorage_desc[$item->status]);
            $xls_data[] = $xls_item;
        }
        Excel::create('回库管理表', function ($excel) use ($xls_data) {
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
                ));
                $sheet->rows($xls_data);
            });
        })->export('xls');
    }

    public function export_show_apply(){
        $show_apply_id = \request('show_apply_id');
        if(empty($show_apply_id) || !is_array($show_apply_id)){
            return $this->error('參數有误');
        }
        $xls_data = array();
        $header = ['申请人',
            '申请时间','展览主题','参战人员','展览编号','状态','开始时间','结束时间'
        ];
        $xls_data[] = $header;
        $list = ShowApply::whereIn('show_apply_id', $show_apply_id)->get();
        foreach ($list as $item){
            $xls_item = array($item->applyer, $item->apply_time, $item->theme, $item->exhibitor, $item->show_num,
                ConstDao::$show_apply_desc[$item->status],$item->start_date, $item->end_date);
            $xls_data[] = $xls_item;
        }
        Excel::create('展览申请表', function ($excel) use ($xls_data) {
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
                ));
                $sheet->rows($xls_data);
            });
        })->export('xls');
    }

    public function export_show_position(){
        $show_position_id = \request('show_position_id');
        if(empty($show_position_id) || !is_array($show_position_id)){
            return $this->error('参数有误');
        }
        $xls_data = array();
        $header = ['展位编号','展位名称','展品名称'];
        $xls_data[] = $header;
        $pos_list = ShowPosition::whereIn('show_position_id', $show_position_id)->get();
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
        foreach ($pos_list as $item){
            $xls_item = array($item->num, $item->name, $item->names);
            $xls_data[] = $xls_item;
        }
        Excel::create('展品展览表', function ($excel) use ($xls_data) {
            $excel->sheet('score', function ($sheet) use ($xls_data) {
                $sheet->setWidth(array(
                    'A'     => 20,
                    'B'     =>  25,
                    'C'     =>  25,
                ));
                $sheet->rows($xls_data);
            });
        })->export('xls');
    }

    private function do_export_exhibit($exhibit_list){
        $xls_data = array();
        $header = ['收藏单位','总登记号','原编号','曾用号','入馆凭证','现用名','曾用名','年代类型'
            ,'具体年代','历史阶段','质地类型1','质地类型2','普查质地','具体质地','类别范围','具体类别',
            '传统数量','传统数量单位','实际数量','实际数量单位','具体质量','质量范围','尺寸','长宽高',
            '文物级别','来源方式','具体来源','来源补充','完残程度','完残状况','保存状态',
            '入藏具体时间','入藏年代','入藏时间范围','具体存放地点','原展厅具体位置','展厅柜号',
            '藏品性质','藏品状态','备注'];
        $xls_data[] = $header;
        foreach($exhibit_list as $k=>$v){
            $item = array($v->collect_depart_name, $v->exhibit_sum_register_num, $v->ori_num, $v->used_num, $v->collect_recipe_num, $v->name, $v->used_name,$v->age_type,
                $v->age, $v->history_step, $v->textaure1, $v->textaure2,$v->common_textaure,$v->textaure, $v->range_type, $v->type,
                $v->common_num, $v->common_num_uint, $v->num, $v->num_uint, $v->quality, $v->quality_range, $v->size, $v->lwh,
                $v->exhibit_level, $v->src_way, $v->src, $v->src_addition, $v->complete_degree, $v->complete_info, $v->storage_status,
                $v->in_museum_time, $v->in_museum_age, $v->in_museum_time_range,$v->storage_position, $v->ori_storage_position,$v->storage_status,
                $v->exhibit_property, ConstDao::$exhibit_status_desc[$v->status], $v->dackup);
            $xls_data[] =  $item;
        }
        Excel::create('展品信息表', function ($excel) use ($xls_data) {
            $excel->sheet('score', function ($sheet) use ($xls_data) {
                $sheet->setWidth(array(
                    'A'     => 20,
                    'B'     =>  25,
                    'C'     =>  25,
                ));
                $sheet->rows($xls_data);
            });
        })->export('xls');
    }

    public function export_fake_exhibit(){
        $fake_exhibit_sum_register_id = \request('fake_exhibit_sum_register_id');
        if(empty($fake_exhibit_sum_register_id) || !is_array($fake_exhibit_sum_register_id)){
            return $this->error('参数有误');
        }
        $pos_list = FakeExhibit::whereIn('fake_exhibit_sum_register_id', $fake_exhibit_sum_register_id)->get();
        $this->do_export_exhibit($pos_list);
    }

    public function export_sum_account(){
        $exhibit_sum_register_id = \request('exhibit_sum_register_id');
        $exhibit_list = Exhibit::whereIn('exhibit_sum_register_id',$exhibit_sum_register_id)->get();
        $this->do_export_exhibit($exhibit_list);
    }

    /**
     * 导出排架
     */
    public function export_frame(){
        $frame_ids = \request('frame_id');
        if(empty($frame_ids) || !is_array($frame_ids)){
            return $this->error('参数有误');
        }
        $xls_data = array();
        $header = ['库房名称','库房编号','排架编号','排架名称'];
        $xls_data[] = $header;
        $data = Frame::join('storage_room', 'storage_room.room_number', '=', 'frame.room_number')
            ->whereIn('frame_id', $frame_ids)
            ->select('room_name', DB::Raw('ldc_frame.room_number'), 'frame_number','frame_name')->paginate(parent::PERPAGE);
        foreach($data as $item){
            $xls_data[] = array($item->room_name, $item->room_number, $item->frame_number, $item->frame_name);
        }
        Excel::create('排架信息表', function ($excel) use ($xls_data) {
            $excel->sheet('score', function ($sheet) use ($xls_data) {
                $sheet->setWidth(array(
                    'A'     => 20,
                    'B'     =>  25,
                    'C'     =>  25,
                    'D'     =>  25,
                ));
                $sheet->rows($xls_data);
            });
        })->export('xls');
    }
}
