angular.module('dvericity')
    .factory('Api', function ($http) {
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
                return $http.post('/cart/addToCart/'+productId, {
                    productId: productId
                });
            },
            getCartItems: function () {
                return $http.get('/cart/getCartItems');
            },
            addToCompare: function (productId) {
                return $http.post('/compare/add/'+productId, {
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
            updateCart: function (itemId,itemQty) {
                return $http.post('/cart/update', {
                    itemId: itemId,
                    itemQty:itemQty
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
            checkPaymentStatus: function (orderId,paymentId) {
                return $http.get('/checkout/'+orderId+'/'+paymentId+'/checkPaymentStatus');
            },
            searchByInput: function (input) {
                return $http.post('/searchByInput',{
                    input:input
                });
            }

        };

    });