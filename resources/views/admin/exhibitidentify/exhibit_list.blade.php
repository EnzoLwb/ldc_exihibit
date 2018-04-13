@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')

    <div class="wrapper wrapper-content">

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <table class="table table-striped table-bordered table-hover dataTables-example dataTable">
                            <thead>
                            <tr role="row">
                                <th>选择</th>
                                <th>藏品名称</th>
                            </tr>
                            </thead>
                            @foreach($exhibit_list as $exhibit)
                                <tr class="gradeA">
                                    <td><input type="checkbox" onclick="change_status(this)" name="collect_apply_id"  value="{{$exhibit['exhibit_sum_register_id']}}"></td>
                                    <td>{{$exhibit['name']}}</td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
   function change_status(obj) {
       ids = $(window.parent.document.getElementById('exhibit_sum_register_ids')).val();
       new_ids = '';
       if($(obj).is(":checked")){
           var strs= new Array(); //定义一数组
           strs=ids.split(","); //字符分割
           strs.push($(obj).val())
            for(i =0;i<strs.length;i++){
               if(strs[i]){
                   new_ids += strs[i]+",";
               }
            }
       }else{
           var strs= new Array(); //定义一数组
           strs=ids.split(","); //字符分割
           new_array = new Array();
           for(i=0;i<strs.length;i++){
               if((strs[i]).toString() == ($(obj).val()).toString()){
                   continue;
               }
               new_array.push(strs[i])
           }
           for(i =0;i<new_array.length;i++){
               if(new_array[i]){
                   new_ids += strs[i]+",";
               }
           }
       }
       $(window.parent.document.getElementById('exhibit_sum_register_ids')).val(new_ids);
   }
</script>