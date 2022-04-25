<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#549f5d"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="description" content="@yield('meta_description')">
    <meta name="keywords" content="@yield('meta_keywords')">
    <meta name="title" content="@yield('seo_title')"/>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="icon" href="/favicon.ico">
    <title>@if(strlen($__env->yieldContent('seo_title')) > 2) @yield('seo_title') @else @yield('title') @endif {{setting('site.title')}}</title>
    <link rel="canonical" href="{{url()->current()}}">
    <script type="application/ld+json">[{"@context" : "http://schema.org","@type" : "Organization","name" : "ТОО Dveri City","description" : "Купить двери на заказ в Алматы в компании Dveri City. ✅Большой ассортимент ✅ Высокое качество и гарантийное обслуживание ✅Своевременная доставка ✅Выгодные цены","url" : "https://dveri-city.kz","telephone" : [" +7(778)888-88-48; +7(727)378-08-87"],"email" : "info@dveri-city.kz"},{"@context" : "http://schema.org","@type" : "Product","@id" : "info@dveri-city.kz","name" : "ТОО Dveri City","category" : [{"@type" : "PropertyValue","name" : "О компании"},{"@type" : "PropertyValue","name" : "Каталог"},{"@type" : "PropertyValue","name" : "Аксессуары"},{"@type" : "PropertyValue","name" : "Акции"},{"@type" : "PropertyValue","name" : "Новости"},{"@type" : "PropertyValue","name" : "Партнеры"},{"@type" : "PropertyValue","name" : "Контакты"},{"@type" : "PropertyValue","name" : "Новинки"}]}]</script>
    <meta property="og:title" content="@if(strlen($__env->yieldContent('seo_title')) > 2) @yield('seo_title') @else @yield('title') @endif - {{setting('site.title')}}"/>
    <meta property="og:description" content="@yield('meta_description')"/>
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta property="og:image" content="@if(strlen($__env->yieldContent('image')) > 2) @yield('image') @else {{ env('APP_URL').'/images/og.jpg'}} @endif"/>
    <meta property="og:image:type" content="image/jpeg"/>
    <meta property="og:image:width" content="300"/>
    <meta property="og:image:height" content="300"/>
    <meta property="og:type" content="article">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" rel="preload" as="style">
    <link href="/css/app.css?v=20042021" rel="stylesheet">
    <link href="/css/app.css?v=20042021" rel="preload" as="style">
</head>