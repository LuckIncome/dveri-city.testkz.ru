@extends('partials.app')@section('seo_title','Оформление заказа')@section('meta_keywords','Оформление заказа')@section('meta_description','Оформление заказа')@section('content') <div class="checkout-complete-page def-page" data-ng-controller="CartController as cart"> <div class="pre-header"> <div class="container"> <h1>Завершение</h1> </div></div><div class="container" data-ng-init="cc.init()"> <div class="row"> <div class="content col-12"> <div class="complete-content"> <strong>Спасибо, ваш заказ №{{$order->id}}принят и уже обрабатывается.</strong> <p>Мы с вами свяжемся в ближайшее рабочее время для уточнения деталей.</p></div><div class="cart-bottom"> <div class="row"> <div class="next col-3"> <a href="{{route('products.index')}}">Продолжить покупки</a> </div><div class="steps col-6 offset-3"> <ul> <li>Корзина</li><li class="arrow"><span class="fa fa-angle-right"></span></li><li>Оформление заказа</li><li class="arrow"><span class="fa fa-angle-right"></span></li><li class="active">Завершение</li></ul> </div></div></div></div></div></div></div>@endsection