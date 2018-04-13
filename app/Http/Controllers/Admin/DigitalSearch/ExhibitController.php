<?php

namespace App\Http\Controllers\Admin\DigitalSearch;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Exhibit;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExhibitController extends BaseAdminController
{
    /**
     * 展品的总和查询
     */
    public function index(){
        $exhibit_level = request('exhibit_level');
        $type = request('type');
        $query = null;
        $list = array();
        if(!empty($exhibit_level)){
            $query = Exhibit::where('exhibit_level', $exhibit_level);
        }
        if(!empty($type)){
            if(!empty($query)){
                $query->where('type','like','%'.$type.'%');
            }else{
                $query = Exhibit::where('type','like','%'.$type.'%');
            }
        }
        if(empty($query)){
            $list = Exhibit::paginate(parent::PERPAGE);
        }else{
            $list = $query->paginate(parent::PERPAGE);
        }
        $res['exhibit_list'] = $list;
        return view('admin.digitalsearch.exhibit.exhibit',$res);
    }
}
