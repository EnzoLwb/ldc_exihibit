<?php

namespace App\Dao;

use Illuminate\Database\Eloquent\Model;

class ConstDao
{
    //征集申请的几种状态
    const EXHIBIT_COLLECT_APPLY_DRAFT = 0;//征集申请处于草稿状态
    const EXHIBIT_COLLECT_APPLY_WAITING_AUDIT = 1;//征集申请等待审核
    const EXHIBIT_COLLECT_APPLY_AUDITED = 2;//征集申请审核通过
    const EXHIBIT_COLLECT_APPLY_REFUSED = 3; //征集申请被拒绝
    const EXHIBIT_COLLECT_APPLY_USED = 4; //征集申请已经申请入馆流程结束
    //征集入馆凭证类型
    const EXHIBIT_COLLECT_RECIPE_SRC_BY_APPLY = 1 ;//征集入馆
    const EXHIBIT_COLLECT_RECIPE_SRC_BY_DIRECT = 0 ;//直接入馆
    //征集入馆单子的状态
    const EXHIBIT_COLLECT_RECIPE_STATUS_UNSUBMIT = 0;//入馆单子未入总账
    const EXHIBIT_COLLECT_RECIPE_STATUS_SUBMITED = 1;//入馆单子已入总账

    const OPERATION_EDIT = 'EDIT';//操作  编辑
    const OPERATION_VIEW = 'VIEW';//操作  查看
    const OPERATION_ADD= 'ADD' ; //操作新加
}
