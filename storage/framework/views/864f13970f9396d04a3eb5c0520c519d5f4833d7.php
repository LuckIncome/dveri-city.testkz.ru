<?php $__env->startSection('page_title', __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular); ?>

<?php $__env->startSection('css'); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_header'); ?>
    <h1 class="page-title">
        <i class="<?php echo e($dataType->icon); ?>"></i>
        <?php echo e(__('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular); ?>

    </h1>
    <?php echo $__env->make('voyager::multilingual.language-selector', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form"
              action="<?php if(isset($dataTypeContent->id)): ?><?php echo e(route('voyager.products.update', $dataTypeContent->id)); ?><?php else: ?><?php echo e(route('voyager.products.store')); ?><?php endif; ?>"
              method="POST" enctype="multipart/form-data">
            <!-- PUT Method if we are editing -->
            <?php if(isset($dataTypeContent->id)): ?>
                <?php echo e(method_field("PUT")); ?>

            <?php endif; ?>
            <?php echo e(csrf_field()); ?>


            <div class="row">
                <div class="col-md-8">
                    <!-- ### TITLE ### -->
                    <div class="panel">
                        <?php if(count($errors) > 0): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

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
                            <?php echo $__env->make('voyager::multilingual.input-hidden', [
                                '_field_name'  => 'name',
                                '_field_trans' => get_field_translations($dataTypeContent, 'name')
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <input type="text" class="form-control" id="title" name="name"
                                   placeholder="Название товара"
                                   value="<?php if(isset($dataTypeContent->name)): ?><?php echo e($dataTypeContent->name); ?><?php endif; ?>">
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
                                <?php
                                    $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                                    $exclude = ['name', 'excerpt', 'thumb', 'slug', 'images', 'category_id','variation_id','meta_description','meta_keywords','seo_title'];
                                ?>

                                <?php $__currentLoopData = $dataTypeRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(!in_array($row->field, $exclude)): ?>
                                        <?php
                                            $display_options = isset($row->details->display) ? $row->details->display : NULL;
                                        ?>
                                        <?php if(isset($row->details->formfields_custom)): ?>
                                            <?php echo $__env->make('voyager::formfields.custom.' . $row->details->formfields_custom, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php else: ?>
                                            <div class="form-group <?php if($row->type == 'hidden'): ?> hidden <?php endif; ?> <?php if(isset($display_options->width)): ?><?php echo e('col-md-' . $display_options->width); ?><?php endif; ?>" <?php if(isset($display_options->id)): ?><?php echo e("id=$display_options->id"); ?><?php endif; ?>>
                                                <?php echo e($row->slugify); ?>

                                                <?php if($row->type !== 'relationship'): ?>
                                                    <label for="name"><?php echo e($row->display_name); ?></label>
                                                <?php endif; ?>
                                                <?php echo $__env->make('voyager::multilingual.input-hidden-bread-edit-add', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                <?php if($row->type == 'relationship'): ?>
                                                    <?php echo $__env->make('voyager::formfields.relationship', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                <?php else: ?>
                                                    <?php echo app('voyager')->formField($row, $dataType, $dataTypeContent); ?>

                                                <?php endif; ?>

                                                <?php $__currentLoopData = app('voyager')->afterFormFields($row, $dataType, $dataTypeContent); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $after): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php echo $after->handle($row, $dataType, $dataTypeContent); ?>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            <?php if($dataTypeContent->optionsRu): ?>
                                <?php $__currentLoopData = $dataTypeContent->optionsRu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-group new_optionRu<?php echo e(($key > 0)?$key:null); ?>">
                                        <label>
                                            <span class="panel-desc">Опция</span>
                                            <input type="text" class="form-control"
                                                   name="optionRu<?php echo e(($key > 0)?$key:null); ?>"
                                                   placeholder="цвет" value="<?php echo e($option->option); ?>">
                                        </label>
                                        <label>
                                            <span class="panel-desc">Значение</span>
                                            <input type="text" class="form-control"
                                                   name="option_valueRu<?php echo e(($key > 0)?$key:null); ?>"
                                                   placeholder="черный" value="<?php echo e($option->value); ?>">
                                        </label>
                                        <label>
                                            <span class="panel-desc">Цвет(если опция "Цвет")</span>
                                            <input type="text" class="form-control jscolor"
                                                   name="colorRu<?php echo e(($key > 0)?$key:null); ?>"
                                                   placeholder="#ffffff" value="<?php echo e($option->value_color); ?>">
                                        </label>
                                        <a class="remove">&times;</a>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                        <div id="optionsGroupKz" class="panel-body">
                            <?php if($dataTypeContent->optionsKz): ?>
                                <?php $__currentLoopData = $dataTypeContent->optionsKz; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-group new_optionKz<?php echo e(($key > 0)?$key:null); ?>">
                                        <label>
                                            <span class="panel-desc">Опция</span>
                                            <input type="text" class="form-control"
                                                   name="optionKz<?php echo e(($key > 0)?$key:null); ?>"
                                                   placeholder="цвет" value="<?php echo e($option->option); ?>">
                                        </label>
                                        <label>
                                            <span class="panel-desc">Значение</span>
                                            <input type="text" class="form-control"
                                                   name="option_valueKz<?php echo e(($key > 0)?$key:null); ?>"
                                                   placeholder="черный" value="<?php echo e($option->value); ?>">
                                        </label>
                                        <label>
                                            <span class="panel-desc">Цвет(если опция "Цвет")</span>
                                            <input type="text" class="form-control jscolor"
                                                   name="colorKz<?php echo e(($key > 0)?$key:null); ?>"
                                                   placeholder="#ffffff" value="<?php echo e($option->value_color); ?>">
                                        </label>
                                        <a class="remove">&times;</a>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                        <div class="panel-body">
                            <input class="btn btn-primary" type='button' value='Добавить' id='addOptionRuButton'>
                            <input class="btn btn-primary" type='button' value='Добавить' id='addOptionKzButton'>
                        </div>
                    </div>
                    
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
                            <?php if($dataTypeContent->charsRu): ?>
                                <?php $__currentLoopData = $dataTypeContent->charsRu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $char): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-group new_char<?php echo e(($key > 0)?$key:null); ?>">
                                        <label>
                                            <span class="panel-desc">Название</span>
                                            <input type="text" class="form-control"
                                                   name="charRu<?php echo e(($key > 0)?$key:null); ?>"
                                                   placeholder="Внешняя отделка" value="<?php echo e($char['name']); ?>">
                                        </label>
                                        <label>
                                            <span class="panel-desc">Значение</span>
                                            <input type="text" class="form-control"
                                                   name="charRu_value<?php echo e(($key > 0)?$key:null); ?>"
                                                   placeholder="медь" value="<?php echo e($char['value']); ?>">
                                        </label>
                                        <a class="remove">&times;</a>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                        <div id="characteristicGroupKz" class="panel-body">
                            <?php if($dataTypeContent->charsKz): ?>
                                <?php $__currentLoopData = $dataTypeContent->charsKz; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $char): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-group new_char<?php echo e(($key > 0)?$key:null); ?>">
                                        <label>
                                            <span class="panel-desc">Название</span>
                                            <input type="text" class="form-control"
                                                   name="charKz<?php echo e(($key > 0)?$key:null); ?>"
                                                   placeholder="Внешняя отделка" value="<?php echo e($char['name']); ?>">
                                        </label>
                                        <label>
                                            <span class="panel-desc">Значение</span>
                                            <input type="text" class="form-control"
                                                   name="charKz_value<?php echo e(($key > 0)?$key:null); ?>"
                                                   placeholder="медь" value="<?php echo e($char['value']); ?>">
                                        </label>
                                        <a class="remove">&times;</a>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
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
                            <?php echo $__env->make('voyager::multilingual.input-hidden', [
                                '_field_name'  => 'excerpt',
                                '_field_trans' => get_field_translations($dataTypeContent, 'excerpt')
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php
                                $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                                $row = $dataTypeRows->where('field', 'excerpt')->first();

                            ?>
                            <?php echo app('voyager')->formField($row, $dataType, $dataTypeContent); ?>

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
                                       <?php echo isFieldSlugAutoGenerator($dataType, $dataTypeContent, "slug"); ?>

                                       value="<?php if(isset($dataTypeContent->slug)): ?><?php echo e($dataTypeContent->slug); ?><?php endif; ?>">
                            </div>
                            <div class="form-group">
                                <label for="category_id">Категория</label>
                                <select class="form-control" name="category_id">
                                    <?php $__currentLoopData = TCG\Voyager\Models\Category::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>"
                                                <?php if(isset($dataTypeContent->category_id) && $dataTypeContent->category_id == $category->id): ?> selected="selected"<?php endif; ?>><?php echo e($category->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            <?php if(isset($dataTypeContent->thumb)): ?>
                                <img src="<?php echo e(filter_var($dataTypeContent->thumb, FILTER_VALIDATE_URL) ? $dataTypeContent->thumb : Voyager::image( $dataTypeContent->thumb )); ?>"
                                     style="width:50%"/>
                            <?php endif; ?>
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
                            <?php if(isset($dataTypeContent->images)): ?>
                                <?php $__currentLoopData = json_decode($dataTypeContent->images); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <img src="<?php echo e(filter_var($image, FILTER_VALIDATE_URL) ? $image : Voyager::image( $image )); ?>"
                                         style="width:10%"/>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
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
                                <?php $__currentLoopData = $variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($variant->sku); ?>"
                                            <?php if($dataTypeContent->variation_id && in_array($variant->sku,unserialize($dataTypeContent->variation_id))): ?> selected <?php endif; ?>><?php echo e($variant->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            <?php echo $__env->make('voyager::multilingual.input-hidden', [
                                '_field_name'  => 'meta_keywords',
                                '_field_trans' => get_field_translations($dataTypeContent, 'meta_keywords')
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php
                                $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                                $includes = ['meta_description','meta_keywords','seo_title'];
                            ?>

                            <?php $__currentLoopData = $dataTypeRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(in_array($row->field, $includes)): ?>
                                    <?php
                                        $display_options = isset($row->details->display) ? $row->details->display : NULL;
                                    ?>
                                    <?php if(isset($row->details->formfields_custom)): ?>
                                        <?php echo $__env->make('voyager::formfields.custom.' . $row->details->formfields_custom, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php else: ?>
                                        <div class="form-group <?php if($row->type == 'hidden'): ?> hidden <?php endif; ?> <?php if(isset($display_options->width)): ?><?php echo e('col-md-' . $display_options->width); ?><?php endif; ?>" <?php if(isset($display_options->id)): ?><?php echo e("id=$display_options->id"); ?><?php endif; ?>>
                                            <?php echo e($row->slugify); ?>

                                            <?php if($row->type !== 'relationship'): ?>
                                                <label for="name"><?php echo e($row->display_name); ?></label>
                                            <?php endif; ?>
                                            <?php echo $__env->make('voyager::multilingual.input-hidden-bread-edit-add', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php if($row->type == 'relationship'): ?>
                                                <?php echo $__env->make('voyager::formfields.relationship', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php else: ?>
                                                <?php echo app('voyager')->formField($row, $dataType, $dataTypeContent); ?>

                                            <?php endif; ?>

                                            <?php $__currentLoopData = app('voyager')->afterFormFields($row, $dataType, $dataTypeContent); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $after): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo $after->handle($row, $dataType, $dataTypeContent); ?>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary pull-right">
                <?php if(isset($dataTypeContent->id)): ?>Обновить <?php else: ?> <i
                        class="icon wb-plus-circle"></i> Создать <?php endif; ?>
            </button>
        </form>

        <iframe id="form_target" name="form_target" style="display:none"></iframe>
        <form id="my_form" action="<?php echo e(route('voyager.upload')); ?>" target="form_target" method="post"
              enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
            <?php echo e(csrf_field()); ?>

            <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
            <input type="hidden" name="type_slug" id="type_slug" value="<?php echo e($dataType->slug); ?>">
        </form>
    </div>
    <div class="modal fade modal-danger" id="confirm_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> <?php echo e(__('voyager::generic.are_you_sure')); ?></h4>
                </div>

                <div class="modal-body">
                    <h4><?php echo e(__('voyager::generic.are_you_sure_delete')); ?> '<span class="confirm_delete_name"></span>'</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(__('voyager::generic.cancel')); ?></button>
                    <button type="button" class="btn btn-danger" id="confirm_delete"><?php echo e(__('voyager::generic.delete_confirm')); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script>
        var params = {};
        var $file;

        function deleteHandler(tag, isMulti) {
            return function() {
                $file = $(this).siblings(tag);

                params = {
                    slug:   '<?php echo e($dataType->slug); ?>',
                    filename:  $file.data('file-name'),
                    id:     $file.data('id'),
                    field:  $file.parent().data('field-name'),
                    multi: isMulti,
                    _token: '<?php echo e(csrf_token()); ?>'
                }

                $('.confirm_delete_name').text(params.filename);
                $('#confirm_delete_modal').modal('show');
            };
        }
        $('document').ready(function () {
            $('#slug').slugify();

            <?php if($isModelTranslatable): ?>
            $('.side-body').multilingual({"editing": true});
                    <?php endif; ?>


            var counterRu = 0;
            <?php if($dataTypeContent->optionsRu && $dataTypeContent->optionsRu->count()): ?>
                counterRu = <?php echo e($dataTypeContent->optionsRu->count()); ?> +1;
            <?php endif; ?>


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
            <?php if($dataTypeContent->optionsKz && $dataTypeContent->optionsKz->count()): ?>
                counterKz = <?php echo e($dataTypeContent->optionsKz->count()); ?> +1;
            <?php endif; ?>

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
            <?php if($dataTypeContent->charsRu && count($dataTypeContent->charsRu)): ?>
                counterCharRu = <?php echo e(count($dataTypeContent->charsRu)); ?> +1;
            <?php endif; ?>

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
            <?php if($dataTypeContent->charsKz && count($dataTypeContent->charsKz)): ?>
                counterCharKz = <?php echo e(count($dataTypeContent->charsKz)); ?> +1;
            <?php endif; ?>

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
                $.post('<?php echo e(route('voyager.'.$dataType->slug.'.media.remove')); ?>', params, function (response) {
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('voyager::master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/resources/views/vendor/voyager/products/edit-add.blade.php ENDPATH**/ ?>