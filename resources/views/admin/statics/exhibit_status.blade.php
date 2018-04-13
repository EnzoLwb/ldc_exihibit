@extends('layouts.public')
@section('bodyattr')class="gray-bg"@endsection
@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li ><a href="{{route('admin.statics.exhibit')}}">藏品增减统计</a></li>
                        <li ><a href="{{route('admin.statics.exhibit.src')}}">藏品来源统计</a></li>
                        <li class="active"><a href="{{route('admin.statics.exhibit.status')}}">藏品状态统计</a></li>
                        <li ><a href="{{route('admin.statics.exhibit')}}">藏品详细统计</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.statics.exhibit.status')}}">
                            <div class="form-group">
                               <label>状态</label>
                                <select name="status" class="form-control">
                                    <option value="" @if(empty(request('status'))) selected @endif>全部状态</option>
                                    @foreach(\App\Dao\ConstDao::$exhibit_status_desc as $k=>$v)
                                        <option @if(request('status') == $k) selected @endif value="{{$k}}">{{$v}}</option>
                                    @endforeach
                                </select>
                            </div>
                            &nbsp;&nbsp;
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