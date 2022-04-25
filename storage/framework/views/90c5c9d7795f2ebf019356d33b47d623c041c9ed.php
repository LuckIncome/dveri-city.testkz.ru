<div id="modalFilter" class="modal">
    <div class="modal-content popup-rights"><span class="close close-filter"><svg width="25" height="18"
                                                                                  viewBox="0 0 17 16" fill="none"
                                                                                  xmlns="http://www.w3.org/2000/svg"> <path
                        d="M1 1L16.5 16.5" stroke="#989898"/> <path d="M16.5 1L1 16.5" stroke="#989898"/> </svg></span>
        <div class="popup-filter-full">
            <div class="popup-content">
                <div class="filter"><p class="title main">Фильтр</p>
                    <div class="category-select"> <?php if($category->slug !=='aksessuary'): ?> <select name="category"
                                                                                               onchange="cat.refreshCategory(this.value)"> <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="/catalog/<?php echo e($cat->slug); ?>"
                                        <?php if($category->id==$cat->id): ?> selected <?php endif; ?>><?php echo e($cat->name); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select> <?php endif; ?> </div>
                    <div class="type price-range"><p class="title">Цена (тг)</p><a class="collapseBtn"
                                                                                   data-toggle="collapse"
                                                                                   href="#collapsePriceRangeModal"
                                                                                   role="button" aria-expanded="true"
                                                                                   aria-controls="collapsePriceRangeModal">
                            <i class="fa fa-chevron-down"></i> </a>
                        <div class="collapse show" id="collapsePriceRangeModal">
                            <div class="inputs">
                                <div class="price-min"><input type="text" data-ng-model="cat.filters.price.min"/> <span>тг</span>
                                </div>
                                <span>—</span>
                                <div class="price-max"><input type="text" data-ng-model="cat.filters.price.max"/> <span>тг</span>
                                </div>
                            </div>
                            <div data-rzslider data-rz-slider-model="cat.filters.price.min"
                                 data-rz-slider-high="cat.filters.price.max"
                                 data-rz-slider-options="cat.filters.price.options"></div>
                        </div>
                    </div>
                </div>
                <div class="filter-block" data-ng-repeat="(categoryKey, category) in cat.filters"
                     data-ng-if="categoryKey !='price'" data-ng-init="cat.filter[category]={}">
                    <hr class="row">
                    <div class="filter">
                        <div class="type color"><p class="title" data-ng-if="categoryKey !='brand'">{{categoryKey}}</p>
                            <p class="title" data-ng-if="categoryKey=='brand'">Бренд</p><a class="collapseBtn"
                                                                                           data-toggle="collapse"
                                                                                           data-ng-href="#collapseModal-{{$index}}"
                                                                                           role="button"
                                                                                           aria-expanded="true"
                                                                                           aria-controls="collapseModal-{{$index}}">
                                <i class="fa fa-chevron-down"></i> </a>
                            <div class="collapse show" id="collapseModal-{{$index}}">
                                <div class="checkboxes">
                                    <div class="box custom-control custom-checkbox"
                                         data-ng-repeat="(key, value) in category | filtersLimitTo: category.filtersLimit"
                                         data-ng-if="key !='filtersLimit'"><label> <input type="checkbox"
                                                                                          class="custom-control-input"
                                                                                          name="example1"
                                                                                          data-ng-model="cat.filters[categoryKey][key]">
                                            <span class="custom-control-label">{{key}}</span> </label> <span
                                                class="count">{{(cat.filtered_products | filter:key:true).length}}</span>
                                    </div>
                                    <a class="more" data-ng-show="cat.showMoreFilter(category)"
                                       data-ng-click="category.filtersLimit=category.length">Показать больше <i
                                                class="fa fa-chevron-down"></i></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div></div>
    </div>
</div><?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/resources/views/partials/modalFilterCatalog.blade.php ENDPATH**/ ?>