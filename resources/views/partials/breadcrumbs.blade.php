<div class="breadcrumbs">
    <ul>
        <li><a href="/">Главная</a></li>
        <li class="arrow"><span class="fa fa-angle-right"></span></li>@if(isset($subtitle)) @if(isset($titleLink))
            <li><a href="{{$titleLink}}">{{$title}}</a></li>@else
            <li class="current"><span>{{$title}}</span></li>@endif
        <li class="arrow"><span class="fa fa-angle-right"></span></li>
        <li class="current"><span>{{$subtitle}}</span></li>@else
            <li class="current"><span>{{$title}}</span></li>@endif </ul>
</div>