@extends('partials.app')
@section('seo_title',$page->seo_title ? $page->seo_title : $page->title)
@section('meta_keywords',$page->meta_keywords)
@section('meta_description',$page->meta_description)
@section('content')
    <div class="sales-page def-page">
        <div class="pre-header">
            <div class="container">
                @include('partials.breadcrumbs',['title'=> $page->title]) <h1>{{$page->title}}</h1>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="content col-12">
                    <div class="about-content">
                        <div class="text-content">
                            <div class="row page-header">
                                <div class="contacts d-flex flex-wrap w-100">
                                    <div class="nav flex-column nav-pills col-3" id="v-pills-tab" role="tablist"
                                         aria-orientation="vertical">
                                        @foreach($contacts->groupBy('city') as $city=>$items)
                                            <a class="nav-link @if($loop->first) active @endif"
                                               id="v-pills-{{$city}}-tab" data-toggle="pill"
                                               href="#v-pills-{{$city}}" role="tab" aria-controls="v-pills-{{$city}}"
                                               aria-selected="true">Магазин в г. {{$city}}</a>
                                        @endforeach
                                    </div>
                                    <div class="tab-content col-9" id="v-pills-tabContent">
                                        @foreach($contacts->groupBy('city') as $city=>$items)
                                            <div class="tab-pane fade @if($loop->first)show active @endif row d-flex flex-wrap"
                                                 id="v-pills-{{$city}}" role="tabpanel"
                                                 aria-labelledby="v-pills-{{$city}}-tab">
                                                <div class="maps col-7">
                                                    <div class="map" data-city="{{$city}}">
                                                        {!! $items->where('type','map')->first()->value !!}
                                                    </div>
                                                </div>
                                                <div class="texts col-5">
                                                    <div class="city-texts" data-city="{{$city}}">
                                                        @if($items->where('type','address')->count())
                                                            <div class="text">
                                                                <span>Заходите в гости:</span>
                                                                @foreach($items->where('type','address') as $address)
                                                                    <p>{{$address->value}}</p>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                        @if($items->where('type','email')->count())
                                                            <div class="text">
                                                                <span>Пишите нам:</span>
                                                                <p>{{$items->where('type','email')->first()->value}}</p>
                                                            </div>
                                                        @endif
                                                        @if($items->where('type','phone')->count())
                                                            <div class="text">
                                                                <span>Звоните нам:</span>
                                                                @foreach($items->where('type','phone') as $phone)
                                                                    <a href="{{$phone->link}}"
                                                                       class="phone">{{$phone->value}}</a>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                        @if($items->where('type','social')->count())
                                                            <div class="text">
                                                                <span>Заходите в наши соц. сети:</span>
                                                                @foreach($items->where('type','social') as $social)
                                                                    <div class="social">
                                                                        <a rel="nofollow"  href="{{$social->link}}" class="phone">
                                                                            <img src="{{Voyager::image($social->icon)}}"
                                                                                 alt="{{$social->value}}">
                                                                            <span>{{$social->value}}</span>
                                                                        </a>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection