<link rel="stylesheet" href="{{cdn('js/plugins/metismenu/metismenu.css')}}">

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