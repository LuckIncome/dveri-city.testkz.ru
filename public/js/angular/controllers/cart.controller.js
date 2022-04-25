(function (dvericity) {
    "use strict";
    dvericity.controller('CartController', function ($scope, Api) {
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
                        item.attributes.regular_price = cart.formatMoney(item.attributes.regular_price*item.quantity);
                    }
                    item.price = cart.formatMoney(item.price*item.quantity);
                });
                cart.subtotal = cart.formatMoney(data.subtotal);
                cart.cartItemsCount = data.itemsCount;
                cart.total = cart.subtotal;
            },
            removeQuantity: function (product) {
                angular.forEach(cart.products, function (item) {
                    if (item === product) {
                        if (item.quantity < 1){
                            cart.deleteItem(item);
                        }
                        item.quantity = item.quantity - 1;
                        product.quantity = item.quantity;
                    }
                });

                Api.updateCart(product.id,product.quantity).then(function (response) {
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
                Api.updateCart(product.id,product.quantity).then(function (response) {
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
            checkPaymentStatus: function (orderId,paymentId) {
                cart.loading = true;
                Api.checkPaymentStatus(orderId,paymentId).then(function (response) {
                    cart.paymentStatus = response.data.paymentStatus;
                    cart.loading = false;
                    if (response.data.paymentStatusId == 'ok') {
                        setTimeout(function () {
                            window.location.reload();
                        },3000);
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
    });
})(dvericity);