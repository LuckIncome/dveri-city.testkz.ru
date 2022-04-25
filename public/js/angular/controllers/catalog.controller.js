(function (dvericity) {
    "use strict";
    dvericity.controller('CatalogController', ['$rootScope', '$scope', '$window', '$http', '$timeout', 'Api', function ($rootScope, $scope, $window, $http, $timeout, Api) {
        var cat = {
            products: [],
            orderExpression: 'is_new',
            options_key: '',
            options: '',
            brands: '',
            filterExpression: {},
            loading: false,
            filters: {
                price: {
                    min: 0,
                    max: 10000,
                    options: {
                        floor: 0,
                        ceil: 10000,
                        translate: function (value) {
                            return value + ' ₸';
                        }
                    }
                }
            },
            categories: [],
            pageSize:12,
            currentPage: 1,
            filtered_products: [],
            currentCategory:{},
            initFunctions: function (slug) {
                cat.loading = true;
                Api.getCurrentCategory(slug).then(function (response) {
                    if (response.data){
                        cat.currentCategory = response.data.category;
                        cat.getCategoryProducts(cat.currentCategory.id);
                    }
                });
            },
            addToCart: function (product) {
                Api.addToCart(product.id).then(function (response) {
                    if (response.data){
                        product.inCart = true;
                        hc.getCartItems();
                        cart.getCartContent();
                    }
                });
            },
            addToCompare: function (product) {
                Api.addToCompare(product.id).then(function (response) {
                    if (response.data){
                        product.inCompare = true;
                        hc.getCompareItems();
                    }
                });
            },
            deleteCompareItem: function (product) {
                Api.removeFromCompare(product.id).then(function (response) {
                    if (response.data) {
                        product.inCompare = false;
                        hc.getCompareItems();
                    }
                });
            },
            refreshSlider: function () {
                $timeout(function () {
                    $rootScope.$broadcast('rzSliderForceRender');
                }, 10);
            },
            refreshCategory: function (category) {
               window.location.href = category;
            },
            getCategoryProducts: function (categoryId) {
                Api.getCategoryProducts(categoryId).then(function (response) {
                    if (response.data && response.data.products) {
                        cat.loading = false;
                        angular.forEach(response.data.products, function (item) {
                            if (item.sale_price) {
                                item.sale_price = cat.formatMoney(item.sale_price);
                            }
                            item.regular_price = cat.formatMoney(item.regular_price);
                            item.rating_array = [].constructor(item.rating);
                        });
                        cat.products = response.data.products;
                        cat.options_key = response.data.options_key;
                        cat.options = response.data.options;
                        cat.brands = response.data.brands;
                        cat.filters = response.data.filters;
                        angular.forEach(cat.filters, function (filter, key) {
                            if (key === 'price') {
                                cat.filters[key] = {
                                    min: filter.min,
                                    max: filter.max,
                                    options: {
                                        floor: 0,
                                        ceil: filter.max,
                                        translate: function (value) {
                                            return value + ' ₸';
                                        }
                                    }
                                };
                            } else {
                                filter.filtersLimit = 4;
                            }
                        });
                    }else {
                        cat.products = [];
                        cat.loading = false;
                    }
                });
            },

            changeOrderExpression: function (expression) {
                cat.orderExpression = expression.toString();
                cat.currentPage = 1;
            },
            changePageSize: function (pageSize) {
               cat.pageSize = pageSize;
            },
            numberOfPages:function(){
                return Math.ceil(cat.products.length/cat.pageSize);
            },
            updateFilters: function (item) {

                var validCounter = 0;
                var trueCounter;
                for (var categoryKey in cat.filters) {
                    trueCounter = 0;
                    for (var valueKey in cat.filters[categoryKey]) {
                        if (valueKey == 'filtersLimit') {
                            continue;
                        }
                        if (cat.filters[categoryKey][valueKey]) {
                            trueCounter = 1;
                            if (categoryKey == 'price' &&  cat.between(item[categoryKey],cat.filters[categoryKey].min,cat.filters[categoryKey].max)) {
                                trueCounter = -1;
                                break;
                            }
                            if (item[categoryKey] === valueKey) {
                                trueCounter = -1;
                                break;
                            }
                        }
                    }
                    validCounter += +(trueCounter < 1);
                }
                return validCounter === Object.keys(cat.filters).length;
            },
            showMoreFilter: function (category) {
                return category.filtersLimit + 1 < Object.keys(category).length;
            },
            formatMoney: function (x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
            },
            between: function (x, min, max) {
                return x >= min && x <= max;
            },
        };

        window.cat = cat;
        angular.extend(cat, this);
        return cat;

    }]).filter('filtersLimitTo', [function () {
        return function (obj, limit) {
            var keys = Object.keys(obj);
            if (keys.length < 1) {
                return [];
            }
            var ret = new Object,
                count = 0;
            angular.forEach(keys, function (key, arrayIndex) {
                if (count >= limit) {
                    return false;
                }
                ret[key] = obj[key];
                count++;
            });
            return ret;
        };
    }]);
})(dvericity);