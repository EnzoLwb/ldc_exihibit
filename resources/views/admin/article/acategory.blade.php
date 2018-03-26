@extends('layouts.public')

@section('head')
    <style type="text/css">
        span.indent {
            margin-left: 10px;
            margin-right: 10px;
        }

        span.icon {
            width: 12px;
            margin-right: 5px;
        }
    </style>
@endsection

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{url('/admin/article/acategory')}}">分类列表</a></li>
                        <li class=""><a href="{{url('/admin/article/acategory/add')}}">添加分类</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <table class="table table-striped table-bordered table-hover" id="category_tree">
                            <tr>
                                <th width="25%">分类名称</th>
                                <th width="7%">分类ID</th>
                                <th width="8%">排序</th>
                                <th width="10%">状态</th>
                                <th width="10%">图标</th>
                                <th width="20%">操作</th>
                            </tr>
                            @foreach ($catelist as $cate)
                                <tr class="gradeA" data-tt-id="{{$cate['cate_id']}}" data-tt-parent-id="{{$cate['parent_id']}}">
                                    <td>
                                        @if($cate['layer'] == 2)
                                            <span class="indent"></span>
                                        @elseif($cate['layer'] == 3)
                                            <span class="indent"></span>
                                            <span class="indent"></span>
                                        @endif
                                        @if($cate['haschild'])
                                            <span class="icon expand-icon glyphicon glyphicon-minus"></span>
                                        @else
                                            <span class="indent"></span>
                                        @endif
                                        <span ectype="inline_edit" fieldname="cate_name" fieldid="{{$cate['cate_id']}}" required="1" class="editable"
                                              title="可编辑">{{$cate['cate_name']}}</span>
                                    </td>
                                    <td>{{$cate['cate_id']}}</td>
                                    <td><span ectype="inline_edit" fieldname="sort_order" fieldid="{{$cate['cate_id']}}" datatype="pint" maxvalue="255" class="editable"
                                              title="可编辑">{{$cate['sort_order']}}</span></td>
                                    <td>
                                        @if ($cate['is_show'] == 1)
                                            显示
                                        @else
                                            不显示
                                        @endif
                                    </td>
                                    <td>
                                        @if($cate['icon'] != '')
                                            <img alt="" src="{{get_file_url($cate['icon'])}}" style="max-height: 36px;"/>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{url('/admin/article/acategory/edit/'.$cate['cate_id'])}}">编辑</a>
                                        | <a class="ajaxBtn" href="javascript:void(0);" uri="{{url('/admin/article/acategory/delete/'.$cate['cate_id'])}}" msg="是否删除该分类？">删除</a>
                                        @if (in_array($cate['cate_id'], $allowChild)) | <a href="{{url('/admin/article/acategory/add?cate_id='.$cate['cate_id'])}}">新增下级</a>@endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{cdn('js/plugins/jquery.jeditable.js')}}"></script>
    <script type="text/javascript">
        jQuery(function ($) {
            $('span.editable').editable('{{url('/article/acategory/ajax-edit')}}', {
                tooltip: '点此编辑'
            });
        });
    </script>
@endsection

