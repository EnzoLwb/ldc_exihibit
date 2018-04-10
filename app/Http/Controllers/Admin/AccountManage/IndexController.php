<?php

namespace App\Http\Controllers\Admin\AccountManage;

use App\Models\Subsidiary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Exhibit;
use Maatwebsite\Excel\Facades\Excel;

class IndexController extends BaseAdminController
{

    /**
     * 总账列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sumaccount(){
        $list = Exhibit::paginate(parent::PERPAGE);
        $res['exhibit_list'] = $list;
        return view('admin.accountmanage.sumaccount', $res);
    }


    /**
     * 总账修改
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_sumaccount(){

        return view('admin.accountmanage.add_sumaccount');
    }


    /**
     * 辅助账列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function subsidiary(Request $request){
    	$type=$request->type;

    	if (isset($type)){
			$exhibit_list=Subsidiary::where(['apply_status'=>'2','type'=>$type])->paginate(parent::PERPAGE);
		}else{
			$exhibit_list=Subsidiary::where('apply_status','2')->paginate(parent::PERPAGE);
		}
        return view('admin.accountmanage.subsidiary', [
        	'exhibit_list'=>$exhibit_list
		]);
    }
	/**
	 * 导出excel
	 */
	public function subsidiary_excel()
		{
			$apply_ids = request('apply_ids');
			$subsidiary=new Subsidiary();
			//选中的所有数据
			$res = $subsidiary->whereIn("subsidiary_id", $apply_ids)->get()->toArray();
			$xls_data = array();
			$header = [ '收藏单位', '总登记号', '原编号', '分类号',
				'入馆登记号', '名称', '原名', '年代类型', '具体年代', '历史阶段', '质地类型1', '质地类型2', '具体质地', '普查质地', '类别范围'];
			$xls_data[] = $header;
			foreach($res as $k=> $v)
			{
				//			unset($res[$k]['files']); 删除附件之类的数据
				$xls_data[] = array(
					$v['collect_depart'],
					$v['exhibit_sum_register_num'],
					$v['ori_num'],
					$v['type_num'],
					$v['collect_recipe_num'],
					$v['name'],
					$v['ori_name'],
					$v['age_type'],
					$v['age'],
					$v['history_step'],
					$v['textaure1'],
					$v['textaure2'],
					$v['textaure'],
					$v['common_textaure'],
					$v['range_type'],
				);
			}
			Excel::create('其它文物信息登记', function ($excel) use ($xls_data) {
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
					));
					$sheet->rows($xls_data);
				});
			})->export('xls');

		}
    /**
     * 新增辅助账列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_subsidiary(){
        return view('admin.accountmanage.add_subsidiary');
    }
}
