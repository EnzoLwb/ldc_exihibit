<?php

namespace App\Dao;

use Illuminate\Database\Eloquent\Model;

class ConstDao
{
    const RETURNSTORAGE_STATUS_DRAFT = 0; //藏品回库单子草稿状态
    const RETURNSTORAGE_STATUS_SUBMIT = 1;//藏品回库单子已经提交
    public static $returnstorage_desc = array(
        self::RETURNSTORAGE_STATUS_DRAFT=>'未提交',
        self::RETURNSTORAGE_STATUS_SUBMIT=>'已提交',
    );

    const ACCIDENT_STATUS_DRAFT = 0;//事故草稿状态
    const ACCIDENT_STATUS_WAITING_AUDIT = 1;//事故等待审核
    const ACCIDENT_STATUS_AUDIENTED = 2;//事故审核通过
    const ACCIDENT_STATUS_REFUSE = 3;//事故审核拒绝

    public static $accident_desc = array(
        self::ACCIDENT_STATUS_DRAFT=>'草稿状态',
        self::ACCIDENT_STATUS_AUDIENTED=>'审核通过',
        self::ACCIDENT_STATUS_WAITING_AUDIT=>'等待审核',
        self::ACCIDENT_STATUS_REFUSE=>'审核拒绝'
    );

    const EXPERT_ROLE_ID = 3;// 专家角色ID
    //专家性别描述
    const EXPERT_SEX_MAN = 1;
    const EXPERT_SEX_FEMALE = 0;
    static $expert_sex_desc = array(
        self::EXPERT_SEX_FEMALE=>"女",
        self::EXPERT_SEX_MAN=>"男",
    );
    //专家状态描述
    const EXPERT_STATUS_USING = 1;
    const EXPERT_STATUS_BLACKLIST = 0;
    static $expert_status_desc = array(
        self::EXPERT_STATUS_BLACKLIST=>"停用",
        self::EXPERT_STATUS_USING=>"启用"
    );

    //需要审批的申请种类
    const APPLY_TYPE_COLLECT = 'collect';
    const APPLY_TYPE_IDENTIFY = 'identify';
    const APPLY_TYPE_OUTER = 'outer_storage';
    const APPLY_TYPE_LOGOUT = 'logOut';
    const APPLY_TYPE_REPAIR = 'repair';
    const APPLY_TYPE_STORAGE_CHECK = 'storageCheck';
    const APPLY_TYPE_ACCIDENT = 'accident';
    
    public static $apply_desc = array(
        self::APPLY_TYPE_COLLECT=>'征集申请',
        self::APPLY_TYPE_IDENTIFY=>'鉴定申请',
        self::APPLY_TYPE_OUTER=>'出库申请',
        self::APPLY_TYPE_LOGOUT=>'藏品注销申请',
        self::APPLY_TYPE_REPAIR=>'藏品修复申请',
		self::APPLY_TYPE_STORAGE_CHECK=>'库房盘点申请',
        self::APPLY_TYPE_ACCIDENT=>'事故申请'
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


    const EXHIBIT_USED_OUTER = 1;//展品出库
    const EXHIBIT_USED = 2;//展品提用
    const EXHIBIT_USED_SHOW = 3;//展品观摩

    const EXHIBIT_STATUS_IN_ROOM = 0 ;//展品在库
    const EXHIBIT_STATUS_BOJIAO = 1 ;//展品拨交
    const EXHIBIT_STATUS_SHOW = 2;//展品观摩
    const EXHIBIT_STATUS_COPY = 3 ;//展品复制
    const EXHIBIT_STATUS_SALE = 4 ;//展品拍卖
    const EXHIBIT_STATUS_EXCHANGE = 5 ;//展品交换
    const EXHIBIT_STATUS_DONATE = 6 ;//展品捐赠
    const EXHIBIT_STATUS_LOST = 7 ;//展品丢失
    const EXHIBIT_STATUS_DAMAGE = 8 ;//展品报损
    const EXHIBIT_STATUS_LEND = 9 ;//展品借出
    const EXHIBIT_STATUS_LOGOUT = 10 ;//展品注销

    public static $exhibit_status_desc = array(
        self::EXHIBIT_STATUS_IN_ROOM=>'在库',
        self::EXHIBIT_STATUS_BOJIAO=>'拨交',
        self::EXHIBIT_STATUS_SHOW=>'观摩',
        self::EXHIBIT_STATUS_COPY=>'复制',
        self::EXHIBIT_STATUS_SALE=>'拍卖',
        self::EXHIBIT_STATUS_EXCHANGE=>'交换',
        self::EXHIBIT_STATUS_DONATE=>'捐赠',
        self::EXHIBIT_STATUS_LOST=>'丢失',
        self::EXHIBIT_STATUS_DAMAGE=>'报损',
        self::EXHIBIT_STATUS_LEND=>'借出',

        self::EXHIBIT_STATUS_LOGOUT=>'注销',
    );


    const EXHIBIT_USED_APPLY_STATUS_DRAFT = 0; //展品使用申请草稿状态
    const EXHIBIT_USED_APPLY_STATUS_WAITING_AUDIT  = 1;//展品使用申请等待审核状态
    const EXHIBIT_USED_APPLY_STATUS_AUDITED  = 2;////展品使用申请通过状态
    const EXHIBIT_USED_APPLY_STATUS_REFUSED  = 3;//展品使用申请拒绝状态
    const EXHIBIT_USED_APPLY_STATUS_FINISHED  = 4;//展品使用申请完成状态
    const EXHIBIT_USED_APPLY_STATUS_INVALID  = 5;//展品使用申请不可用状态

    public static $exhibit_used_apply_desc = array(
        self::EXHIBIT_USED_APPLY_STATUS_DRAFT=>'草稿状态',
        self::EXHIBIT_USED_APPLY_STATUS_WAITING_AUDIT=>'等待审核',
        self::EXHIBIT_USED_APPLY_STATUS_AUDITED=>'审核通过',
        self::EXHIBIT_USED_APPLY_STATUS_REFUSED=>'审核拒绝',
        self::EXHIBIT_USED_APPLY_STATUS_FINISHED=>'完成',
        self::EXHIBIT_USED_APPLY_STATUS_INVALID=>'不可用',
    );
}
