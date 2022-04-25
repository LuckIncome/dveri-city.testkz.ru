@extends('partials.app')@section('meta_description',$description ? $description : 'Партнеры')@section('seo_title',$seoTitle ? $seoTitle : 'Партнеры')@section('meta_keywords',$keywords ? $keywords : 'Партнеры')@section('content')
    <div class="sales-page partners-page def-page">
        <div class="pre-header">
            <div class="container"> @include('partials.breadcrumbs',['title'=> 'Партнеры']) <h1>Партнеры</h1></div>
        </div>
        <div class="container">
            <div class="row">
                <div class="content col-12">
                    <div class="about-content">
                        <div class="text">
                            <div class="row page-header partners">
                                <div class="row col-12">
                                    <div class="col-3">
                                        <div class="nav flex-column nav-pills sticky-top" data-offset-top="205"
                                             id="v-pills-tab" role="tablist"
                                             aria-orientation="vertical"> @foreach($partners as $partner) <a
                                                    class="nav-link @if($partner->id==1) active @endif"
                                                    id="v-pills-{{$partner->id}}-tab" data-toggle="pill"
                                                    href="#v-pills-{{$partner->id}}" role="tab"
                                                    aria-controls="v-pills-{{$partner->id}}"
                                                    aria-selected="{{$partner->id==1 ? 'true' : 'false'}}">{{$partner->name}}</a> @endforeach
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="tab-content"
                                             id="v-pills-tabContent"> @foreach($partners as $partner)
                                                <div class="tab-pane fade @if($partner->id==1) show active @endif"
                                                     id="v-pills-{{$partner->id}}" role="tabpanel"
                                                     aria-labelledby="v-pills-{{$partner->id}}-tab">
                                                    <div class="mb-5 pt-5 col-12"><h4
                                                                class="mb-5">{{$partner->name}}</h4>
                                                        <div class="content"> @if($partner->logo)
                                                                <div class="media col-3 mt-5 mb-5">
                                                                    <picture>
                                                                        <source srcset="{{str_replace(pathinfo(Voyager::image($partner->logo))['extension'],'webp',Voyager::image($partner->logo))}}"
                                                                                type="image/webp">
                                                                        <source srcset="{{Voyager::image($partner->logo)}}"
                                                                                type="image/jpeg">
                                                                        <img src="{{Voyager::image($partner->logo)}}"
                                                                             alt="{{$partner->name}}"></picture>
                                                                </div>@endif
                                                            <div class="row">
                                                                <div class="partner-content @if(json_decode($partner->gallery) != null) col-6 @else col-12 @endif">{!! $partner->content !!}</div>
                                                                @if(json_decode($partner->gallery) != null)
                                                                    <div class="slider col-6">
                                                                        <div class="sliderContent">
                                                                            @foreach(json_decode($partner->gallery) as $img)
                                                                                <div class="item">
                                                                                    <picture>
                                                                                        <source srcset="{{str_replace(pathinfo(Voyager::image($img))['extension'],'webp',Voyager::image($img))}}"
                                                                                                type="image/webp">
                                                                                        <source srcset="{{Voyager::image($img)}}"
                                                                                                type="image/jpeg">
                                                                                        <img src="{{Voyager::image($img)}}"
                                                                                             alt="{{$partner->name}}">
                                                                                    </picture>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                        <div class="sliderArrows">
                                                                            <a class="prevSlide">Previous</a>
                                                                            <p>1/10</p>
                                                                            <a class="nextSlide">Next</a>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>@endforeach </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>@endsection