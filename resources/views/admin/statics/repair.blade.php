@extends('layouts.public')
@section('bodyattr')class="gray-bg"@endsection
@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">

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
                data: ['修复文物']
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
                    name: '修复文物',
                    type: 'line',
                    stack: '',
                    areaStyle: {normal: {}},
                    data: {!! $chart_data_child !!}
                }

            ]
        };
        var myChart = echarts.init(document.getElementById('charts'));
        myChart.setOption(option);
    </script>
@endsection