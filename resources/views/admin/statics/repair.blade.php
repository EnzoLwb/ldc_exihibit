@extends('layouts.public')
@section('bodyattr')class="gray-bg"@endsection
@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.statics.repaire')}}">鉴定统计</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get" action="{{route('admin.statics.repaire')}}">
                            <div class="form-group">
                                <label>开始日期</label>
                                <input placeholder="开始日期" class="form-control layer-date laydate-icon"
                                       id="start_year" type="text" name="start_year" value="{{request('start_year')}}"
                                       style="width: 140px;">
                                <label>结束日期</label>
                                <input placeholder="结束日期" class="form-control layer-date laydate-icon" id="end_year"
                                       type="text" name="end_year" value="{{request('end_year')}}"        style="width: 140px;">
                            </div>
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
                data: ['藏品修复','内修复文物','外修复文物']
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
                    name: '内修复文物',
                    type: 'line',
                    areaStyle: {normal: {}},
                    data:{{$data_inside}}
                }, {
                    name: '外修复文物',
                    type: 'line',
                    areaStyle: {normal: {}},
                    data:{{$data_outside}}
                }, {
                    name: '藏品修复',
                    type: 'line',
                    areaStyle: {normal: {}},
                    data:{{$data_repair_apply}}
                },
            ]
        };
        var myChart = echarts.init(document.getElementById('charts'));
        myChart.setOption(option);
    </script>
@endsection