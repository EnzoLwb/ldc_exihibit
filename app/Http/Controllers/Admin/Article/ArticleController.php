<?php
namespace App\Http\Controllers\Admin\Article;

use App\Dao\UploadedFileDao;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Acategory;
use App\Models\Article;
use App\Models\Comment;
use App\Models\UploadedFile;
use App\Models\UploadedType;
use Illuminate\Support\Facades\Auth;

/**
 * 文章控制器
 *
 * @author lxp 20160707
 * @package App\Http\Controllers
 */
class ArticleController extends BaseAdminController
{

	private $tree;

	/**
	 * 文章列表
	 *
	 * @author lxp 20160707
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		// 处理排序
		$sort = request('sort', 'article_id');
		$order = request('order', 'desc');

		$query = Article::orderBy($sort, $order);
		// 筛选标题
		if (request('title')) {
			$query->where('title', 'LIKE', "%" . request('title') . "%");
		}
		// 筛选添加时间
		if (request('created_at_from')) {
			$query->where('created_at', '>=', request('created_at_from'));
		}
		if (request('created_at_to')) {
			$query->where('created_at', '<=', date('Y-m-d', strtotime(request('created_at_to') . " +1 day")));
		}
		// 筛选分类
		if (request()->has('cate_id')) {
			$query->where('cate_id', request('cate_id'));
		}
		// 筛选状态
		if (request()->has('is_show')) {
			$query->where('is_show', request('is_show'));
		}
		// 筛选评论状态
		if (request()->has('is_comment')) {
			$query->where('is_comment', request('is_comment'));
		}
		// 筛选置顶
		if (request()->has('is_top')) {
			$query->where('is_top', request('is_top'));
		}
		// 筛选推荐
		if (request()->has('is_recommend')) {
			$query->where('is_recommend', request('is_recommend'));
		}
		// 取得列表
		$articles = $query->paginate(parent::PERPAGE);
		// 将查询参数拼接到分页链接中
		$articles->appends(app('request')->all());

		$this->setTree();

		return view('admin.article.article', [
			'articles' => $articles,
			'cates' => $this->tree->getOptions(2)
		]);
	}

	/**
	 * 添加文章
	 *
	 * @author lxp 20160705
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function add()
	{
		$this->setTree();

		return view('admin.article.article_form', [
			'cates' => $this->tree->getOptions(2)
		]);
	}

	/**
	 * 编辑文章
	 *
	 * @author lxp 20160708
	 * @param int $article_id 文章id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit($article_id)
	{
		$this->setTree();
		// 取得分类数据
		$article = Article::findOrFail($article_id);
		if ($article->default_img) {
			$article->default_img = get_file_url($article->default_img);
		}

		return view('admin.article.article_form', [
			'article' => $article,
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
		$cates = Acategory::orderBy('sort_order')->orderBy('cate_id')->get()->toArray();
		// 处理分类结构
		$this->tree = app('tree');
		$this->tree->setTree($cates, 'cate_id', 'parent_id');
	}

	/**
	 * 保存文章
	 *
	 * @author lxp 20160705
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function save()
	{
		// 验证
		$this->validate(request(), [
			'title' => 'required|unique:article,title,' . request('article_id', 0) . ',article_id',
			'cate_id' => 'required',
			'content' => 'required'
		]);

		// 保存数据
		$article_id = request('article_id', 0);
		$article = Article::findOrNew($article_id);
		$article->timestamps = true;
		if (!$article_id) {
			$article->uid = Auth::user()->uid;
		}
		$article->cate_id = request('cate_id');
		$article->title = request('title');
		$article->sub_title = request('sub_title');
		$article->des = request('des');
		$article->content = request('content');
		$article->source = request('source');
		// 处理关键词
		$article->keywords = str_replace([
			' ',
			'	',
			'，'
		], [
			'',
			'',
			','
		], request('keywords'));
		$article->is_show = request('is_show');
		$article->is_comment = request('is_comment');
		$article->is_top = request('is_top');
		$article->is_recommend = request('is_recommend');
		$article->default_img = request('default_img');
		$article->save();

		// 更新附件item_id
		if (!request('article_id')) {
			// 更新文章头图
			if (intval(request('file_id'))) {
				UploadedFile::where('file_id', intval(request('file_id')))->update(['item_id' => $article->article_id]);
			}
			// 更新文章内容中的图片
			preg_match_all('/src=[\'|"][^"\']+\?f([0-9]+)[^"\']*[\'|"]/i', $article->content, $fileIds);
			if (!empty($fileIds[1])) {
				UploadedFile::whereIn('file_id', $fileIds[1])->update([
					'item_id' => $article->article_id
				]);
			}
		}

		return $this->success(get_session_url('index'));
	}

	/**
	 * 批量操作
	 *
	 * @author lxp 20160713
	 * @param string $field 要修改的字段名称
	 * @param string $value 要修改的值
	 * @param string $ids 数据id，多个用逗号分隔
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function batch($field, $value, $ids)
	{
		if (request()->ajax()) {
			$idArray = explode(',', $ids);
			// 判断是否允许修改
			if (in_array($field, [
					'is_show',
					'is_top'
				]) && $value != '' && !empty($idArray)
			) {
				Article::whereIn('article_id', $idArray)->update([
					$field => $value
				]);

				return $this->success();
			}
		}
	}

	/**
	 * 删除文章
	 *
	 * @author lxp 20160708
	 * @param string $ids
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function delete($ids)
	{
		if (request()->ajax()) {
			$idArray = explode(',', $ids);

			// 取得和文章相关的附件类型id
			$typeIdArray = UploadedType::whereIn('type_key', [
				'FT_ARTICLE_DESC',
				'FT_ARTICLE_IMG'
			])->get()->pluck('type_id')->all();

			// 取得要删除文章的附件id
			$fileIdArray = UploadedFile::whereIn('type_id', $typeIdArray)->whereIn('item_id', $idArray)->get()->pluck('file_id')->all();

			// 删除附件
			UploadedFileDao::removeFile($fileIdArray);

			// 删除文章
			Article::destroy($idArray);
			// 删除评论
			Comment::whereIn('article_id', $idArray)->delete();

			return $this->success('', 's_del');
		}
	}
}
