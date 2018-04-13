@extends('layouts.public')
@section('bodyattr')class="gray-bg"@endsection
@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.statics.identify')}}">鉴定统计</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.statics.identify')}}">
                            <div class="form-group">
                                <label>开始日期</label>
                                <input placeholder="开始日期" class="form-control layer-date laydate-icon"
                                           id="start_year" type="text" name="start_year" value="{{request('start_year')}}"
                                                           style="width: 140px;">
                                <label>结束日期</label>
                                <input placeholder="结束日期" class="form-control layer-date laydate-icon" id="end_year"
                                       type="text" name="end_year" value="{{request('end_year')}}"        style="width: 140px;">
                            </div>

                            <div class="form-group">
                                <label>鉴定人</label>
                                <select name="expert_id" class="form-control">
                                    <option value="">全部专家</option>
                                    @foreach($expert_list as $item)
                                        <option value="{{$item['uid']}}">{{$item['username']}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>类别</label>
                                <input type="text" name="type" class="form-control" value="{{request('type')}}">
                            </div>&nbsp;&nbsp;
                            <div class="form-group">
                                <label>质地</label>
                                <input type="text" name="textaure" class="form-control" value="{{request('textaure')}}">
                            </div>&nbsp;&nbsp;
                            <div class="form-group">
                                <label>级别</label>
                                <select name="expert_id" class="form-control">
                                    <option value="">全部级别</option>
                                    @foreach(\App\Dao\ConstDao::$exhibit_level_desc as $k=>$v)
                                        <option value="{{$k}}">{{$v}}</option>
                                    @endforeach
                                </select>
                            </div>&nbsp;&nbsp;

                            <button type="submit" class="btn btn-primary">搜索</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <div id="charts" style="width: 95%;min-height:500px;margin-left:30px;"></div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('script')
    <script src="{{cdn('js/public.js')}}"></script>
    <script type="text/javascript" src="{{cdn('js/plugins/laydate/laydate.js')}}"></script>
    <script type="text/javascript" src="{{cdn('js/plugins/echarts3/echarts.min.js')}}"></script>
    <script type="text/javascript">
        option = {
            title: {
                text: ''
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'cross',
                    label: {
                        backgroundColor: '#6a7985'
                    }
                }
            },
            legend: {
                data: ['文物藏品']
            },
            toolbox: {
                feature: {
                    saveAsImage: {}
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: [
                {
                    type: 'category',
                    boundaryGap: false,
                    data: {!! $chart_x !!}
                }
            ],
            yAxis: [
                {
                    type: 'value'
                }
            ],
            series: [
                {
                    name: '文物藏品增加统计',
                    type: 'line',
                    stack: '',
                    areaStyle: {normal: {}},
                    data: {!! $num !!}
                }
            ]
        };
        var myChart = echarts.init(document.getElementById('charts'));
        myChart.setOption(option);

        var start = $.extend({}, laydateOptions, {
            elem: "#start_year",
            choose: function (datas) {
            }
        });
        laydate(start);

        var end = $.extend({}, laydateOptions, {
            elem: "#end_year",
            choose: function (datas) {
            }
        });
        laydate(end);

    </script>
@endsection