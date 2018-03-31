<?php

namespace App\Http\Controllers\Admin\Statics;

use App\Http\Controllers\Admin\BaseAdminController;

class RepaireController extends BaseAdminController
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
        $res['chart_x'] = json_encode(array('2017-10-01','2017-11-01','2017-12-01','2018-01-01','2018-02-01','2018-03-01'));
        $res['chart_data_child'] = json_encode(array(10,6,8,7,9,12));
        return view('admin.statics.repair', $res);
	}
}