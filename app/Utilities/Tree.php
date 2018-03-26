<?php

namespace App\Utilities;

/**
 * 格式化树结构数据
 *
 * @author lxp 20160705
 * @package App\Utilities
 */
class Tree
{
	var $data = [];
	var $child = [];
	var $layer = [
		0 => 0
	];
	public $parent = [];

	/**
	 * 初始化数据
	 *
	 * @author lxp 20160705
	 * @param array $nodes 节点数组
	 * @param string $id_field id字段名
	 * @param string $parent_field 父id字段名
	 */
	public function setTree($nodes, $id_field, $parent_field)
	{
		foreach ($nodes as $node) {
			$this->setNode($node[$id_field], $node[$parent_field], $node);
		}
		$this->setLayer();
	}

	/**
	 * 返回格式化后的树形数据
	 * [
	 *    id => [
	 *        ... 当前分类数据
	 *        'layer' => '', 所属分类级别
	 *    ]
	 * ]
	 *
	 * @author lxp 20160706
	 * @param int $layer
	 * @param int $root
	 * @param null $except
	 * @return array
	 */
	public function getOptions($layer = 0, $root = 0, $except = NULL)
	{
		$options = [];
		$childs = $this->getChilds($root, $except);
		foreach ($childs as $id) {
			if ($id > 0 && ($layer <= 0 || $this->getLayer($id) <= $layer)) {
				$tempdata = $this->data[$id];
				$tempdata['layer'] = $this->layer[$id];
				$tempdata['haschild'] = $this->child[$id] ? true : false;
				$options[$id] = $tempdata;
			}
		}

		return $options;
	}

	/**
	 * 返回格式化后的树形数据
	 * [
	 *    id => [
	 *        ... 当前分类数据
	 *        'layer' => '', 所属分类级别
	 *        'child' => [...] 子分类数组
	 *    ]
	 * ]
	 *
	 * @author lxp 20160705
	 * @param int $root
	 * @param null $layer
	 * @param bool $id_index
	 * @return array
	 */
	public function getArrayList($root = 0, $layer = NULL, $id_index = true, $set_layer = true)
	{
		$data = [];
		foreach ($this->child[$root] as $id) {
			if ($layer && $this->layer[$this->parent[$id]] > $layer - 1) {
				continue;
			}

			$tempdata = $this->data[$id];
			if ($set_layer) {
				$tempdata['layer'] = $this->layer[$id];
			}
			$tempdata['child'] = $this->child[$id] ? $this->getArrayList($id, $layer, $id_index, $set_layer) : [];
			if ($id_index) {
				$data[$id] = $tempdata;
			} else {
				$data[] = $tempdata;
			}
		}
		return $data;
	}

	/**
	 * 设置节点
	 *
	 * @author lxp 20160705
	 * @param mixed $id
	 * @param mixed $parent
	 * @param mixed $value
	 */
	private function setNode($id, $parent, $value)
	{
		$parent = $parent ? $parent : 0;

		$this->data[$id] = $value;
		if (!isset($this->child[$id])) {
			$this->child[$id] = [];
		}

		if (isset($this->child[$parent])) {
			$this->child[$parent][] = $id;
		} else {
			$this->child[$parent] = [$id];
		}

		$this->parent[$id] = $parent;
	}

	/**
	 * 计算layer
	 *
	 * @author lxp 20160705
	 * @param int $root
	 */
	private function setLayer($root = 0)
	{
		foreach ($this->child[$root] as $id) {
			$this->layer[$id] = $this->layer[$this->parent[$id]] + 1;
			if ($this->child[$id]) {
				$this->setLayer($id);
			}
		}
	}

	/**
	 * 取得子孙，包括自身，先根遍历
	 *
	 * @param int $id
	 * @param null $except
	 * @return array
	 */
	private function getChilds($id = 0, $except = NULL)
	{
		$child = [
			$id
		];
		$this->getList($child, $id, $except);

		unset($child[0]);
		return $child;
	}

	/**
	 * 先根遍历，不包括root
	 *
	 * @param array $tree
	 * @param int $root
	 * @param mix $except 除外的结点，用于编辑结点时，上级不能选择自身及子结点
	 */
	private function getList(&$tree, $root = 0, $except = NULL)
	{
		foreach ($this->child[$root] as $id) {
			if ($id == $except) {
				continue;
			}

			$tree[] = $id;

			if ($this->child[$id]) {
				$this->getList($tree, $id, $except);
			}
		}
	}

	private function getLayer($id, $space = false, $layerSign = '&nbsp;&nbsp;&nbsp;&nbsp;')
	{
		return $space ? (str_repeat($layerSign, $this->layer[$id] - 1) . $space) : $this->layer[$id];
	}

}
