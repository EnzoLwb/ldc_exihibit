<?php

namespace App\Http\Controllers\Admin;

use App\Dao\ConstDao;
use App\Models\Exhibit;
use App\Models\FakeExhibit;
use App\Models\Subsidiary;
use Illuminate\Support\Facades\Auth;

class HomeController extends BaseAdminController
{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 后台首页
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('admin.home');
	}

	public function welcome()
	{
	    $groupid = Auth::user()->groupid;

	    $res['groupid'] = $groupid;
	    //藏品数
	    $res['exhibit_num'] = Exhibit::count();
        //复制品数
        $res['copy_num'] = Subsidiary::where('type',1)->count();
        //仿制品数
        $res['copy_by_num'] = Subsidiary::where('type',2)->count();
        //仿制品数
        $res['copy_by_num'] = Subsidiary::where('type',2)->count();
        //资料数
        $res['file_num'] = Subsidiary::where('type',3)->count();
        //资料数
        $res['file_num'] = Subsidiary::where('type',3)->count();
        //在库数
        $res['stay_in_num'] = Exhibit::where('status', ConstDao::EXHIBIT_STATUS_IN_ROOM)->count();
        //代管数
        $res['replace_manage_num'] = Subsidiary::where('type', 5)->count();
        //外借数
        $res['lend_num'] = Subsidiary::where('type', 6)->count();
        //待入账数
        $res['wati_into_account'] = FakeExhibit::where('audit_status',ConstDao::FAKE_EXHIBIT_STATUS_WAITING_AUDIT)->count();
        //待入库数
        $res['wati_into_room'] = Exhibit::where('room_number','')->count();
        //待回库
        $res['wati_back_room'] = Exhibit::whereIn('status',array(ConstDao::EXHIBIT_STATUS_SHOW, ConstDao::EXHIBIT_STATUS_LEND))->count();
        //申请待审核列表
        $max_num = 3;

        return view('admin.welcome',$res);
	}
}

