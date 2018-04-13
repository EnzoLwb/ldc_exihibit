<link rel="stylesheet" href="{{cdn('js/plugins/metismenu/metismenu.css')}}">

<style>
.nav.metismenu li>a i.fa{ display: block; float: left;}
.nav.metismenu li>a i:before{ display: inline-block; content: " "; width: 15px; height: 15px; position: relative; top: 2px; background: url({{cdn('img/add/menu/menu_icon1.png')}}) center center / 15px 15px no-repeat;}
.nav.metismenu>li:nth-child(1)>a i:before{ background-image: url({{cdn('img/add/menu/menu_icon1.png')}});}
.nav.metismenu>li:nth-child(2)>a i:before{ background-image: url({{cdn('img/add/menu/menu_icon2.png')}});}
.nav.metismenu>li:nth-child(3)>a i:before{ background-image: url({{cdn('img/add/menu/menu_icon3.png')}});}
.nav.metismenu>li:nth-child(4)>a i:before{ background-image: url({{cdn('img/add/menu/menu_icon4.png')}});}
.nav.metismenu>li:nth-child(5)>a i:before{ background-image: url({{cdn('img/add/menu/menu_icon5.png')}});}
.nav.metismenu>li:nth-child(6)>a i:before{ background-image: url({{cdn('img/add/menu/menu_icon6.png')}});}
.nav.metismenu>li:nth-child(7)>a i:before{ background-image: url({{cdn('img/add/menu/menu_icon7.png')}});}
.nav.metismenu>li:nth-child(8)>a i:before{ background-image: url({{cdn('img/add/menu/menu_icon8.png')}});}
.nav.metismenu>li:nth-child(9)>a i:before{ background-image: url({{cdn('img/add/menu/menu_icon9.png')}});}
.nav.metismenu>li:nth-child(10)>a i:before{ background-image: url({{cdn('img/add/menu/menu_icon10.png')}});}
.nav.metismenu>li:nth-child(11)>a i:before{ background-image: url({{cdn('img/add/menu/menu_icon11.png')}});}
.nav.metismenu>li:nth-child(12)>a i:before{ background-image: url({{cdn('img/add/menu/menu_icon12.png')}});}
.nav.metismenu>li:nth-child(13)>a i:before{ background-image: url({{cdn('img/add/menu/menu_icon13.png')}});}
.nav.metismenu>li:nth-child(14)>a i:before{ background-image: url({{cdn('img/add/menu/menu_icon14.png')}});}
.nav.metismenu>li:nth-child(15)>a i:before{ background-image: url({{cdn('img/add/menu/menu_icon15.png')}});}
.nav.metismenu>li:nth-child(16)>a i:before{ background-image: url({{cdn('img/add/menu/menu_icon15.png')}});}
</style>
<ul class="nav metismenu" id="menuL">
    @foreach($menulist as $menu)
        @can('priv', $menu['priv'])
            <li class="parent-li">
                @if(isset($menu['nodes']) && is_array($menu['nodes']))
                    <a href="javascript:void(0);" class="parent-a">
                        <i class="{{$menu['icon'] or 'fa fa-edit'}}"></i>
                        <span class="nav-label">{{$menu['text']}}</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        @foreach($menu['nodes'] as $submenu)
                            @can('priv', $submenu['priv'])
                                <li class="child-li">
                                    @if(isset($submenu['nodes']) && is_array($submenu['nodes']))
                                        <a href="javascript:void(0);">
                                            {{$submenu['text']}}
                                            <span class="fa arrow"></span>
                                        </a>
                                        <ul class="nav nav-third-level">
                                            @foreach($submenu['nodes'] as $childmenu)
                                                @can('priv', $childmenu['priv'])
                                                    <li class="child-li"><a class="J_menuItem data-a" data-href="{{$childmenu['url'] or 'javascript:void(0);'}}">{{$childmenu['text']}}</a></li>
                                                @endcan
                                            @endforeach
                                        </ul>
                                    @else
                                        <a class="J_menuItem data-a" data-href="{{$submenu['url'] or 'javascript:void(0);'}}">{{$submenu['text']}}</a>
                                    @endif
                                </li>
                            @endcan
                        @endforeach
                    </ul>
                @else
                    <a class='J_menuItem' href="{{$menu['url'] or 'javascript:void(0);'}}">
                        <i class="{{$menu['icon'] or 'fa fa-edit'}}"></i>
                        <span class="nav-label">{{$menu['text']}}</span>
                    </a>
                @endif
            </li>
        @endcan
    @endforeach
</ul>

<script src="{{cdn('js/plugins/metismenu/metismenu.js')}}"></script>
<script type="text/javascript">
    jQuery("#menuL").find('a').prop('target', 'rIframe');
    jQuery('#menuL').metisMenu();    
    $(".child-li").on("click",".data-a",function(){
        $(".data-a").removeClass("active");
        $(this).addClass("active");
        $(this).attr("href",$(this).attr("data-href"));
    });
</script>