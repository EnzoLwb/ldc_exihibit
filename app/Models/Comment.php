<?php
namespace App\Models;

/**
 * 评论模型
 *
 * @author lxp 20160707
 */
class Comment extends BaseMdl
{
	protected $primaryKey = 'comment_id';

	/**
	 * 查出文章表标题
	 *
	 * @author lxp 20170304
	 * @param $query
	 * @return mixed
	 */
	public function scopeArticle($query)
	{
		return $query->leftJoin('article', 'article.article_id', '=', 'comment.article_id')->select('comment.*', 'article.title');
	}
}
