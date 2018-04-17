<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">

                <form role="form" class="form-inline" method="get"
                    @if(empty($show))
                         action="{{route('admin.applymanage.export_collect_apply')}}">
                        @else
                         action="{{route('admin.applymanage.history_apply')}}">
                    @endif
                    <div class="form-group">
                        <select name="apply_type" class="form-control">
                            @foreach(\App\Dao\ConstDao::$apply_desc as $key=>$v)
                                @if($type == $key)
                                    <option selected value="{{$key}}">{{$v}}</option>
                                @else
                                    <option value="{{$key}}">{{$v}}</option>
                                @endif

                            @endforeach
                        </select>
                    </div>
                    &nbsp;&nbsp;
                    <button type="submit" class="btn btn-primary">搜索</button>
                    @if(empty($show))
                    <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.applymanage.export_collect_apply')}}'">重置</button>
                        @else
                    <button type="button" class="btn btn-white" onclick="location.href='{{route('admin.applymanage.history_apply')}}'">重置</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>