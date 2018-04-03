<?php

namespace App\Dao;

use Illuminate\Database\Eloquent\Model;

class ConstDao
{
    //需要审批的申请种类
    const APPLY_TYPE_COLLECT = 'collect';
    const APPLY_TYPE_IDENTIFY = 'identify';

    public static $apply_desc = array(
        self::APPLY_TYPE_COLLECT=>'征集申请',
        self::APPLY_TYPE_IDENTIFY=>'鉴定申请'
    );

    //征集申请的几种状态
    const EXHIBIT_COLLECT_APPLY_DRAFT = 0;//征集申请处于草稿状态
    const EXHIBIT_COLLECT_APPLY_WAITING_AUDIT = 1;//征集申请等待审核
    const EXHIBIT_COLLECT_APPLY_AUDITED = 2;//征集申请审核通过
    const EXHIBIT_COLLECT_APPLY_REFUSED = 3; //征集申请被拒绝
    const EXHIBIT_COLLECT_APPLY_USED = 4; //征集申请已经申请入馆流程结束

    static $collect_apply_desc = array(
        self::EXHIBIT_COLLECT_APPLY_WAITING_AUDIT=>'等待审核',
        self::EXHIBIT_COLLECT_APPLY_AUDITED=>'审核已通过',
        self::EXHIBIT_COLLECT_APPLY_REFUSED=>'审核被拒绝',
    );

    //鉴定申请的集中状态
    const EXHIBIT_IDENTIFY_APPLY_DRAFT = 0;//征集申请处于草稿状态
    const EXHIBIT_IDENTIFY_APPLY_WAITING_AUDIT = 1;//征集申请等待审核
    const EXHIBIT_IDENTIFY_APPLY_AUDITED = 2;//征集申请审核通过
    const EXHIBIT_IDENTIFY_APPLY_REFUSED = 3; //征集申请被拒绝

    static $identify_desc = array(
        self::EXHIBIT_IDENTIFY_APPLY_DRAFT=>'未提交审核',
        self::EXHIBIT_IDENTIFY_APPLY_WAITING_AUDIT=>'等待审核',
        self::EXHIBIT_IDENTIFY_APPLY_AUDITED=>"审核通过",
        self::EXHIBIT_IDENTIFY_APPLY_REFUSED=>"审核被拒绝"
    );

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
