@extends('partials.app')@section('meta_description',$description ? $description : 'Новости')@section('seo_title',$seoTitle ? $seoTitle  : 'Новости')@section('meta_keywords',$keywords ? $keywords  : 'Новости')@section('content')
    <div class="sales-page def-page">
        <div class="pre-header">
            <div class="container"> @include('partials.breadcrumbs',['title'=> 'Новости']) <h1>Новости</h1></div>
        </div>
        <div class="container">
            <div class="row">
                <div class="content col-12">
                    <div class="sales"> @foreach($posts as $post)
                            <div class="sale-block">
                                <div class="image col-5">
                                    <picture>
                                        <source
                                            srcset="{{str_replace(pathinfo(Voyager::image($post->getThumbnail($post->image, 'medium')), PATHINFO_EXTENSION),'webp',Voyager::image($post->getThumbnail($post->image, 'medium')))}}"
                                            type="image/webp">
                                        <source srcset="{{Voyager::image($post->getThumbnail($post->image, 'medium'))}}"
                                                type="image/jpeg">
                                        <img src="{{Voyager::image($post->getThumbnail($post->image, 'medium'))}}"
                                             alt="{{$post->getTranslatedAttribute('title',$locale,$fallbackLocale)}}">
                                    </picture>
                                </div>
                                <div class="info col-7"><a class="title"
                                                           href="{{route('posts.show',$post->slug)}}">{{$post->getTranslatedAttribute('title',$locale,$fallbackLocale)}}</a>
                                    <p class="text">{{$post->getTranslatedAttribute('excerpt',$locale,$fallbackLocale)}}</p>
                                    <span
                                        class="date">{{Carbon\Carbon::parse($post->created_at)->format('d.m.Y')}}</span>
                                </div>
                            </div>@endforeach
                            {!! $posts->links('partials.pagination') !!}
                            </div>
                </div>
            </div>
        </div>
    </div>@endsection
