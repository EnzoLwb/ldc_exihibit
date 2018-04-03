<?php

namespace App\Http\Controllers\Admin\Excel;

use App\Dao\ConstDao;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\CollectApply;
use App\Models\CollectExhibit;
use App\Models\CollectRecipe;
use App\Models\IdentifyApply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

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


    public function  export_identify_apply(){
        $collect_apply_ids = request('identify_apply_ids');
        $res = IdentifyApply::whereIn("identify_apply_id", $collect_apply_ids)->get()->toArray();
        $xls_data = array();
        $header = ['登记日期','鉴定申请单位名称','拟检定日期',
            '拟鉴定专家','拟鉴定单位','状态','登记人'
            ];
        $xls_data[] = $header;
        foreach($res as $key=> $item)
        {
            $xls_data[] = array(
                $item['register_date'],
                $item['identify_apply_depart'],
                $item['identify_date'],
                $item['identify_expert'],
                $item['identify_depart'],
                ConstDao::$identify_desc[$item['status']],
                $item['register'],
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
}
