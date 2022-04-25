(function (dvericity) {
    "use strict";
    dvericity.controller('ProductController', ['$rootScope','$scope','$window','$http','Api',function ($rootScope, $scope, $window, $http, Api) {
        var pc = {
            inCart : false,
            inCompare : false,
            activeInterior: false,
            intOptionsActive: true,
            product: {},
            init:function (slug) {
                Api.getCurrentProduct(slug).then(function (response) {
                    if (response.data){
                        pc.product = response.data.product;
                    }
                });
            },
            showInterior: function () {
                  pc.activeInterior = !pc.activeInterior;
            },
            addToCart: function (product_id) {
                Api.addToCart(product_id).then(function (response) {
                    if (response.data){
                        pc.inCart = true;
                        hc.getCartItems();
                        cart.getCartContent();
                    }
                });
            },
            addToCompare: function (product_id) {
                Api.addToCompare(product_id).then(function (response) {
                    if (response.data){
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
})(dvericity);