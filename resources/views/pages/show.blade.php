@extends('partials.app')
@section('seo_title',$page->seo_title ? $page->seo_title : $page->title)
@section('meta_keywords',$page->meta_keywords)
@section('meta_description',$page->meta_description)
@section('content')
    <div class="@if($page->slug=='about') about-page @else sales-page @endif def-page">
        <div class="pre-header">
            <div class="container"> @include('partials.breadcrumbs',['title'=> $page->title]) <h1>{{$page->title}}</h1>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="content col-12">
                    <div class="about-content">
                        @if($page->slug !='about')
                            <div class="text-content">
                                <div class="row page-header">
                                    @if($page->image)
                                        <div class="col-5">
                                            <picture>
                                                <source srcset="{{str_replace(pathinfo(Voyager::image($page->image))['extension'],'webp',Voyager::image($page->image))}}"
                                                        type="image/webp">
                                                <source srcset="{{Voyager::image($page->image)}}" type="image/jpeg">
                                                <img src="{{Voyager::image($page->image)}}" alt="{{$page->seo_title}}">
                                            </picture>
                                        </div>
                                    @endif
                                    @if($page->slug=='contacts')
                                        <div class="col-4"><p>{{$page->excerpt}}</p>{!! $page->body !!}</div>
                                        <div class="col-8 frameMap">{!! setting('site.js_map') !!}</div>
                                    @else
                                        <div class="col-7"><h2>{{$page->title}}</h2>
                                            <p>{{$page->excerpt}}</p></div>
                                        <div class="col-12">{!! $page->body !!}</div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="render"><h2>{{$page->excerpt}}</h2></div>
                            <div class="text-content">{!! $page->body !!}</div>@endif </div>
                </div>
            </div>
        </div>
    </div>
    @if($page->slug=='about')
        @include('partials.modalVideo')
    @endif
@endsection