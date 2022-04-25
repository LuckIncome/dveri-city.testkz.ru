(function (dvericity) {
    "use strict";
    dvericity.controller('CompareController', function ($scope, Api) {
        var comp = {
            products: [],
            itemsCount: 0,
            charsBtn: 'all',
            showDiffBtn: true,
            loading:false,
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
                comp.showDiffBtn =(comp.itemsCount > 1);
                if (!comp.showDiffBtn){
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
                            if (uniqueCharNames.includes(char.name)){
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
                    if (response.data){
                        product.inCart = true;
                        hc.getCartItems();
                        cart.getCartContent();
                    }
                });
            },
            uniqueCharNames: function () {
                var names = [];
                angular.forEach(comp.products,function (product) {
                    angular.forEach(product.attributes.chars, function (char) {
                        if (!names.includes(char)) names.push(char);
                    });
                });
                const result = [];
                const map = new Map();
                for (const item of names) {
                    if(!map.has(item.value)){
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
    });
})(dvericity);