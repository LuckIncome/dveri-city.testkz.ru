@extends('partials.app')@section('meta_description',$description ? $description  : 'Акции')@section('seo_title',$seoTitle ? $seoTitle : 'Акции')@section('meta_keywords',$keywords ? $keywords : 'Акции')@section('content') <div class="sales-page def-page"> <div class="pre-header"> <div class="container"> @include('partials.breadcrumbs',['title'=> 'Акции']) <h1>Акции</h1> </div></div><div class="container"> <div class="row"> <div class="content col-12"> <div class="sales"> @foreach($sales as $sale) <div class="sale-block"> <div class="image col-5"> <picture> <source srcset="{{str_replace(pathinfo(Voyager::image($sale->image),PATHINFO_EXTENSION),'webp',Voyager::image($sale->image))}}" type="image/webp"> <source srcset="{{Voyager::image($sale->image)}}" type="image/jpeg"> <img src="{{Voyager::image($sale->image)}}" alt="{{$sale->title}}"> </picture> </div><div class="info col-7"> <a href="{{route('sales.show',$sale->slug)}}"><strong class="title">{{$sale->title}}</strong></a> <p class="text">{{$sale->excerpt}}</p><span class="date">{{Carbon\Carbon::parse($sale->created_at)->format('d.m.Y')}}</span> </div></div>@endforeach </div></div></div></div></div>@endsection