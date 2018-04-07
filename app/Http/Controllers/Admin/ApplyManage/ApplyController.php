<?php

namespace App\Http\Controllers\Admin\ApplyManage;

use App\Dao\ConstDao;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\CollectApply;
use App\Models\Exhibit;
use App\Models\ExhibitLogout;
use App\Models\IdentifyApply;
use App\Models\Storageroommanage\RoomList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApplyController extends BaseAdminController
{
    public function export_collect_apply(){
        $type = \request('apply_type', ConstDao::APPLY_TYPE_COLLECT);
        $res['type'] = $type;
        if($type == ConstDao::APPLY_TYPE_COLLECT){
            $res['exhibit_list'] = CollectApply::whereIn('status', array_keys(ConstDao::$collect_apply_desc))->paginate(parent::PERPAGE);
            return view('admin.applymanage.collect_apply', $res);
        }elseif($type == ConstDao::APPLY_TYPE_IDENTIFY){
            $exhibit_list = IdentifyApply::whereIn('status', array_keys(ConstDao::$identify_desc))->paginate(parent::PERPAGE);
            //添加展品信息
            foreach($exhibit_list as $key=>$item){
                $exhibit_sum_register_id = $item->exhibit_sum_register_id;
                $exhibit_sum_register_ids = explode(',',$exhibit_sum_register_id);

                $new_names = '';
                if(!empty($exhibit_sum_register_ids)){
                    $list = Exhibit::whereIn('exhibit_sum_register_id',$exhibit_sum_register_ids)->select('name')->get();

                    foreach($list as $item1){
                        $name = $item1->name;
                        $new_names = $new_names.$name.",";
                    }
                }
                $exhibit_list[$key]['exhibit_names'] = $new_names;
            }
            $res['exhibit_list'] = $exhibit_list;
            return view('admin.applymanage.identify_apply', $res);
        }elseif ($type == ConstDao::APPLY_TYPE_STORAGE_CHECK){
        	//库房盘点申请
			$res['exhibit_list']=RoomList::where('apply_status',2)->paginate(parent::PERPAGE);
			return view('admin.applymanage.storageCheck_apply', $res);
		}elseif ($type == ConstDao::APPLY_TYPE_LOGOUT){
			//藏品注销申请
			$exhibit_Logout=new ExhibitLogout();
			$res['exhibit_list']=$exhibit_Logout->joinLeft()->where('status',1)->paginate(parent::PERPAGE);
			return view('admin.applymanage.logOut_apply', $res);
		}
    }

    /**
     * 批量审核通过
     */
    public function collect_apply_pass(){
        $collect_apply_ids = \request('collect_apply_ids');
        //检测是否存在已经审核过的数据
        $count = CollectApply::where('status', '!=',ConstDao::EXHIBIT_COLLECT_APPLY_WAITING_AUDIT)->whereIn('collect_apply_id', $collect_apply_ids)->count();
        if($count>0){
            return response_json(0, array(),'抱歉，所选项存在已审核过的数据');
        }else{
            CollectApply::where('status',ConstDao::EXHIBIT_COLLECT_APPLY_WAITING_AUDIT)->whereIn('collect_apply_id', $collect_apply_ids)->update(array('status'=>
            ConstDao::EXHIBIT_COLLECT_APPLY_AUDITED));
            return response_json(1, array(),'操作完成');
        }
    }

    /**
     * 征集申请拒绝
     * @return \Illuminate\Http\JsonResponse
     */
    public function collect_apply_refuse(){
        $collect_apply_ids = \request('collect_apply_ids');
        //检测是否存在已经审核过的数据
        $count = CollectApply::where('status', '!=',ConstDao::EXHIBIT_COLLECT_APPLY_WAITING_AUDIT)->whereIn('collect_apply_id', $collect_apply_ids)->count();
        if($count>0){
            return response_json(0, array(),'抱歉，所选项存在已审核过的数据');
        }else{
            CollectApply::where('status',ConstDao::EXHIBIT_COLLECT_APPLY_WAITING_AUDIT)->whereIn('collect_apply_id', $collect_apply_ids)->update(array('status'=>
                ConstDao::EXHIBIT_COLLECT_APPLY_REFUSED));
            return response_json(1, array(),'操作完成');
        }
    }

    /**
     * 鉴定申请 批量通过
     */
    public function identify_apply_pass(){
        $identify_apply_ids = \request('identify_apply_ids');
         //检测是否存在已经审核过的数据
        $count = IdentifyApply::where('status', '!=',ConstDao::EXHIBIT_IDENTIFY_APPLY_WAITING_AUDIT)->whereIn('identify_apply_id', $identify_apply_ids)->count();
        if($count>0){
            return response_json(0, array(),'抱歉，所选项存在已审核过的数据');
        }else{
            IdentifyApply::where('status',ConstDao::EXHIBIT_COLLECT_APPLY_WAITING_AUDIT)->whereIn('identify_apply_id', $identify_apply_ids)->update(array('status'=>
                ConstDao::EXHIBIT_IDENTIFY_APPLY_AUDITED));
            return response_json(1, array(),'操作完成');
        }
    }

    public function identify_apply_refuse(){
        $identify_apply_ids = \request('identify_apply_ids');
        //检测是否存在已经审核过的数据
        $count = IdentifyApply::where('status', '!=',ConstDao::EXHIBIT_IDENTIFY_APPLY_WAITING_AUDIT)->whereIn('identify_apply_id', $identify_apply_ids)->count();
        if($count>0){
            return response_json(0, array(),'抱歉，所选项存在已审核过的数据');
        }else{
            IdentifyApply::where('status',ConstDao::EXHIBIT_COLLECT_APPLY_WAITING_AUDIT)->whereIn('identify_apply_id', $identify_apply_ids)->update(array('status'=>
                ConstDao::EXHIBIT_IDENTIFY_APPLY_REFUSED));
            return response_json(1, array(),'操作完成');
        }
    }
	/**
	 * 藏品注销申请 批量通过
	 */
	public function logOut_apply_pass(){
		$identify_apply_ids = \request('logOut_apply_ids');
		$exhibit_Logout=new ExhibitLogout();
		//检测是否存在已经审核过的数据
		$count = $exhibit_Logout->where('status', '!=','1')->whereIn('logout_id', $identify_apply_ids)->count();
		if($count>0){
			return response_json(0, array(),'抱歉，所选项存在已审核过或者未提交的数据');
		}else{
			$exhibit_Logout->where('status','1')->whereIn('logout_id', $identify_apply_ids)->update(array('status'=>'2'));
			return response_json(1, array(),'操作完成');
		}
	}

	public function logOut_apply_refuse(){
		$identify_apply_ids = \request('logOut_apply_ids');
		$exhibit_Logout=new ExhibitLogout();
		//检测是否存在已经审核过的数据
		$count = $exhibit_Logout->where('status', '!=','1')->whereIn('logout_id', $identify_apply_ids)->count();
		if($count>0){
			return response_json(0, array(),'抱歉，所选项存在已审核过或者未提交的数据');
		}else{
			$exhibit_Logout->where('status','1')->whereIn('logout_id', $identify_apply_ids)->update(array('status'=>'3'));
			return response_json(1, array(),'操作完成');
		}
	}
	/**
	 *  库房盘点申请 批量通过
	 */
	public function storageCheck_apply_pass(){
		$identify_apply_ids = \request('storageCheck_apply_ids');
		//检测是否存在已经审核过的数据
		$count = RoomList::where('apply_status', '!=','2')->whereIn('check_id', $identify_apply_ids)->count();
		if($count>0){
			return response_json(0, array(),'抱歉，所选项存在已审核过的数据');
		}else{
			RoomList::where('apply_status','2')->whereIn('check_id', $identify_apply_ids)->update(array('apply_status'=>'1'));
			return response_json(1, array(),'操作完成');
		}
	}

	public function storageCheck_apply_refuse(){
		$identify_apply_ids = \request('storageCheck_apply_ids');
		//检测是否存在已经审核过的数据
		$count = RoomList::where('apply_status', '!=','2')->whereIn('check_id', $identify_apply_ids)->count();
		if($count>0){
			return response_json(0, array(),'抱歉，所选项存在已审核过的数据');
		}else{
			RoomList::where('apply_status','2')->whereIn('check_id', $identify_apply_ids)->update(array('apply_status'=>'0'));
			return response_json(1, array(),'操作完成');
		}
	}
}
