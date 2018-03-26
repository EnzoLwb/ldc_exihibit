<?php

namespace App\Http\Controllers\Api;

use App\Models\Region;

class RegionController extends Controller
{

	public function __construct()
	{
		parent::_init();
	}

	/**
	 * 省
	 *
	 * @author lxp 20170904
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function province()
	{
		return response_json(1, Region::select('region_id', 'region_name')->where('layer', 2)->get());
	}

	/**
	 * 市
	 *
	 * @author lxp 20170904
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function city()
	{
		$this->validate([
			'parent_id' => 'required'
		]);
		return response_json(1, Region::select('region_id', 'region_name')->where('parent_id', request('parent_id'))->where('layer', 3)->get());
	}

	/**
	 * 区
	 *
	 * @author lxp 20170904
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function district()
	{
		$this->validate([
			'parent_id' => 'required'
		]);
		return response_json(1, Region::select('region_id', 'region_name')->where('parent_id', request('parent_id'))->where('layer', 4)->get());
	}

	/**
	 * 地区全部数据
	 *
	 * @author lxp 20170909
	 * @return \Illuminate\Http\JsonResponse
	 *
	 * @api {GET} /allregion 3. 地区数据
	 * @apiGroup Base
	 * @apiVersion 1.0.0
	 * @apiParam {string} p 平台，i：IOS，a：安卓
	 * @apiSuccess {array} data 数据
	 * @apiSuccess {int} data.region_id 地区id
	 * @apiSuccess {string} data.region_name 地区名称
	 * @apiSuccess {array} data.child 子地区数组
	 * @apiSuccessExample {json} 返回值
	 * {}
	 */
	public function alldata()
	{
		$alldata = Region::select('region_id', 'region_name', 'parent_id')->get();

		$tree = app('tree');
		$tree->setTree($alldata->toArray(), 'region_id', 'parent_id');
		$treedata = $tree->getArrayList(1, null, false, false);

		return response_json(1, $treedata);
	}
}
