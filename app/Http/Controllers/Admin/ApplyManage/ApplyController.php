<?php

namespace App\Http\Controllers\Admin\ApplyManage;

use App\Dao\ConstDao;
use App\Dao\ExchibitDao;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Accident;
use App\Models\CollectApply;
use App\Models\Exhibit;
use App\Models\Exhibit2Room;
use App\Models\ExhibitLogout;
use App\Models\ExhibitRepair\InsideRepair;
use App\Models\ExhibitRepair\OutsideRepair;
use App\Models\ExhibitRepair\RepairApply;
use App\Models\ExhibitUse;
use App\Models\ExhibitUsedApply;
use App\Models\ExhibitUseItem;
use App\Models\FakeExhibit;
use App\Models\IdentifyApply;
use App\Models\ShowApply;
use App\Models\Storageroommanage\RoomList;
use App\Models\Subsidiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class ApplyController extends BaseAdminController
{
    public function export_collect_apply(){
        $type = \request('apply_type', ConstDao::APPLY_TYPE_COLLECT);
        $res['type'] = $type;
        if($type == ConstDao::APPLY_TYPE_COLLECT){
            //征集申请
            $res['exhibit_list'] = CollectApply::whereIn('status', array_keys(ConstDao::$collect_apply_desc))->paginate(parent::PERPAGE);
            return view('admin.applymanage.collect_apply', $res);
        }
        elseif($type == ConstDao::APPLY_TYPE_IDENTIFY) {
            //鉴定申请
            $exhibit_list = IdentifyApply::whereIn('status', array_keys(ConstDao::$identify_desc))->paginate(parent::PERPAGE);
            //添加展品信息
            foreach ($exhibit_list as $key => $item) {
                $exhibit_sum_register_id = $item->exhibit_sum_register_id;
                $exhibit_sum_register_ids = explode(',', $exhibit_sum_register_id);

                $new_names = '';
                if (!empty($exhibit_sum_register_ids)) {
                    $list = Exhibit::whereIn('exhibit_sum_register_id', $exhibit_sum_register_ids)->select('name')->get();

                    foreach ($list as $item1) {
                        $name = $item1->name;
                        $new_names = $new_names . $name . ",";
                    }
                }
                $exhibit_list[$key]['exhibit_names'] = $new_names;
            }
            $res['exhibit_list'] = $exhibit_list;
            return view('admin.applymanage.identify_apply', $res);
        } elseif ($type == ConstDao::APPLY_TYPE_STORAGE_CHECK){
        	//库房盘点申请
			$res['exhibit_list']=RoomList::where('apply_status',2)->paginate(parent::PERPAGE);
			return view('admin.applymanage.storageCheck_apply', $res);
		}
		elseif ($type == ConstDao::APPLY_TYPE_LOGOUT){
			//藏品注销申请
			$exhibit_Logout=new ExhibitLogout();
			$res['exhibit_list']=$exhibit_Logout->joinLeft()->where('exhibit_logout.status',1)->paginate(parent::PERPAGE);
			return view('admin.applymanage.logOut_apply', $res);
		}
		elseif($type == ConstDao::APPLY_TYPE_OUTER){
            //出库申请
            $exhibit_list = ExhibitUsedApply::where('status', '!=',ConstDao::EXHIBIT_USED_APPLY_STATUS_DRAFT)->paginate(parent::PERPAGE);
            //添加展品信息
            foreach($exhibit_list as $key=>$item){
                $exhibit_sum_register_id = $item->exhibit_list;
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
            return view('admin.applymanage.exhibit_used_apply', $res);
        }
        elseif($type == ConstDao::APPLY_TYPE_ACCIDENT){
        	//事故申请
            $res['exhibit_list'] = Accident::join('exhibit','exhibit.exhibit_sum_register_id','=','accident.exhibit_sum_register_id')
                ->where('accident.status','!=',ConstDao::ACCIDENT_STATUS_DRAFT)->select('accident_id','name','exhibit_sum_register_num','accident_time','accident_maker','accident_desc','proc_dependy'
                    ,'proc_suggestion','accident.status')->paginate(parent::PERPAGE);
            return view('admin.applymanage.accident_apply', $res);
        }
        elseif ($type == ConstDao::APPLY_TYPE_REPAIR){
			//藏品修复申请
			$repair_type=(\request('repair_type'));
			if ($repair_type=='outside'){
				$res['exhibit_list']=OutsideRepair::where('apply_status',1)->paginate(parent::PERPAGE);
				return view('admin.applymanage.repairexhibit.repairout_apply', $res);
			}elseif ($repair_type=='inside'){
				$res['exhibit_list']=InsideRepair::where('apply_status',1)->paginate(parent::PERPAGE);
				return view('admin.applymanage.repairexhibit.repairin_apply', $res);
			}else{
				$res['exhibit_list']=RepairApply::where('apply_status',1)->paginate(parent::PERPAGE);
				return view('admin.applymanage.repairexhibit.repair_apply', $res);
			}
		}
		elseif($type == ConstDao::APPLY_TYPE_SHOW){
            $res['data'] = ShowApply::where('status','!=',ConstDao::SHOW_APPLY_STATUS_DRAFT)->paginate(parent::PERPAGE);
            return view('admin.applymanage.show_apply', $res);
        }
        elseif($type == ConstDao::APPLY_TYPE_SUMACCOUNT){
            $list = FakeExhibit::whereIn('audit_status',
                array(ConstDao::FAKE_EXHIBIT_STATUS_WAITING_AUDIT, ConstDao::FAKE_EXHIBIT_STATUS_PASS,ConstDao::FAKE_EXHIBIT_STATUS_REFUSE))->paginate(parent::PERPAGE);
            $res['exhibit_list'] = $list;
            return view('admin.applymanage.sumaccount_apply', $res);
        }elseif ($type == ConstDao::APPLY_TYPE_SUBSIDIARY){
			//其它文物登记申请
			$res['exhibit_list']=Subsidiary::where('apply_status',1)->paginate(parent::PERPAGE);
			return view('admin.applymanage.subsidiary', $res);
		}
        elseif($type == ConstDao::APPLY_TYPE_INTO_ROOM){
            //入库申请
            $list = Exhibit2Room::join('exhibit','exhibit.exhibit_sum_register_id','=','exhibit_into_room.exhibit_sum_register_id')->join('storage_room',
                'storage_room.room_number','=','exhibit_into_room.room_number')->select('exhibit_into_room_id','name','room_name','in_room_recipe_num',
                DB::Raw('ldc_exhibit_into_room.status'))->where('exhibit_into_room.type',ConstDao::ACCOUNT_SUM)->get()->toArray();
            $list_2 = Exhibit2Room::join('subsidiary','subsidiary.subsidiary_id','=','exhibit_into_room.exhibit_sum_register_id')->join('storage_room',
                'storage_room.room_number','=','exhibit_into_room.room_number')->select('exhibit_into_room_id','name','room_name','in_room_recipe_num',
                DB::Raw('ldc_exhibit_into_room.status'))->where('exhibit_into_room.type',ConstDao::ACCOUNT_SUB)->get()->toArray();

            $list = array_merge($list_2, $list);
            $total = count($list); //记录总条数
            $perPage =parent::PERPAGE; //每页的记录数 ( 常量 )
            $current_page = \request('page',1); // 当前页
            $path = Paginator::resolveCurrentPath(); // 获取当前的链接"http://localhost/admin/account"
            $list = array_slice($list, ($current_page-1)*$perPage,$perPage);
            $res['paginator'] = new LengthAwarePaginator($list, $total,$perPage, $current_page, [
                'path' => $path ,  //设定个要分页的url地址。也可以手动通过 $paginator ->setPath(‘路径’) 设置
                'pageName' => 'page', //链接的参数名 http://localhost/admin/manage?page=2
            ]);
            $res['exhibit_list'] = $list;
            return view('admin.applymanage.into_room_apply', $res);
        }
        return $this->error('参数有误');
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

    /**
     * 鉴定申请拒绝
     * @return \Illuminate\Http\JsonResponse
     */
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
     * 展品出库申请批量通过
     */
    public function exhibit_outer_pass(){
        $exhibit_use_apply_ids = \request('exhibit_use_apply_ids');
        $count = ExhibitUsedApply::where('status', '!=', ConstDao::EXHIBIT_USED_APPLY_STATUS_WAITING_AUDIT)
            ->whereIn('exhibit_used_apply_id', $exhibit_use_apply_ids)->count();
        if($count>0){
            return response_json('0', '', '选择项包含已审核的项');
        }
        foreach($exhibit_use_apply_ids as $exhibit_use_apply_id){
            //进行申请
            $exhibit_apply_model = ExhibitUsedApply::where('exhibit_used_apply_id', $exhibit_use_apply_id)->first();
            $exhibit_apply_model->status = ConstDao::EXHIBIT_USED_APPLY_STATUS_FINISHED;
            $exhibit_apply_model->save();
            //增加审核单据
            $exhibit_use = new ExhibitUse();
            $exhibit_use->exhibit_use_apply_id = $exhibit_use_apply_id;
            $exhibit_use->depart_name = $exhibit_apply_model->apply_depart_name;
            $exhibit_use->outer_destination = $exhibit_apply_model->outer_destination;
            $exhibit_use->outer_time = $exhibit_apply_model->outer_time;
            $exhibit_use->save();
            //增加审核条目
            $exhibit_ids = $exhibit_apply_model->exhibit_list;
            $exhibit_ids = \json_decode( $exhibit_ids, true);
            $type = $exhibit_ids['type'];
            $exhibit_ids = $exhibit_ids['ids'];
            foreach($exhibit_ids as $exhibit_id){
                $item = new ExhibitUseItem();
                $item->exhibit_sum_register_id = $exhibit_id;
                $item->exhibit_use_id = $exhibit_use->exhibit_use_id;
                $item->type = $type;
                $item->save();
            }
        }
        //对审核通过自动增加审核单据
        return response_json('1', '', '审核通过');
    }

    /**
     * 展品出库申请批量拒绝
     */
    public function exhibit_outer_refuse(){
        $exhibit_use_apply_ids = \request('exhibit_use_apply_ids');
        $count = ExhibitUsedApply::where('status', '!=', ConstDao::EXHIBIT_USED_APPLY_STATUS_WAITING_AUDIT)
            ->whereIn('exhibit_used_apply_id', $exhibit_use_apply_ids)->count();
        if($count>0){
            return response_json('0', '', '选择项包含已审核的项');
        }
        ExhibitUsedApply::whereIn('exhibit_used_apply_id', $exhibit_use_apply_ids)
            ->update(array('status'=>ConstDao::EXHIBIT_USED_APPLY_STATUS_REFUSED));;
        return response_json('1', '', '审核拒绝');
    }

    /**
	 * 藏品注销申请
	 */
	public function logOut_apply(){
		$identify_apply_ids = \request('logOut_apply_ids');
		$apply_type = \request('apply_type');//2 为审核通过 3为审核拒绝
		$exhibit_Logout=new ExhibitLogout();
		//检测是否存在已经审核过的数据
		$count = $exhibit_Logout->where('status', '!=','1')->whereIn('logout_id', $identify_apply_ids)->count();
		if($count>0){
			return response_json(0, array(),'抱歉，所选项存在已审核过或者未提交的数据');
		}else{
			$exhibit_Logout->where('status','1')->whereIn('logout_id', $identify_apply_ids)->update(array('status'=>$apply_type));
			return response_json(1, array(),'操作完成');
		}
	}
	/**
	 * 其它藏品登记申请
	 */
	public function subsidiary_apply(){
		$identify_apply_ids = \request('subsidiary_apply_ids');
		$apply_type = \request('apply_type');//2 为审核通过 3为审核拒绝
		//检测是否存在已经审核过的数据
		$count = Subsidiary::where('apply_status', '!=','1')->whereIn('subsidiary_id', $identify_apply_ids)->count();
		if($count>0){
			return response_json(0, array(),'抱歉，所选项存在已审核过或者未提交的数据');
		}else{
			Subsidiary::where('apply_status','1')->whereIn('subsidiary_id', $identify_apply_ids)->update(array('apply_status'=>$apply_type));
			return response_json(1, array(),'操作完成');
		}
	}
	/**
	 *  库房盘点申请 批量通过
	 */
	public function storageCheck_apply(){
		$identify_apply_ids = \request('storageCheck_apply_ids');
		$apply_type = \request('apply_type');//1 为审核通过 0为审核拒绝
		//检测是否存在已经审核过的数据
		$count = RoomList::where('apply_status', '!=','2')->whereIn('check_id', $identify_apply_ids)->count();
		if($count>0){
			return response_json(0, array(),'抱歉，所选项存在已审核过的数据');
		}else{
			RoomList::where('apply_status','2')->whereIn('check_id', $identify_apply_ids)->update(array('apply_status'=>$apply_type));
			return response_json(1, array(),'操作完成');
		}
	}
	/**
	 *  藏品修复申请 批量通过
	 */
	public function repair_apply(){
		$identify_apply_ids = \request('repair_apply_ids');
		$type = \request('type');
		$apply_type = \request('apply_type');//2 为审核通过 3为审核拒绝
		if ($type=='inside'){
			//检测是否存在已经审核过的数据
			$count = InsideRepair::where('apply_status', '!=','1')->whereIn('inside_repair_id', $identify_apply_ids)->count();
			if($count>0){
				return response_json(0, array(),'抱歉，所选项存在已审核过的数据');
			}else{
				InsideRepair::where('apply_status','1')->whereIn('inside_repair_id', $identify_apply_ids)->update(array('apply_status'=>$apply_type));
				return response_json(1, array(),'操作完成');
			}
		}elseif ($type=='outside'){
			//检测是否存在已经审核过的数据
			$count = OutsideRepair::where('apply_status', '!=','1')->whereIn('outside_repair_id', $identify_apply_ids)->count();
			if($count>0){
				return response_json(0, array(),'抱歉，所选项存在已审核过的数据');
			}else{
				OutsideRepair::where('apply_status','1')->whereIn('outside_repair_id', $identify_apply_ids)->update(array('apply_status'=>$apply_type));
				return response_json(1, array(),'操作完成');
			}
		}else{
			//检测是否存在已经审核过的数据
			$count = RepairApply::where('apply_status', '!=','1')->whereIn('repair_id', $identify_apply_ids)->count();
			if($count>0){
				return response_json(0, array(),'抱歉，所选项存在已审核过的数据');
			}else{
				RepairApply::where('apply_status','1')->whereIn('repair_id', $identify_apply_ids)->update(array('apply_status'=>$apply_type));
				return response_json(1, array(),'操作完成');
			}
		}
	}

    /**
     * 审核完成
     * @return \Illuminate\Http\JsonResponse
     */
	public function accident_audit(){
	    $audit = \request('audit');
	    $accident_ids = \request('accident_id');
	    if(empty($accident_ids)){
            return response_json(0, array(),'参数有误');
        }
        $count = Accident::whereIn('accident_id', $accident_ids)->where('status', '!=', ConstDao::ACCIDENT_STATUS_WAITING_AUDIT)->count();
        if($count>0){
            return response_json(0, array(),'抱歉，所选项存在已审核过的数据');
        }
	    if($audit){
	        //审核通过
            Accident::whereIn('accident_id', $accident_ids)->update(array('status'=>ConstDao::ACCIDENT_STATUS_AUDIENTED));
        }else{
	        //审核拒绝
            Accident::whereIn('accident_id', $accident_ids)->update(array('status'=>ConstDao::ACCIDENT_STATUS_REFUSE));
        }
	    return response_json(1,array(),'审核完成');
    }


    /**
     * 审核完成
     * @return \Illuminate\Http\JsonResponse
     */
    public function show_audit(){
        $show_apply_id = \request('show_apply_id');
        $audit = \request('audit');
        if(empty($show_apply_id) || !is_array($show_apply_id)){
            return response_json(0,array(),'参数错误');
        }
        $count = ShowApply::whereIn('show_apply_id', $show_apply_id)->where('status','!=', ConstDao::SHOW_APPLY_STATUS_WAITING_AUDIT)->count();
        if($count>0){
            return response_json(0,array(),'包含已经审核的项');
        }
        ShowApply::whereIn('show_apply_id', $show_apply_id)->update(array('status'=>$audit));
        return response_json(1,array(),'审核完成');
    }


    public function fake_exhibit_audit(){
        $fake_exhibit_sum_register_id = \request('fake_exhibit_sum_register_id');
        $audit_status = \request('audit_status');
        if(empty($fake_exhibit_sum_register_id) || !is_array($fake_exhibit_sum_register_id)){
            return response_json(0,array(),'参数错误');
        }
        $count = FakeExhibit::whereIn('fake_exhibit_sum_register_id', $fake_exhibit_sum_register_id)->where('audit_status', '!=', ConstDao::FAKE_EXHIBIT_STATUS_WAITING_AUDIT)->count();
        if($count>0){
            return response_json(0,array(),'包含已审核的项');
        }
        if($audit_status == ConstDao::FAKE_EXHIBIT_STATUS_PASS){
            FakeExhibit::whereIn('fake_exhibit_sum_register_id',$fake_exhibit_sum_register_id)->update(array('audit_status'=>ConstDao::FAKE_EXHIBIT_STATUS_PASS));
            //复制操作
            foreach($fake_exhibit_sum_register_id as $id){
                ExchibitDao::copyFakeExhibit2Exhibit($id);
            }
            return response_json(1,array(),'操作成功');
        }elseif($audit_status == ConstDao::FAKE_EXHIBIT_STATUS_REFUSE){
            FakeExhibit::whereIn('fake_exhibit_sum_register_id',$fake_exhibit_sum_register_id)->update(array('audit_status'=>ConstDao::FAKE_EXHIBIT_STATUS_REFUSE));
            return response_json(1,array(),'操作成功');
        }else{
            return response_json(0,array(),'参数错误');
        }
    }

    /**
     * 入库申请完成
     * @return \Illuminate\Http\JsonResponse
     */
    public function into_room_audit(){
        $exhibit_into_room_id = \request('exhibit_into_room_id');
        $audit = \request('audit');
        if(empty($exhibit_into_room_id) || !is_array($exhibit_into_room_id)){
            return response_json(0,[],'参数错误');
        }
        $count = Exhibit2Room::where('status', '!=', ConstDao::EXHIBIT_INTO_ROOM_STATUS_WAITING_AUDIT)->whereIn('exhibit_into_room_id', $exhibit_into_room_id)->count();
        if($count>0){
            return response_json(0,[],'包含已审核的项');
        }
        Exhibit2Room::whereIn('exhibit_into_room_id', $exhibit_into_room_id)->update(array('status'=>$audit));
        //修改项
        $exhibit2rooms = Exhibit2Room::whereIn('exhibit_into_room_id',$exhibit_into_room_id)->get();
        if($audit == ConstDao::EXHIBIT_INTO_ROOM_STATUS_PASS){
            foreach ($exhibit2rooms as $exhibit2room){
                //分开处理
                if($exhibit2room->type == ConstDao::ACCOUNT_SUM){
                    Exhibit::where('exhibit_sum_register_id', $exhibit2room->exhibit_sum_register_id)->update(array('room_number'=>$exhibit2room->room_number
                    ,'frame_id'=>$exhibit2room->frame_id));
                }else{
                    Subsidiary::where('subsidiary_id', $exhibit2room->exhibit_sum_register_id)->update(array('room_number'=>$exhibit2room->room_number
                    ,'frame_id'=>$exhibit2room->frame_id));
                }
            }
        }

        return response_json(1,[],'审核完成');
    }
}
