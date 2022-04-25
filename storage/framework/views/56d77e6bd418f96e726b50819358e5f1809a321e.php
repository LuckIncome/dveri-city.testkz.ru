<?php $__env->startSection('page_title', __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular')); ?>

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
            height:100%;
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
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_header'); ?>
    <h1 class="page-title">
        <i class="<?php echo e($dataType->icon); ?>"></i>
        <?php echo e(__('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular')); ?>

    </h1>
    <?php echo $__env->make('voyager::multilingual.language-selector', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form" action="<?php if(isset($dataTypeContent->id)): ?><?php echo e(route('voyager.posts.update', $dataTypeContent->id)); ?><?php else: ?><?php echo e(route('voyager.posts.store')); ?><?php endif; ?>" method="POST" enctype="multipart/form-data">
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
                                <i class="voyager-character"></i> <?php echo e(__('voyager::post.title')); ?>

                                <span class="panel-desc"> <?php echo e(__('voyager::post.title_sub')); ?></span>
                            </h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php echo $__env->make('voyager::multilingual.input-hidden', [
                                '_field_name'  => 'title',
                                '_field_trans' => get_field_translations($dataTypeContent, 'title')
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <input type="text" class="form-control" id="title" name="title" placeholder="<?php echo e(__('voyager::generic.title')); ?>" value="<?php echo e($dataTypeContent->title ?? ''); ?>">
                        </div>
                    </div>

                    <!-- ### CONTENT ### -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(__('voyager::post.content')); ?></h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-resize-full" data-toggle="panel-fullscreen" aria-hidden="true"></a>
                            </div>
                        </div>

                        <div class="panel-body">
                            <?php echo $__env->make('voyager::multilingual.input-hidden', [
                                '_field_name'  => 'body',
                                '_field_trans' => get_field_translations($dataTypeContent, 'body')
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php
                                $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                                $row = $dataTypeRows->where('field', 'body')->first();
                            ?>
                            <?php echo app('voyager')->formField($row, $dataType, $dataTypeContent); ?>

                        </div>
                    </div><!-- .panel -->

                    <!-- ### EXCERPT ### -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo __('voyager::post.excerpt'); ?></h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php echo $__env->make('voyager::multilingual.input-hidden', [
                                '_field_name'  => 'excerpt',
                                '_field_trans' => get_field_translations($dataTypeContent, 'excerpt')
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <textarea class="form-control" name="excerpt"><?php echo e($dataTypeContent->excerpt ?? ''); ?></textarea>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo e(__('voyager::post.additional_fields')); ?></h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php
                                $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                                $exclude = ['title', 'body', 'excerpt', 'slug', 'status', 'category_id', 'author_id', 'featured', 'image', 'meta_description', 'meta_keywords', 'seo_title'];
                            ?>

                            <?php $__currentLoopData = $dataTypeRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!in_array($row->field, $exclude)): ?>
                                    <?php
                                        $display_options = $row->details->display ?? NULL;
                                    ?>
                                    <?php if(isset($row->details->formfields_custom)): ?>
                                        <?php echo $__env->make('voyager::formfields.custom.' . $row->details->formfields_custom, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php else: ?>
                                        <div class="form-group <?php if($row->type == 'hidden'): ?> hidden <?php endif; ?> <?php if(isset($display_options->width)): ?><?php echo e('col-md-' . $display_options->width); ?><?php endif; ?>" <?php if(isset($display_options->id)): ?><?php echo e("id=$display_options->id"); ?><?php endif; ?>>
                                            <?php echo e($row->slugify); ?>

                                            <label for="name"><?php echo e($row->getTranslatedAttribute('display_name')); ?></label>
                                            <?php echo $__env->make('voyager::multilingual.input-hidden-bread-edit-add', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php if($row->type == 'relationship'): ?>
                                                <?php echo $__env->make('voyager::formfields.relationship', ['options' => $row->details], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                <div class="col-md-4">
                    <!-- ### DETAILS ### -->
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-clipboard"></i> <?php echo e(__('voyager::post.details')); ?></h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="slug"><?php echo e(__('voyager::post.slug')); ?></label>
                                <?php echo $__env->make('voyager::multilingual.input-hidden', [
                                    '_field_name'  => 'slug',
                                    '_field_trans' => get_field_translations($dataTypeContent, 'slug')
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <input type="text" class="form-control" id="slug" name="slug"
                                    placeholder="slug"
                                    <?php echo isFieldSlugAutoGenerator($dataType, $dataTypeContent, "slug"); ?>

                                    value="<?php echo e($dataTypeContent->slug ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label for="status"><?php echo e(__('voyager::post.status')); ?></label>
                                <select class="form-control" name="status">
                                    <option value="PUBLISHED"<?php if(isset($dataTypeContent->status) && $dataTypeContent->status == 'PUBLISHED'): ?> selected="selected"<?php endif; ?>><?php echo e(__('voyager::post.status_published')); ?></option>
                                    <option value="DRAFT"<?php if(isset($dataTypeContent->status) && $dataTypeContent->status == 'DRAFT'): ?> selected="selected"<?php endif; ?>><?php echo e(__('voyager::post.status_draft')); ?></option>
                                    <option value="PENDING"<?php if(isset($dataTypeContent->status) && $dataTypeContent->status == 'PENDING'): ?> selected="selected"<?php endif; ?>><?php echo e(__('voyager::post.status_pending')); ?></option>
                                </select>
                            </div>
                            
                                
                                
                                    
                                        
                                    
                                
                            
                            
                                
                                
                            
                        </div>
                    </div>

                    <!-- ### IMAGE ### -->
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-image"></i> <?php echo e(__('voyager::post.image')); ?></h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php if(isset($dataTypeContent->image)): ?>
                                <img src="<?php echo e(filter_var($dataTypeContent->image, FILTER_VALIDATE_URL) ? $dataTypeContent->image : Voyager::image( $dataTypeContent->image )); ?>" style="width:100%" />
                            <?php endif; ?>
                            <input type="file" name="image">
                        </div>
                    </div>

                    <!-- ### SEO CONTENT ### -->
                    <div class="panel panel-bordered panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-search"></i> <?php echo e(__('voyager::post.seo_content')); ?></h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="meta_description"><?php echo e(__('voyager::post.meta_description')); ?></label>
                                <?php echo $__env->make('voyager::multilingual.input-hidden', [
                                    '_field_name'  => 'meta_description',
                                    '_field_trans' => get_field_translations($dataTypeContent, 'meta_description')
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <textarea class="form-control" name="meta_description"><?php echo e($dataTypeContent->meta_description ?? ''); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="meta_keywords"><?php echo e(__('voyager::post.meta_keywords')); ?></label>
                                <?php echo $__env->make('voyager::multilingual.input-hidden', [
                                    '_field_name'  => 'meta_keywords',
                                    '_field_trans' => get_field_translations($dataTypeContent, 'meta_keywords')
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <textarea class="form-control" name="meta_keywords"><?php echo e($dataTypeContent->meta_keywords ?? ''); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="seo_title"><?php echo e(__('voyager::post.seo_title')); ?></label>
                                <?php echo $__env->make('voyager::multilingual.input-hidden', [
                                    '_field_name'  => 'seo_title',
                                    '_field_trans' => get_field_translations($dataTypeContent, 'seo_title')
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <input type="text" class="form-control" name="seo_title" placeholder="SEO Title" value="<?php echo e($dataTypeContent->seo_title ?? ''); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary pull-right">
                <?php if(isset($dataTypeContent->id)): ?><?php echo e(__('voyager::post.update')); ?><?php else: ?> <i class="icon wb-plus-circle"></i> <?php echo e(__('voyager::post.new')); ?> <?php endif; ?>
            </button>
        </form>

        <iframe id="form_target" name="form_target" style="display:none"></iframe>
        <form id="my_form" action="<?php echo e(route('voyager.upload')); ?>" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
            <?php echo e(csrf_field()); ?>

            <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
            <input type="hidden" name="type_slug" id="type_slug" value="<?php echo e($dataType->slug); ?>">
        </form>
    </div>
    <div class="modal fade modal-danger" id="confirm_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> <?php echo e(__('voyager::generic.are_you_sure')); ?></h4>
                </div>
                <div class="modal-body">
                    <h4><?php echo e(__('voyager::generic.are_you_sure_delete')); ?> '<span class="confirm_delete_name"></span>'</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(__('voyager::generic.cancel')); ?></button>
                    <button type="button" class="btn btn-danger" id="confirm_delete"><?php echo e(__('voyager::generic.delete_confirm')); ?>

                    </button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script>
        $('document').ready(function () {
            $('#slug').slugify();

        <?php if($isModelTranslatable): ?>
            $('.side-body').multilingual({"editing": true});
        <?php endif; ?>

        $('.side-body input[data-slug-origin]').each(function(i, el) {
               $(el).slugify();
           });
            $('.form-group').on('click', '.remove-multi-image', function (e) {
               e.preventDefault();
               $image = $(this).siblings('img');
                params = {
                   slug:   '<?php echo e($dataType->slug); ?>',
                   image:  $image.data('image'),
                   id:     $image.data('id'),
                   field:  $image.parent().data('field-name'),
                   _token: '<?php echo e(csrf_token()); ?>'
               }
                $('.confirm_delete_name').text($image.data('image'));
               $('#confirm_delete_modal').modal('show');
           });
            $('#confirm_delete').on('click', function(){
               $.post('<?php echo e(route('voyager.'.$dataType->slug.'.media.remove')); ?>', params, function (response) {
                   if ( response
                       && response.data
                       && response.data.status
                       && response.data.status == 200 ) {
                        toastr.success(response.data.message);
                       $image.parent().fadeOut(300, function() { $(this).remove(); })
                   } else {
                       toastr.error("Error removing image.");
                   }
               });
                $('#confirm_delete_modal').modal('hide');
           });
           $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('voyager::master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/resources/views/vendor/voyager/posts/edit-add.blade.php ENDPATH**/ ?>