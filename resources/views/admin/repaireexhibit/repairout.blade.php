@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">
@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{route('admin.repaireexhibit.repairin')}}">内修文物管理</a></li>
                        <li><a href="{{route('admin.repaireexhibit.repairin.add')}}">新增内修文物</a></li>
                        <li class="active"><a href="{{route('admin.repaireexhibit.repairout')}}">外修文物管理</a></li>
                        <li><a href="{{route('admin.repaireexhibit.repairout.add')}}">新增外修文物</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get">
                            <div class="form-group">
                                <label class="sr-only">藏品名称</label>
                                <input type="text" name="exhibit_name" placeholder="藏品名称" class="form-control" value="">
                            </div>
                            &nbsp;&nbsp
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.repaireexhibit.repairout')}}'">重置</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="javascript:void(0)" onclick="do_submit()">提交申请</a></li>
                        <li><a href="javascript:void(0)" onclick="export_list()">导出</a></li>
                        <li><a href="javascript:void(0)" onclick="do_print()">打印</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <table class="table table-striped table-bordered table-hover">
                            <tr class="gradeA">
                                <th>选择</th>
                                <th>账目类型</th>
                                <th>藏品名称</th>
                                <th>修复前</th>
                                <th>修复中</th>
                                <th>修复后</th>
                                <th>申请状态</th>
                                <th>残损情况</th>
                                <th>修复要求</th>
                                <th>时间</th>
                                <th>修复数量</th>
                                <th>估价</th>
                                <th>操作</th>
                            </tr>
                            @foreach($data as $k => $v)
                                <tr class="gradeA">
                                    <td>
                                        <input type="checkbox" name="outside_repair_id" value="{{$v['outside_repair_id']}}">
                                    </td>
                                    <td>{{\App\Dao\ConstDao::$type_desc[$v['account_type']]}}</td>
                                    <td>{{$v['name']}}</td>
                                    <td>
                                        @if($v['before_pic']!='')
                                            <div class="img-div">
                                                <img src="{{get_file_url($v['before_pic'])}}"/>
                                            </div>
                                        @else
                                            <span>暂无修复前图片</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($v['repairing_pic']!='')
                                            <div class="img-div">
                                                <img src="{{get_file_url($v['repairing_pic'])}}"/>
                                            </div>
                                        @else
                                            <span>暂无修复中图片</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($v['after_pic']!='')
                                            <div class="img-div">
                                                <img src="{{get_file_url($v['after_pic'])}}"/>
                                            </div>
                                        @else
                                            <span>暂无修复后图片</span>
                                        @endif
                                    </td>
                                    <td>{{$v->applyStatus($v['apply_status'])}}</td>
                                    <td>{{$v['incomplete_status']}}</td>
                                    <td>{{$v['repair_require']}}</td>
                                    <td>{{$v['date']}}</td>
                                    <td>{{$v['repair_num']}}</td>
                                    <td>{{$v['plan_price']}}</td>
                                    <td>
                                        <a href="{{route('admin.repaireexhibit.repairout.delete',['outside_repair_id'=>$v['outside_repair_id']])}}"
                                           onclick="if (confirm('确定要删除此记录吗？')==false) return false">删除</a>
                                        <a href="{{route('admin.repaireexhibit.repairout.edit',['outside_repair_id'=>$v['outside_repair_id']])}}">修改</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="row">
                            <div class="col-sm-12">
                                <div>共 {{ $data->total() }} 条记录</div>
                                <div>{!! $data->links() !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        //打印功能
        function do_print() {
            window.document.body.innerHTML==window.document.body.innerHTML; //把需要打印的指定内容赋给body.innerHTML
            window.print(); //调用浏览器的打印功能打印指定区域
        }

        //功能函数，收集选中的申请项
        function get_logout_ids() {
            checkd_list = $('input[name="outside_repair_id"]:checked')
            logout_ids = []
            for(i = 0; i<checkd_list.length;i++){
                logout_ids.push($(checkd_list[i]).val())
            }
            return logout_ids;
        }

        /**
         * 提交审核
         */
        function do_submit() {
            //选中的id
            outside_repair_id = get_logout_ids();
            if(outside_repair_id.length==0){
                layer.alert("请至少选择一项")
                return
            }
            $.ajax('{{route("admin.repaireexhibit.repairout.apply_submit")}}', {
                method: 'POST',
                data: {'outside_repair_id':outside_repair_id},
                dataType: 'json'
            }).done(function (response) {
                layer.alert(response.msg)
                setTimeout("location.reload();",1000)
            });
        }

        /**
         * 导出申请列表
         */
        function export_list() {
            apply_ids = get_logout_ids();
            if(apply_ids.length==0){
                layer.alert("请至少选择一项")
                return
            }
            url = '{{route("admin.repaireexhibit.repairout.excel")}}' +"?";
            for(i=0;i<apply_ids.length;i++){
                url += "apply_ids["+i.toString()+"]="+apply_ids[i]+"&"
            }
            location.href=url
        }
    </script>
@endsection

