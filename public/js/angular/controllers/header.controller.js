(function (dvericity) {
    "use strict";
    dvericity.controller('HeaderController', function ($scope, Api) {
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
    });
    dvericity.controller('SearchController', function ($scope, Api) {
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
    });
})(dvericity);