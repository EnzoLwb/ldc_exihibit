@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection
<link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">
@section('body')

    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.accountmanage.subsidiary')}}">查询</a></li>
                        <li><a href="javascript:void(0)" onclick="export_list()">导出</a></li>
                        <li><a href="javascript:void(0)" onclick="do_print()">打印</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.accountmanage.subsidiary')}}">
                            <select name="type" class="form-control">
                                @foreach(App\Models\Subsidiary::$type   as $k=>$name)
                                    <option value="{{$k}}" {{@$data['type']==$k||old('type')==$k?'selected':''}}>{{$name}}</option>
                                @endforeach
                            </select>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.exhibitcollect.apply')}}'">重置</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <table class="table table-striped table-bordered table-hover dataTables-example dataTable">
                            <thead>
                            <tr role="row">
                                <th>选择</th>
                                <th>收藏单位</th>
                                <th>图片</th>
                                <th>总登记号</th>
                                <th>原编号</th>
                                <th>分类号</th>
                                <th>入馆登记号</th>
                                <th>名称</th>
                                <th>原名</th>
                                <th>年代类型</th>
                                <th>具体年代</th>
                                <th>历史阶段</th>
                                <th>质地类型1</th>
                                <th>质地类型2</th>
                                <th>具体质地</th>
                                <th>普查质地</th>
                                <th>类别范围</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    <td>
                                        <input type="checkbox" name="subsidiary_id" value="{{$exhibit['subsidiary_id']}}">
                                    </td>
                                    <td>{{$exhibit['collect_depart']}}</td>
                                    <td>
                                        @if($exhibit['attachment']!='')
                                            <div class="img-div">
                                                <img src="{{get_file_url($exhibit['attachment'])}}"/>
                                            </div>
                                        @else
                                            <span>暂无附件图片</span>
                                        @endif
                                    </td>
                                    <td>{{$exhibit['exhibit_sum_register_num']}}</td>
                                    <td>{{$exhibit['ori_num']}}</td>
                                    <td>{{$exhibit['type_num']}}</td>
                                    <td>{{$exhibit['collect_recipe_num']}} </td>
                                    <td>{{$exhibit['name']}} </td>
                                    <td>{{$exhibit['ori_name']}} </td>
                                    <td>{{$exhibit['age_type']}} </td>
                                    <td>{{$exhibit['age']}} </td>
                                    <td>{{$exhibit['history_step']}} </td>
                                    <td>{{$exhibit['textaure1']}} </td>
                                    <td>{{$exhibit['textaure2']}} </td>
                                    <td>{{$exhibit['textaure']}} </td>
                                    <td>{{$exhibit['common_textaure']}} </td>
                                    <td>{{$exhibit['range_type']}} </td>
                                </tr>
                            @endforeach
                        </table>

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
            checkd_list = $('input[name="subsidiary_id"]:checked')
            logout_ids = []
            for(i = 0; i<checkd_list.length;i++){
                logout_ids.push($(checkd_list[i]).val())
            }
            return logout_ids;
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
            url = '{{route("admin.accountmanage.subsidiary.excel")}}' +"?";
            for(i=0;i<apply_ids.length;i++){
                url += "apply_ids["+i.toString()+"]="+apply_ids[i]+"&"
            }
            location.href=url
        }
    </script>
@endsection



