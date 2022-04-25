@extends('voyager::master')

@section('page_title', __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular)

@section('css')
    <style>
        .panel .mce-panel {
            border-left-color: #fff;
            border-right-color: #fff;
        }

        .panel .mce-toolbar,
        .panel .mce-statusbar {
            padding-left: 20px;
        }

        .panel .mce-edit-area,
        .panel .mce-edit-area iframe,
        .panel .mce-edit-area iframe html {
            padding: 0 10px;
            min-height: 350px;
        }

        .mce-content-body {
            color: #555;
            font-size: 14px;
        }

        .panel.is-fullscreen .mce-statusbar {
            position: absolute;
            bottom: 0;
            width: 100%;
            z-index: 200000;
        }

        .panel.is-fullscreen .mce-tinymce {
            height: 100%;
        }

        .panel.is-fullscreen .mce-edit-area,
        .panel.is-fullscreen .mce-edit-area iframe,
        .panel.is-fullscreen .mce-edit-area iframe html {
            height: 100%;
            position: absolute;
            width: 99%;
            overflow-y: scroll;
            overflow-x: hidden;
            min-height: 100%;
        }

        a.remove {
            margin-left: 10px;
            font-size: 18px;
            cursor: pointer;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.27.0/slimselect.min.js" integrity="sha512-yqitdsAKt7YxIgEMBoZpBrlcwv8MvYeUjegatZuAGkt+G7g8bpQ6kXGlKlhNfVRmHrQG+CwlxZljdB7wUR2xnw==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.27.0/slimselect.min.css" integrity="sha512-ifnw7uo3puPqptyK3NL7X5zAilwRd7g5DjC8NDov8+zS/wyT1jaoVocaLePaZ7cGzflIFv58/4AtqImsO8UYxw==" crossorigin="anonymous" />
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form"
              action="@if(isset($dataTypeContent->id)){{ route('voyager.products.update', $dataTypeContent->id) }}@else{{ route('voyager.products.store') }}@endif"
              method="POST" enctype="multipart/form-data">
            <!-- PUT Method if we are editing -->
            @if(isset($dataTypeContent->id))
                {{ method_field("PUT") }}
            @endif
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-8">
                    <!-- ### TITLE ### -->
                    <div class="panel">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="voyager-character"></i> Название Товара
                            </h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse"
                                   aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            @include('voyager::multilingual.input-hidden', [
                                '_field_name'  => 'name',
                                '_field_trans' => get_field_translations($dataTypeContent, 'name')
                            ])
                            <input type="text" class="form-control" id="title" name="name"
                                   placeholder="Название товара"
                                   value="@if(isset($dataTypeContent->name)){{ $dataTypeContent->name }}@endif">
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Основы товара</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse"
                                   aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                @php
                                    $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                                    $exclude = ['name', 'excerpt', 'thumb', 'slug', 'images', 'category_id','variation_id','meta_description','meta_keywords','seo_title'];
                                @endphp

                                @foreach($dataTypeRows as $row)
                                    @if(!in_array($row->field, $exclude))
                                        @php
                                            $display_options = isset($row->details->display) ? $row->details->display : NULL;
                                        @endphp
                                        @if (isset($row->details->formfields_custom))
                                            @include('voyager::formfields.custom.' . $row->details->formfields_custom)
                                        @else
                                            <div class="form-group @if($row->type == 'hidden') hidden @endif @if(isset($display_options->width)){{ 'col-md-' . $display_options->width }}@endif" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                                {{ $row->slugify }}
                                                @if($row->type !== 'relationship')
                                                    <label for="name">{{ $row->display_name }}</label>
                                                @endif
                                                @include('voyager::multilingual.input-hidden-bread-edit-add')
                                                @if($row->type == 'relationship')
                                                    @include('voyager::formfields.relationship')
                                                @else
                                                    {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                                @endif

                                                @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                                    {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            </div>

                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Опции товара для вариации
                                <span class="panel-desc">(цвет,высота и т.д)</span></h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse"
                                   aria-hidden="true"></a>
                            </div>
                        </div>
                        <div id="optionsGroupRu" class="panel-body">
                            @if($dataTypeContent->optionsRu)
                                @foreach($dataTypeContent->optionsRu as $key => $option)
                                    <div class="form-group new_optionRu{{($key > 0)?$key:null}}">
                                        <label>
                                            <span class="panel-desc">Опция</span>
                                            <input type="text" class="form-control"
                                                   name="optionRu{{($key > 0)?$key:null}}"
                                                   placeholder="цвет" value="{{$option->option}}">
                                        </label>
                                        <label>
                                            <span class="panel-desc">Значение</span>
                                            <input type="text" class="form-control"
                                                   name="option_valueRu{{($key > 0)?$key:null}}"
                                                   placeholder="черный" value="{{$option->value}}">
                                        </label>
                                        <label>
                                            <span class="panel-desc">Цвет(если опция "Цвет")</span>
                                            <input type="text" class="form-control jscolor"
                                                   name="colorRu{{($key > 0)?$key:null}}"
                                                   placeholder="#ffffff" value="{{$option->value_color}}">
                                        </label>
                                        <a class="remove">&times;</a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div id="optionsGroupKz" class="panel-body">
                            @if($dataTypeContent->optionsKz)
                                @foreach($dataTypeContent->optionsKz as $key => $option)
                                    <div class="form-group new_optionKz{{($key > 0)?$key:null}}">
                                        <label>
                                            <span class="panel-desc">Опция</span>
                                            <input type="text" class="form-control"
                                                   name="optionKz{{($key > 0)?$key:null}}"
                                                   placeholder="цвет" value="{{$option->option}}">
                                        </label>
                                        <label>
                                            <span class="panel-desc">Значение</span>
                                            <input type="text" class="form-control"
                                                   name="option_valueKz{{($key > 0)?$key:null}}"
                                                   placeholder="черный" value="{{$option->value}}">
                                        </label>
                                        <label>
                                            <span class="panel-desc">Цвет(если опция "Цвет")</span>
                                            <input type="text" class="form-control jscolor"
                                                   name="colorKz{{($key > 0)?$key:null}}"
                                                   placeholder="#ffffff" value="{{$option->value_color}}">
                                        </label>
                                        <a class="remove">&times;</a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="panel-body">
                            <input class="btn btn-primary" type='button' value='Добавить' id='addOptionRuButton'>
                            <input class="btn btn-primary" type='button' value='Добавить' id='addOptionKzButton'>
                        </div>
                    </div>
                    {{--Main Characteristics--}}
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Основные характеристики товара
                                <span class="panel-desc">(Внешняя отделка,ручка и т.д)</span></h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse"
                                   aria-hidden="true"></a>
                            </div>
                        </div>
                        <div id="characteristicGroupRu" class="panel-body">
                            @if($dataTypeContent->charsRu)
                                @foreach($dataTypeContent->charsRu as $key => $char)
                                    <div class="form-group new_char{{($key > 0)?$key:null}}">
                                        <label>
                                            <span class="panel-desc">Название</span>
                                            <input type="text" class="form-control"
                                                   name="charRu{{($key > 0)?$key:null}}"
                                                   placeholder="Внешняя отделка" value="{{$char['name']}}">
                                        </label>
                                        <label>
                                            <span class="panel-desc">Значение</span>
                                            <input type="text" class="form-control"
                                                   name="charRu_value{{($key > 0)?$key:null}}"
                                                   placeholder="медь" value="{{$char['value']}}">
                                        </label>
                                        <a class="remove">&times;</a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div id="characteristicGroupKz" class="panel-body">
                            @if($dataTypeContent->charsKz)
                                @foreach($dataTypeContent->charsKz as $key => $char)
                                    <div class="form-group new_char{{($key > 0)?$key:null}}">
                                        <label>
                                            <span class="panel-desc">Название</span>
                                            <input type="text" class="form-control"
                                                   name="charKz{{($key > 0)?$key:null}}"
                                                   placeholder="Внешняя отделка" value="{{$char['name']}}">
                                        </label>
                                        <label>
                                            <span class="panel-desc">Значение</span>
                                            <input type="text" class="form-control"
                                                   name="charKz_value{{($key > 0)?$key:null}}"
                                                   placeholder="медь" value="{{$char['value']}}">
                                        </label>
                                        <a class="remove">&times;</a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="panel-body">
                            <input class="btn btn-primary" type='button' value='Добавить' id='addCharRuButton'>
                            <input class="btn btn-primary" type='button' value='Добавить' id='addCharKzButton'>
                        </div>
                    </div>
                    <!-- ### CONTENT ### -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Описание</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-resize-full" data-toggle="panel-fullscreen"
                                   aria-hidden="true"></a>
                            </div>
                        </div>

                        <div class="panel-body">
                            @include('voyager::multilingual.input-hidden', [
                                '_field_name'  => 'excerpt',
                                '_field_trans' => get_field_translations($dataTypeContent, 'excerpt')
                            ])
                            @php
                                $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                                $row = $dataTypeRows->where('field', 'excerpt')->first();

                            @endphp
                            {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                        </div>
                    </div><!-- .panel -->

                </div>
                <div class="col-md-4">
                    <!-- ### DETAILS ### -->
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-clipboard"></i> Детали товара
                            </h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse"
                                   aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="slug">ЧПУ ссылка</label>
                                <input type="text" class="form-control" id="slug" name="slug"
                                       placeholder="slug"
                                       {!! isFieldSlugAutoGenerator($dataType, $dataTypeContent, "slug") !!}
                                       value="@if(isset($dataTypeContent->slug)){{ $dataTypeContent->slug }}@endif">
                            </div>
                            <div class="form-group">
                                <label for="category_id">Категория</label>
                                <select class="form-control" name="category_id">
                                    @foreach(TCG\Voyager\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}"
                                                @if(isset($dataTypeContent->category_id) && $dataTypeContent->category_id == $category->id) selected="selected"@endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ### IMAGE ### -->
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-image"></i> Изображение</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse"
                                   aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            @if(isset($dataTypeContent->thumb))
                                <img src="{{ filter_var($dataTypeContent->thumb, FILTER_VALIDATE_URL) ? $dataTypeContent->thumb : Voyager::image( $dataTypeContent->thumb ) }}"
                                     style="width:50%"/>
                            @endif
                            <input type="file" name="thumb">
                        </div>
                    </div>

                    <!-- ### IMAGES ### -->
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-image"></i> Галерея</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse"
                                   aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            @if(isset($dataTypeContent->images))
                                @foreach(json_decode($dataTypeContent->images) as $image)
                                    <img src="{{ filter_var($image, FILTER_VALIDATE_URL) ? $image : Voyager::image( $image ) }}"
                                         style="width:10%"/>
                                @endforeach
                            @endif
                            <input type="file" name="images[]" multiple>
                        </div>
                    </div>
                    <!-- ### Variations ### -->
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-image"></i> Вариативные товары</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse"
                                   aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body" style="overflow: visible;">
                            <select name="variations[]" id="variations" multiple>
                                <option value="null"></option>
                                @foreach($variants as $variant)
                                    <option value="{{$variant->sku}}"
                                            @if($dataTypeContent->variation_id && in_array($variant->sku,unserialize($dataTypeContent->variation_id))) selected @endif>{{$variant->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- ### Metas ### -->
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-image"></i> Meta Данные</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse"
                                   aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body" style="overflow: visible;">
                            @include('voyager::multilingual.input-hidden', [
                                '_field_name'  => 'meta_keywords',
                                '_field_trans' => get_field_translations($dataTypeContent, 'meta_keywords')
                            ])
                            @php
                                $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                                $includes = ['meta_description','meta_keywords','seo_title'];
                            @endphp

                            @foreach($dataTypeRows as $row)
                                @if(in_array($row->field, $includes))
                                    @php
                                        $display_options = isset($row->details->display) ? $row->details->display : NULL;
                                    @endphp
                                    @if (isset($row->details->formfields_custom))
                                        @include('voyager::formfields.custom.' . $row->details->formfields_custom)
                                    @else
                                        <div class="form-group @if($row->type == 'hidden') hidden @endif @if(isset($display_options->width)){{ 'col-md-' . $display_options->width }}@endif" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                            {{ $row->slugify }}
                                            @if($row->type !== 'relationship')
                                                <label for="name">{{ $row->display_name }}</label>
                                            @endif
                                            @include('voyager::multilingual.input-hidden-bread-edit-add')
                                            @if($row->type == 'relationship')
                                                @include('voyager::formfields.relationship')
                                            @else
                                                {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                            @endif

                                            @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                                {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                            @endforeach
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary pull-right">
                @if(isset($dataTypeContent->id))Обновить @else <i
                        class="icon wb-plus-circle"></i> Создать @endif
            </button>
        </form>

        <iframe id="form_target" name="form_target" style="display:none"></iframe>
        <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
              enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
            {{ csrf_field() }}
            <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
            <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
        </form>
    </div>
    <div class="modal fade modal-danger" id="confirm_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
                </div>

                <div class="modal-body">
                    <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        var params = {};
        var $file;

        function deleteHandler(tag, isMulti) {
            return function() {
                $file = $(this).siblings(tag);

                params = {
                    slug:   '{{ $dataType->slug }}',
                    filename:  $file.data('file-name'),
                    id:     $file.data('id'),
                    field:  $file.parent().data('field-name'),
                    multi: isMulti,
                    _token: '{{ csrf_token() }}'
                }

                $('.confirm_delete_name').text(params.filename);
                $('#confirm_delete_modal').modal('show');
            };
        }
        $('document').ready(function () {
            $('#slug').slugify();

            @if ($isModelTranslatable)
            $('.side-body').multilingual({"editing": true});
                    @endif


            var counterRu = 0;
            @if($dataTypeContent->optionsRu && $dataTypeContent->optionsRu->count())
                counterRu = {{$dataTypeContent->optionsRu->count()}} +1;
            @endif


            $("#addOptionRuButton").click(function () {

                if (counterRu > 10) {
                    alert("Only 10 textboxes allow");
                    return false;
                }

                var newTextBoxDiv = $(document.createElement('div'))
                    .attr("class", 'form-group new_optionRu' + counterRu);

                newTextBoxDiv.after().html('<label><span class="panel-desc">Опция #' + counterRu + '</span>' +
                    '<input type="text" class="form-control" name="optionRu' + counterRu +
                    '" value=""></label>' + '<label><span class="panel-desc">Значение #' + counterRu + '</span>' +
                    '<input type="text" class="form-control" name="option_valueRu' + counterRu +
                    '" value=""></label> + <label><span class="panel-desc">Цвет(если опция "Цвет")' + counterRu + '</span>' +
                    '<input type="text" class="form-control jscolor" name="colorRu' + counterRu +
                    '" value=""></label><a class="remove">&times;</a>');
                newTextBoxDiv.appendTo("#optionsGroupRu");

                var inputs = $(newTextBoxDiv).find('.jscolor');
                for (var i = 0; i < inputs.length; i++) {
                    var picker = new jscolor(inputs[i]);
                    picker.fromHSV(360 / 100 * i, 100, 100)
                }
                counterRu++;
            });

            $(".remove").click(function () {
                if (counterRu == 1) {
                    alert("No more textbox to remove");
                    return false;
                }
                counterRu--;
                $(this).parent().remove();
            });

            $("#optionsGroupRu").on("click", ".remove", function (e) { //user click on remove text links
                e.preventDefault();
                $(this).parent('div').remove();
                counterRu--;
            });

            var counterKz = 0;
            @if($dataTypeContent->optionsKz && $dataTypeContent->optionsKz->count())
                counterKz = {{$dataTypeContent->optionsKz->count()}} +1;
            @endif

            $("#addOptionKzButton").click(function () {

                if (counterKz > 10) {
                    alert("Only 10 textboxes allow");
                    return false;
                }

                var newTextBoxDiv = $(document.createElement('div'))
                    .attr("class", 'form-group new_optionKz' + counterKz);

                newTextBoxDiv.after().html('<label><span class="panel-desc">Опция #' + counterKz + '</span>' +
                    '<input type="text" class="form-control" name="optionKz' + counterKz +
                    '" value=""></label>' + '<label><span class="panel-desc">Значение #' + counterKz + '</span>' +
                    '<input type="text" class="form-control" name="option_valueKz' + counterKz +
                    '" value=""></label> + <label><span class="panel-desc">Цвет(если опция "Цвет")' + counterKz + '</span>' +
                    '<input type="text" class="form-control jscolor" name="colorKz' + counterKz +
                    '" value=""></label><a class="remove">&times;</a>');
                newTextBoxDiv.appendTo("#optionsGroupKz");

                var inputs = $(newTextBoxDiv).find('.jscolor');
                for (var i = 0; i < inputs.length; i++) {
                    var picker = new jscolor(inputs[i]);
                    picker.fromHSV(360 / 100 * i, 100, 100)
                }
                counterKz++;
            });

            $(".remove").click(function () {
                if (counterKz == 1) {
                    alert("No more textbox to remove");
                    return false;
                }
                counterKz--;
                $(this).parent().remove();
            });

            $("#optionsGroupKz").on("click", ".remove", function (e) { //user click on remove text links
                e.preventDefault();
                $(this).parent('div').remove();
                counterKz--;
            });

            $('#optionsGroupRu').show();
            $('#optionsGroupKz').hide();
            $('#characteristicGroupKz').hide();
            $('#characteristicGroupRu').show();
            $('#addCharRuButton').show();
            $('#addCharKzButton').hide();
            $('#addOptionRuButton').show();
            $('#addOptionKzButton').hide();

            $('.language-selector').find('input[type=radio]').change(function () {
                var locale = $(this).attr('id');
                if (locale == 'ru') {
                    $('#characteristicGroupKz').hide();
                    $('#addCharKzButton').hide();
                    $('#characteristicGroupRu').show();
                    $('#addCharRuButton').show();

                    $('#optionsGroupRu').show();
                    $('#optionsGroupKz').hide();
                    $('#addOptionRuButton').show();
                    $('#addOptionKzButton').hide();

                } else {
                    $('#characteristicGroupKz').show();
                    $('#addCharKzButton').show();
                    $('#characteristicGroupRu').hide();
                    $('#addCharRuButton').hide();

                    $('#optionsGroupRu').hide();
                    $('#optionsGroupKz').show();
                    $('#addOptionRuButton').hide();
                    $('#addOptionKzButton').show();
                }
            });

            /*CharacteristicsRU add remove dynamic start*/
            var counterCharRu = 1;
            @if($dataTypeContent->charsRu && count($dataTypeContent->charsRu))
                counterCharRu = {{count($dataTypeContent->charsRu)}} +1;
            @endif

            $("#addCharRuButton").click(function () {

                if (counterCharRu > 50) {
                    alert("Не более 50 характеристик");
                    return false;
                }

                var newTextBoxDiv = $(document.createElement('div'))
                    .attr("class", 'form-group new_char' + counterCharRu);

                newTextBoxDiv.after().html('<label><span class="panel-desc">Название #' + counterCharRu + '</span>' +
                    '<input type="text" class="form-control" name="charRu' + counterCharRu +
                    '" value=""></label>' + '<label><span class="panel-desc">Значение #' + counterCharRu + '</span>' +
                    '<input type="text" class="form-control" name="charRu_value' + counterCharRu +
                    '" value=""></label><a class="remove">&times;</a>');
                newTextBoxDiv.appendTo("#characteristicGroupRu");
                counterCharRu++;
            });

            $(".remove").click(function () {
                if (counterCharRu == 1) {
                    alert("No more textbox to remove");
                    return false;
                }
                counterCharRu--;
                $(this).parent().remove();
            });

            $("#characteristicGroupRu").on("click", ".remove", function (e) { //user click on remove text links
                e.preventDefault();
                $(this).parent('div').remove();
                counterCharRu--;
            });
            /*CharacteristicsRU add remove dynamic end*/


            /*CharacteristicsKZ add remove dynamic start*/
            var counterCharKz = 1;
            @if($dataTypeContent->charsKz && count($dataTypeContent->charsKz))
                counterCharKz = {{count($dataTypeContent->charsKz)}} +1;
            @endif

            $("#addCharKzButton").click(function () {

                if (counterCharKz > 50) {
                    alert("Не более 50 характеристик");
                    return false;
                }

                var newTextBoxDiv = $(document.createElement('div'))
                    .attr("class", 'form-group new_char' + counterCharKz);

                newTextBoxDiv.after().html('<label><span class="panel-desc">Название #' + counterCharKz + '</span>' +
                    '<input type="text" class="form-control" name="charKz' + counterCharKz +
                    '" value=""></label>' + '<label><span class="panel-desc">Значение #' + counterCharKz + '</span>' +
                    '<input type="text" class="form-control" name="charKz_value' + counterCharKz +
                    '" value=""></label><a class="remove">&times;</a>');
                newTextBoxDiv.appendTo("#characteristicGroupKz");
                counterCharKz++;
            });

            $(".remove").click(function () {
                if (counterCharKz == 1) {
                    alert("No more textbox to remove");
                    return false;
                }
                counterCharKz--;
                $(this).parent().remove();
            });

            $("#characteristicGroupKz").on("click", ".remove", function (e) { //user click on remove text links
                e.preventDefault();
                $(this).parent('div').remove();
                counterCharKz--;
            });
            /*CharacteristicsKz add remove dynamic end*/

            new SlimSelect({
                select: '#variations'
            });
            $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
            $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
            $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
            $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));
            $('#confirm_delete').on('click', function(){
                $.post('{{ route('voyager.'.$dataType->slug.'.media.remove') }}', params, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {

                        toastr.success(response.data.message);
                        $file.parent().fadeOut(300, function() { $(this).remove(); })
                    } else {
                        toastr.error("Error removing file.");
                    }
                });

                $('#confirm_delete_modal').modal('hide');
            });
        });
    </script>
@stop
