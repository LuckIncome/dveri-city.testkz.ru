const dvericity = angular.module('dvericity', [
    'rzSlider',
    'ui.bootstrap'
]);
dvericity.config(function ($locationProvider) {
    $locationProvider.html5Mode({
        enabled: true,
        requireBase: false,
        rewriteLinks: false
    });
});
dvericity.run(function ($http) {
    $http.defaults.headers.common['X-CSRF-Token'] = $('meta[name="csrf-token"]').attr('content');
});

dvericity.factory('Api', function ($http) {
    return {
        getCategoryProducts: function (categoryId) {
            return $http.get('/catalog/' + categoryId + '/products', {
                categoryId: categoryId
            });
        },
        getCurrentCategory: function (slug) {
            return $http.get('/catalog/getCurrent/' + slug);
        },
        getCurrentProduct: function (slug) {
            return $http.get('/product/getCurrent/' + slug);
        },
        addToCart: function (productId) {
            return $http.post('/cart/addToCart/' + productId, {
                productId: productId
            });
        },
        getCartItems: function () {
            return $http.get('/cart/getCartItems');
        },
        addToCompare: function (productId) {
            return $http.post('/compare/add/' + productId, {
                productId: productId
            });
        },
        getCompareItems: function () {
            return $http.get('/compare/getCompareItems');
        },
        getCartContent: function () {
            return $http.get('/cart/getCartContent');
        },
        getCompareContent: function () {
            return $http.get('/compare/getCompareContent');
        },
        updateCart: function (itemId, itemQty) {
            return $http.post('/cart/update', {
                itemId: itemId,
                itemQty: itemQty
            });
        },
        clearCart: function () {
            return $http.get('/cart/clear');
        },
        clearCompare: function () {
            return $http.get('/compare/clear');
        },
        removeFromCart: function (itemId) {
            return $http.post('/cart/remove', {
                itemId: itemId
            });
        },
        removeFromCompare: function (itemId) {
            return $http.post('/compare/remove', {
                itemId: itemId
            });
        },
        checkPaymentStatus: function (orderId, paymentId) {
            return $http.get('/checkout/' + orderId + '/' + paymentId + '/checkPaymentStatus');
        },
        searchByInput: function (input) {
            return $http.post('/searchByInput', {
                input: input
            });
        }

    };

});
dvericity.controller('HeaderController', ['$scope','Api', function ($scope, Api) {
    var hc = {
        cartItems: 0,
        compareItems: 0,
        cartContent: {},
        cartSubtotal: 0,
        init: function () {
            hc.getCartItems();
            hc.getCompareItems();
        },
        getCartItems: function () {
            Api.getCartItems().then(function (response) {
                if (response.data) {
                    hc.cartItems = response.data.cartItems;
                }
            });
        },
        getCompareItems: function () {
            Api.getCompareItems().then(function (response) {
                if (response.data) {
                    hc.compareItems = response.data.itemsCount;
                }
            });
        },
        getCartContent: function () {
            Api.getCartContent().then(function (response) {
                if (response.data) {
                    hc.cartContent = response.data.products;
                    hc.cartSubtotal = response.data.subtotal;
                    hc.cartItems = response.data.itemsCount;
                }
            });
        },
        deleteItemCart: function (product) {
            angular.forEach(hc.cartContent, function (item) {
                if (item === product) {
                    item.qty = 0;
                }
            });
            Api.removeFromCart(product.id).then(function (response) {
                if (response.data) {
                    cart.getResponseData(response.data);
                }
            });
        }
    };
    window.hc = hc;
    angular.extend(hc, this);

    return hc;
}]);
dvericity.controller('SearchController', ['$scope','Api', function ($scope, Api) {
    var sc = {
        searchItems: [],
        searchByInput: function (input) {
            if (input.length < 2) return;
            Api.searchByInput(input).then(function (response) {
                if (response.data) {
                    sc.searchItems = response.data.items;
                    if ($(window).width() > 1200)
                        $('#searchHeader').find('.items').addClass('open');
                    else
                        $('#searchHeaderMobile').find('.items').addClass('open');
                }
            });
        }
    };
    window.sc = sc;
    angular.extend(sc, this);

    return sc;
}]);
dvericity.controller('CartController', ['$scope','Api', function ($scope, Api) {
    var cart = {
        products: [],
        subtotal: 0,
        cartItemsCount: 0,
        total: 0,
        deliveryType: 'self',
        paymentType: 'cash',
        paymentStatus: 'В ожидании оплаты',
        initCart: function () {
            cart.getCartContent();
        },
        getCartContent: function () {
            Api.getCartContent().then(function (response) {
                if (response.data) {
                    cart.getResponseData(response.data);
                }
            });
        },
        getResponseData: function (data) {
            cart.products = data.products;
            angular.forEach(cart.products, function (item) {
                if (item.attributes.regular_price) {
                    item.attributes.regular_price = cart.formatMoney(item.attributes.regular_price * item.quantity);
                }
                item.price = cart.formatMoney(item.price * item.quantity);
            });
            cart.subtotal = cart.formatMoney(data.subtotal);
            cart.cartItemsCount = data.itemsCount;
            cart.total = cart.subtotal;
        },
        removeQuantity: function (product) {
            angular.forEach(cart.products, function (item) {
                if (item === product) {
                    if (item.quantity < 1) {
                        cart.deleteItem(item);
                    }
                    item.quantity = item.quantity - 1;
                    product.quantity = item.quantity;
                }
            });

            Api.updateCart(product.id, product.quantity).then(function (response) {
                if (response.data) {
                    cart.getResponseData(response.data);
                }
            });
        }
        ,
        addQuantity: function (product) {
            angular.forEach(cart.products, function (item) {
                if (item === product) {
                    item.quantity = item.quantity + 1;
                    product.quantity = item.quantity;
                }
            });
            Api.updateCart(product.id, product.quantity).then(function (response) {
                if (response.data) {
                    cart.getResponseData(response.data);
                }
            });
        }
        ,
        deleteItem: function (product) {
            angular.forEach(cart.products, function (item) {
                if (item === product) {
                    item.qty = 0;
                }
            });
            Api.removeFromCart(product.id).then(function (response) {
                if (response.data) {
                    cart.getResponseData(response.data);
                }
            });
            hc.getCartItems();
            cart.getCartContent();
        },
        clearCart: function () {
            Api.clearCart().then(function (response) {
                if (response.data) {
                    cart.getResponseData(response.data);
                }
            });
            hc.getCartItems();
        },
        checkPaymentStatus: function (orderId, paymentId) {
            cart.loading = true;
            Api.checkPaymentStatus(orderId, paymentId).then(function (response) {
                cart.paymentStatus = response.data.paymentStatus;
                cart.loading = false;
                if (response.data.paymentStatusId == 'ok') {
                    setTimeout(function () {
                        window.location.reload();
                    }, 3000);
                }
            });
        },
        formatMoney: function (x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        }
    };
    window.cart = cart;
    angular.extend(cart, this);

    return cart;
}]);
dvericity.controller('CompareController', ['$scope','Api', function ($scope, Api) {
    var comp = {
        products: [],
        itemsCount: 0,
        charsBtn: 'all',
        showDiffBtn: true,
        loading: false,
        init: function () {
            comp.loading = true;
            comp.getCompareContent();
        },
        getCompareContent: function () {
            Api.getCompareContent().then(function (response) {
                if (response.data) {
                    comp.getResponseData(response.data);
                }
            });
        },
        getResponseData: function (data) {
            comp.loading = false;
            comp.products = data.products;
            angular.forEach(comp.products, function (item) {
                if (item.attributes.regular_price) {
                    item.attributes.regular_price = comp.formatMoney(item.attributes.regular_price);
                }
                item.price = comp.formatMoney(item.price);

                if (comp.charsBtn == 'difference') {
                    item.characteristics = item.attributes.uniqueChars;
                } else {
                    item.characteristics = item.attributes.chars;
                }
            });

            comp.itemsCount = data.itemsCount;
            comp.showDiffBtn = (comp.itemsCount > 1);
            if (!comp.showDiffBtn) {
                comp.charsSelect('all');
            }
            hc.getCompareItems();
            comp.showChars(comp.charsBtn);
        },
        deleteItem: function (product) {
            Api.removeFromCompare(product.id).then(function (response) {
                if (response.data) {
                    comp.getResponseData(response.data);
                }
            });
        },
        clearCompare: function () {
            Api.clearCompare().then(function (response) {
                if (response.data) {
                    comp.getResponseData(response.data);
                }
            });
        },
        charsSelect: function (value) {
            comp.charsBtn = value;
            comp.showChars(comp.charsBtn);
        },
        showChars: function (charsValue) {
            if (charsValue == 'difference') {
                var uniqueCharNames = comp.uniqueCharNames();
                angular.forEach(comp.products, function (t) {
                    var chars = [];
                    angular.forEach(t.attributes.chars, function (char) {
                        if (uniqueCharNames.includes(char.name)) {
                            chars.push(char);
                        }
                    });
                    t.characteristics = chars;
                })
            } else {
                angular.forEach(comp.products, function (t) {
                    t.characteristics = t.attributes.chars;
                })
            }
        },
        addToCart: function (product) {
            Api.addToCart(product.id).then(function (response) {
                if (response.data) {
                    product.inCart = true;
                    hc.getCartItems();
                    cart.getCartContent();
                }
            });
        },
        uniqueCharNames: function () {
            var names = [];
            angular.forEach(comp.products, function (product) {
                angular.forEach(product.attributes.chars, function (char) {
                    if (!names.includes(char)) names.push(char);
                });
            });
            const result = [];
            const map = new Map();
            for (const item of names) {
                if (!map.has(item.value)) {
                    map.set(item.value, true);    // set any value to Map
                    result.push({
                        name: item.name,
                        value: item.value
                    });
                }
            }
            var uniq = result
                .map((name) => {
                    return {
                        count: 1,
                        name: name.name
                    }
                })
                .reduce((a, b) => {
                    a[b.name] = (a[b.name] || 0) + b.count
                    return a
                }, {})
            return Object.keys(uniq).filter((a) => uniq[a] > 1);
        },
        formatMoney: function (x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        }
    };
    window.comp = comp;
    angular.extend(comp, this);

    return comp;
}]);
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
        pageSize: 12,
        currentPage: 1,
        filtered_products: [],
        currentCategory: {},
        initFunctions: function (slug) {
            cat.loading = true;
            Api.getCurrentCategory(slug).then(function (response) {
                if (response.data) {
                    cat.currentCategory = response.data.category;
                    cat.getCategoryProducts(cat.currentCategory.id);
                }
            });
        },
        addToCart: function (product) {
            Api.addToCart(product.id).then(function (response) {
                if (response.data) {
                    product.inCart = true;
                    hc.getCartItems();
                    cart.getCartContent();
                }
            });
        },
        addToCompare: function (product) {
            Api.addToCompare(product.id).then(function (response) {
                if (response.data) {
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
                } else {
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
        numberOfPages: function () {
            return Math.ceil(cat.products.length / cat.pageSize);
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
                        if (categoryKey == 'price' && cat.between(item[categoryKey], cat.filters[categoryKey].min, cat.filters[categoryKey].max)) {
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

}]);
dvericity.controller('ProductController', ['$rootScope', '$scope', '$window', '$http', 'Api', function ($rootScope, $scope, $window, $http, Api) {
    var pc = {
        inCart: false,
        inCompare: false,
        activeInterior: false,
        intOptionsActive: true,
        product: {},
        init: function (slug) {
            Api.getCurrentProduct(slug).then(function (response) {
                if (response.data) {
                    pc.product = response.data.product;
                }
            });
        },
        showInterior: function () {
            pc.activeInterior = !pc.activeInterior;
        },
        addToCart: function (product_id) {
            Api.addToCart(product_id).then(function (response) {
                if (response.data) {
                    pc.inCart = true;
                    hc.getCartItems();
                    cart.getCartContent();
                }
            });
        },
        addToCompare: function (product_id) {
            Api.addToCompare(product_id).then(function (response) {
                if (response.data) {
                    pc.inCompare = true;
                    pc.product.inCompare = true;
                    hc.getCompareItems();
                }
            });
        },
        deleteCompare: function (product_id) {
            Api.removeFromCompare(product_id).then(function (response) {
                if (response.data) {
                    pc.inCompare = false;
                    pc.product.inCompare = false;
                    hc.getCompareItems();
                }
            });
        }
    };

    window.pc = pc;
    angular.extend(pc, this);
    return pc;
}]);
dvericity.filter('filtersLimitTo', [function () {
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
