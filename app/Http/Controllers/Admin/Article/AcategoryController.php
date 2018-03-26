<?php
namespace App\Http\Controllers\Admin\Article;

use App\Dao\UploadedFileDao;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Acategory AS Category;
use App\Models\Article;
use App\Models\UploadedFile;

/**
 * 分类控制器
 *
 * @author lxp 20160705
 * @package App\Http\Controllers
 */
class AcategoryController extends BaseAdminController
{

	private $tree;

	/**
	 * 分类列表
	 *
	 * @author lxp 20160706
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$this->setTree();
		$catelist = $this->tree->getOptions();
		// 取出可新增子分类的分类id
		$allowChild = array_column($this->tree->getOptions(1), 'cate_id');

		return view('admin.article.acategory', [
			'catelist' => $catelist,
			'allowChild' => $allowChild
		]);
	}

	/**
	 * 添加分类
	 *
	 * @author lxp 20160705
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function add()
	{
		$this->setTree();

		return view('admin.article.acategory_form', [
			'cates' => $this->tree->getOptions(2)
		]);
	}

	/**
	 * 编辑分类
	 *
	 * @author lxp 20160706
	 * @param int $cate_id 分类id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit($cate_id)
	{
		// 取得分类数据
		$category = Category::findOrFail($cate_id);

		$this->setTree();

		return view('admin.article.acategory_form', [
			'category' => $category,
			'cates' => $this->tree->getOptions(2)
		]);
	}

	/**
	 * 取得并初始化分类数据
	 *
	 * @author lxp 20160706
	 */
	private function setTree()
	{
		// 取得分类
		$cates = Category::orderBy('sort_order')->orderBy('cate_id')->get()->toArray();
		// 处理分类结构
		$this->tree = app('tree');
		$this->tree->setTree($cates, 'cate_id', 'parent_id');
	}

	/**
	 * 保存分类
	 *
	 * @author lxp 20160705
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function save()
	{
		// 验证
		$this->validate(request(), [
			'cate_name' => 'required|unique:acategory,cate_name,' . request('cate_id', 0) . ',cate_id',
			'sort_order' => 'integer'
		]);

		// 保存数据
		$cate = Category::findOrNew(request('cate_id', 0));
		$cate->cate_name = request('cate_name');
		$cate->parent_id = request('parent_id');
		$cate->sort_order = request('sort_order');
		$cate->is_show = request('is_show');
		$cate->icon = request('icon');
		$cate->save();
		// 更新附件的item_id
		if (intval(request('file_id'))) {
			UploadedFile::where('file_id', intval(request('file_id')))->update(['item_id' => $cate->cate_id]);
		}

		// 操作成功，跳转列表
		return $this->success(get_session_url('index'));
	}

	/**
	 * 删除分类
	 *
	 * @author lxp 20160706
	 * @param int $cate_id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function delete($cate_id)
	{
		if (request()->ajax()) {
			// 该分类下有数据则不能删除
			if(Article::where('cate_id', $cate_id)->count() > 0){
				return $this->error('e_category_hasdata');
			}

			// 该分类下有子分类不能删除
			if (Category::where('parent_id', $cate_id)->count() > 0) {
				return $this->error('e_category_haschild');
			}

			// 删除附件
			UploadedFileDao::removeFileByItem($cate_id, 'FT_ARTICLE_CATE');

			// 删除分类
			Category::destroy($cate_id);

			return $this->success('', 's_del');
		}
	}
}
