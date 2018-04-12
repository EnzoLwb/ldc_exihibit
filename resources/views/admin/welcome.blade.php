@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('head')
<link rel="stylesheet" href="{{cdn('css/add/home.css')}}">
@endsection

@section('body')
<div class="wrapper wrapper-content">
    <div class="row m-b">
        <div class="col-sm-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="{{route('admin.welcome')}}">首页</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="rcont1" id="rmenu">
    	<div class="list_out">
	    	<div class="list">
	    		<a href="#" title="藏品征集"><img src="{{cdn('img/add/menu/menu_icon1.png')}}">藏品征集</a>
	    		<a href="#" title="申请管理申请管理"><img src="{{cdn('img/add/menu/menu_icon2.png')}}">申请管理申请管理</a>
	    		<a href="#"><img src="{{cdn('img/add/menu/menu_icon3.png')}}">录入鉴定结果</a>
	    		<a href="#"><img src="{{cdn('img/add/menu/menu_icon4.png')}}">藏品鉴定</a>
	    		<a href="#"><img src="{{cdn('img/add/menu/menu_icon5.png')}}">信息登记</a>
	    		<a href="#"><img src="{{cdn('img/add/menu/menu_icon6.png')}}">账目管理</a>
	    		<a href="#"><img src="{{cdn('img/add/menu/menu_icon7.png')}}">藏品保管</a>
	    		<a href="#"><img src="{{cdn('img/add/menu/menu_icon8.png')}}">库房日常管理</a>
	    		<a href="#"><img src="{{cdn('img/add/menu/menu_icon9.png')}}">藏品展览</a>
	    		<a href="#"><img src="{{cdn('img/add/menu/menu_icon10.png')}}">藏品修复</a>
	    		<a href="#"><img src="{{cdn('img/add/menu/menu_icon11.png')}}">藏品注销</a>
	    		<a href="#"><img src="{{cdn('img/add/menu/menu_icon12.png')}}">数字资源管理</a>
	    		<a href="#"><img src="{{cdn('img/add/menu/menu_icon13.png')}}">统计分析</a>
	    		<a href="#"><img src="{{cdn('img/add/menu/menu_icon14.png')}}">用户</a>
	    		<a href="#"><img src="{{cdn('img/add/menu/menu_icon15.png')}}">设置</a>
	    	</div>
    	</div>
		<a class="mbtn left"></a>
		<a class="mbtn right"></a>
    </div>
    
    <div class="rcont2">
    	<div class="left">
    		<div class="head">
    			<div class="c1">我的事项</div>
    			<div class="c2">
    				<a class="on">待办(2)</a>
    				<a>已办(6)</a>
    				<a>办结(9)</a>
    			</div>
    		</div>
    		<table>
    			<thead>
    				<tr>
    					<th width="120">类型</th>
    					<th>事项名称</th>
    					<th width="120">到达时间</th>
    				</tr>
    			</thead>
    			<tbody>
    				<tr>
    					<td>类型类型</td>
    					<td class="title"><a href="#" target="_blank">事项名称事项名称事项名称</a></td>
    					<td>2018.04.20</td>
    				</tr>
    				<tr>
    					<td>类型类型</td>
    					<td class="title"><a href="#" target="_blank">事项名称事项名称事项名称</a></td>
    					<td>2018.04.20</td>
    				</tr>
    				<tr>
    					<td>类型类型</td>
    					<td class="title"><a href="#" target="_blank">事项名称事项名称事项名称</a></td>
    					<td>2018.04.20</td>
    				</tr>
    				<tr>
    					<td>类型类型</td>
    					<td class="title"><a href="#" target="_blank">事项名称事项名称事项名称</a></td>
    					<td>2018.04.20</td>
    				</tr>
    				<tr>
    					<td>类型类型</td>
    					<td class="title"><a href="#" target="_blank">事项名称事项名称事项名称</a></td>
    					<td>2018.04.20</td>
    				</tr>
    				<tr>
    					<td>类型类型</td>
    					<td class="title"><a href="#" target="_blank">事项名称事项名称事项名称</a></td>
    					<td>2018.04.20</td>
    				</tr>
    			</tbody>
    		</table>
    		<div class="bottom"><a href="#" target="_blank">更多&gt;&gt;</div>
    	</div>
    	<div class="right">
    		<div class="head">
    			<div class="c1">通知</div>
    		</div>
    		<ul class="list">
    			<li><a href="#" target="_blank">批号21029011审批通过，请做入库处理</a><span>2018.04.08</span></li>
    			<li><a href="#" target="_blank">批号21029011审批通过，请做入库处理</a><span>2018.04.07</span></li>
    			<li><a href="#" target="_blank">批号21029011审批通过，请做入库处理</a><span>2018.04.06</span></li>
    			<li><a href="#" target="_blank">批号21029011审批通过，请做入库处理</a><span>2018.04.05</span></li>
    			<li><a href="#" target="_blank">批号21029011审批通过，请做入库处理</a><span>2018.04.05</span></li>
    			<li><a href="#" target="_blank">批号21029011审批通过，请做入库处理</a><span>2018.04.05</span></li>
    			<li><a href="#" target="_blank">批号21029011审批通过，请做入库处理</a><span>2018.04.05</span></li>
    			<li><a href="#" target="_blank">批号21029011审批通过，请做入库处理</a><span>2018.04.05</span></li>
    		</ul>
    		<div class="bottom"><a href="#" target="_blank">更多&gt;&gt;</a></div>
    	</div>
    </div>
    
    <div class="rcont3">
		<div class="head">
			<div class="c1">藏品统计</div>
    		<!--<div class="c2"></div>-->
		</div>
    	<div class="list">
    		<ul>
    			<li><img src="{{cdn('img/add/menu/menu_icon1.png')}}"><div>藏品数</div><div>555</div></li>
    			<li><img src="{{cdn('img/add/menu/menu_icon1.png')}}"><div>资料数</div><div>555</div></li>
    			<li><img src="{{cdn('img/add/menu/menu_icon1.png')}}"><div>复制品数</div><div>555</div></li>
    			<li><img src="{{cdn('img/add/menu/menu_icon1.png')}}"><div>仿制品数</div><div>555</div></li>
    			<li><img src="{{cdn('img/add/menu/menu_icon1.png')}}"><div>代管数</div><div>555</div></li>
    			<li><img src="{{cdn('img/add/menu/menu_icon1.png')}}"><div>外借数</div><div>555</div></li>
    			<li><img src="{{cdn('img/add/menu/menu_icon1.png')}}"><div>待入账数</div><div>555</div></li>
    			<li><img src="{{cdn('img/add/menu/menu_icon1.png')}}"><div>待入库数</div><div>555</div></li>
    			<li><img src="{{cdn('img/add/menu/menu_icon1.png')}}"><div>待排架数</div><div>555</div></li>
    			<li><img src="{{cdn('img/add/menu/menu_icon1.png')}}"><div>在库数</div><div>555</div></li>
    			<li><img src="{{cdn('img/add/menu/menu_icon1.png')}}"><div>待回库数</div><div>555</div></li>
    		</ul>
    	</div>
    </div>
    
    <div class="rcont4">
		<div class="head">
			<div class="c1">精品展示</div>
    		<!--<div class="c2"></div>-->
		</div>
		<div class="list">
			<ul>
				<li>
					<a href="#" target="_blank"><img src="{{cdn('img/add/menu/menu_icon1.png')}}"><div>精品文物精品文物</div></a>
				</li>
				<li>
					<a href="#" target="_blank"><img src="{{cdn('img/add/menu/menu_icon1.png')}}"><div>精品文物精品文物</div></a>
				</li>
				<li>
					<a href="#" target="_blank"><img src="{{cdn('img/add/menu/menu_icon1.png')}}"><div>精品文物精品文物</div></a>
				</li>
				<li>
					<a href="#" target="_blank"><img src="{{cdn('img/add/menu/menu_icon1.png')}}"><div>精品文物精品文物</div></a>
				</li>
			</ul>
		</div>
    </div>
    
    
    
</div>
@endsection

@section('script')
<script>
$(function(){
	/*菜单滚动设置
	 *oneW:单元宽度，num:一次滚动单元数量，speed:速度ms
	 * */
	function setRmenuScroll(oneW,num,speed){
		oneW = oneW || 90;
		num = num || 5;
		speed = speed || 300;
		var rmenu_i = 0,
			rmenu_len = $("#rmenu .list a").length;
		$("#rmenu .list").css({
			width: oneW*(rmenu_len+1)
		})
		$("#rmenu .mbtn.left").click(function(){
			if(Math.abs(rmenu_i)<rmenu_len-num){
				rmenu_i -= num;
			}
			$("#rmenu .list").animate({
				left:oneW*rmenu_i
			},speed);
		});
		$("#rmenu .mbtn.right").click(function(){
			if(rmenu_i<=-num){
				rmenu_i += num;
			}
			$("#rmenu .list").animate({
				left:oneW*rmenu_i
			},speed);
			
		});
	}
	setRmenuScroll(90,5,500);
});


</script>
@endsection