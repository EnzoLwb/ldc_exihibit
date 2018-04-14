<?php

namespace App\Http\Controllers\Admin\DigitalSearch;

use App\Dao\ConstDao;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Exhibit;
use Faker\Provider\Base;
use function GuzzleHttp\Psr7\_parse_request_uri;
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

    /**
     * 自定义查询
     */
    public function custom_exhibit(Request $request){
        $all = $request->all();
        $except = array('status', 'exhibit_level','_token');
        $query = Exhibit::query();
        foreach($all as $k=>$v){
            if(!in_array($k, $except)){
                if(!empty($v)){
                    $query->where($k,'like', '%'.$v.'%');
                }
            }
            if($k == 'status'){
                if($v == ConstDao::EXHIBIT_STATUS_IN_ROOM){
                    $query->where('status', $v);
                }else{
                    $query->where('status', '!=', ConstDao::EXHIBIT_STATUS_IN_ROOM);
                }
            }
            if($k == 'exhibit_level'){
                $query->where('exhibit_level', $v);
            }
        }
        $res['exhibit_list'] = $query->paginate(parent::PERPAGE);
        return view('admin.digitalsearch.exhibit.custom_exhibit',$res);
    }
}
