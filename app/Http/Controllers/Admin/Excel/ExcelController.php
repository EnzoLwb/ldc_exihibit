<?php

namespace App\Http\Controllers\Admin\Excel;

use App\Dao\ConstDao;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\CollectApply;
use App\Models\CollectExhibit;
use App\Models\CollectRecipe;
use App\Models\ExhibitUse;
use App\Models\ExhibitUsedApply;
use App\Models\IdentifyApply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Exhibit;
use App\Models\Disinfection;
use Illuminate\Support\Facades\DB;

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
}
