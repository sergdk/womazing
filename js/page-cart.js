const pageCartApp = createApp({
    data() {
        return {
            cart: null,
            total_w_coupon: null,
            total: null,
            cartCount: 0,
            isEmpty: true,
            loader: true,
            coupon: null,
            couponIsEmpty: true
        }
    },
    methods: {
        updateCart: function () {
            this.loader = true;
            let data = new FormData();
            data.append('action', 'cart_action');
            data.append('details', 'get_cart');

            var config = {
                method: 'post',
                url: '/wp-admin/admin-ajax.php',
                data: data
            };

            axios(config)
                .then(response => {
                    let res = response.data;

                    if (res.cart.count != 0) {
                        this.isEmpty = true;
                    } else {
                        this.isEmpty = false;
                    }
                    this.cartCount = Number(res.cart.count);
                    this.total = Number(res.cart.total);
                    this.total_w_coupon = Number(res.cart.total_w_coupon);
                    this.cart = res.cart.products;
                    this.loader = false;
                    if(Object.keys(res.cart.coupons).length){
                        this.coupon = res.cart.coupons;
                        this.couponIsEmpty = false;
                    }
                    console.log(res);
                    console.log(this.total_w_coupon);
                })
                .catch(error => {
                    console.log(error);
                });
        },

        removeFromCart: function (index) {

            this.loader = true
            let data = new FormData();
            data.append('action', 'cart_action');
            data.append('details', 'remove_from_cart');
            data.append('item', index);

            var config = {
                method: 'post',
                url: '/wp-admin/admin-ajax.php',
                data: data
            };

            axios(config)
                .then(response => {
                    let res = response.data;
                    if (res.cart.count != 0) {
                        this.isEmpty = true;
                    } else {
                        this.isEmpty = false;
                    }
                    this.cartCount = Number(res.cart.count);
                    this.total = Number(res.cart.total);
                    this.cart = res.cart.products;
                    this.loader = false;
                    if(Object.keys(res.cart.coupons).length){
                        this.coupon = res.cart.coupons;
                        this.couponIsEmpty = false;
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        qntItemPlus: function (index) {
            this.loader = true
            let data = new FormData();
            data.append('action', 'cart_action');
            data.append('details', 'item_plus');
            data.append('index', index);

            var config = {
                method: 'post',
                url: '/wp-admin/admin-ajax.php',
                data: data
            };

            axios(config)
                .then(response => {
                    let res = response.data;
                    if (res.cart.count != 0) {
                        this.isEmpty = true;
                    } else {
                        this.isEmpty = false;
                    }
                    this.cartCount = Number(res.cart.count);
                    this.total = Number(res.cart.total);
                    this.cart = res.cart.products;
                    this.loader = false;
                    if(Object.keys(res.cart.coupons).length){
                        this.coupon = res.cart.coupons;
                        this.couponIsEmpty = false;
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },

        qntItemMinus: function (index) {
            this.loader = true
            let data = new FormData();
            data.append('action', 'cart_action');
            data.append('details', 'item_minus');
            data.append('index', index);

            var config = {
                method: 'post',
                url: '/wp-admin/admin-ajax.php',
                data: data
            };

            axios(config)
                .then(response => {
                    let res = response.data;
                    if (res.cart.count != 0) {
                        this.isEmpty = true;
                    } else {
                        this.isEmpty = false;
                    }
                    this.cartCount = Number(res.cart.count);
                    this.total = Number(res.cart.total);
                    this.cart = res.cart.products;
                    this.loader = false;
                    if(Object.keys(res.cart.coupons).length){
                        this.coupon = res.cart.coupons;
                        this.couponIsEmpty = false;
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        setCoupon: function (){
            if(this.coupon !== null){
                this.loader = true
                let data = new FormData();
                data.append('action', 'cart_action');
                data.append('details', 'set_coupon');
                data.append('coupon', this.coupon);

                var config = {
                    method: 'post',
                    url: '/wp-admin/admin-ajax.php',
                    data: data
                };

                axios(config)
                    .then(response => {
                        let res = response.data;
                        if (res.cart.count != 0) {
                            this.isEmpty = true;
                        } else {
                            this.isEmpty = false;
                        }
                        this.cartCount = Number(res.cart.count);
                        this.total = Number(res.cart.total);
                        this.cart = res.cart.products;
                        this.loader = false;
                        if(Object.keys(res.cart.coupons).length){
                            this.coupon = res.cart.coupons;
                            this.couponIsEmpty = false;
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }


        }

    },
    mounted: function () {
        this.updateCart();
    },
});


const pageCart = document.getElementById('pageCart');


if(pageCart !== null){
    pageCartApp.mount('#pageCart');
}


// let addToCartBtn = document.querySelectorAll('.woocommerce-variation-add-to-cart button');
//
// addToCartBtn.forEach((btn) => {
//     btn.addEventListener('click', function (e) {
//         e.preventDefault();
//
//         let buttonCont = btn.closest('.woocommerce-variation-add-to-cart');
//
//         if (!buttonCont.classList.contains('woocommerce-variation-add-to-cart-disabled')) {
//             let product_id = buttonCont.querySelector('input[name=product_id]').value;
//             let variation_id = buttonCont.querySelector('input[name=variation_id]').value;
//             let qnt = buttonCont.querySelector('input[name=quantity]').value;
//
//             if (product_id !== undefined && variation_id !== undefined) {
//                 cartApp.addToCart(true, product_id, variation_id, qnt);
//             }
//         }
//     })
// })
//
// let form = document.querySelector('.variations_form');
//
// if(form !== null){
//     form.addEventListener('change', function (e) {
//         let colorField = form.querySelector('input[name=attribute_pa_color]:checked');
//         let sizeField = form.querySelector('input[name=attribute_pa_size]:checked');
//
//         let variation_id_field = form.querySelector('input[name=variation_id]');
//         let variationBtnBlock = form.querySelector('.woocommerce-variation-add-to-cart')
//         let variationBtn = variationBtnBlock.querySelector('button');
//
//         if (colorField !== null && sizeField !== null) {
//             let colorFieldValue = colorField.value;
//             let sizeFieldValue = sizeField.value;
//             let res = findVariation(sizeFieldValue, colorFieldValue);
//
//             if(res !== null && res !== undefined){
//                 let variation_id = res.variation_id;
//                 variation_id_field.value = variation_id;
//
//                 variationBtnBlock.classList.remove('woocommerce-variation-add-to-cart-disabled');
//                 variationBtnBlock.classList.add('woocommerce-variation-add-to-cart-enabled');
//
//                 variationBtn.classList.remove('disabled');
//                 variationBtn.classList.remove('wc-variation-selection-needed');
//             }
//         }
//     })
// }
//
//
// function findVariation(size, color) {
//     let form_var_data = document.querySelector('.variations_form').getAttribute('data-product_variations');
//     let form_data = JSON.parse(form_var_data);
//
//     let res = null;
//
//     form_data.forEach((item, index) => {
//         if (item.attributes.attribute_pa_color === color && item.attributes.attribute_pa_size === size) {
//             res = form_data[index];
//         }
//     })
//
//     return res;
// }