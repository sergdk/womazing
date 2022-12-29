const {createApp} = Vue

const cartApp = createApp({
    data() {
        return {
            cart: null,
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
                    this.cart = res.cart.products;
                    this.loader = false;
                    if (Object.keys(res.cart.coupons).length) {
                        this.coupon = res.cart.coupons;
                        this.couponIsEmpty = false;
                    }

                })
                .catch(error => {
                    console.log(error);
                });
        },

        addToCart: function (variable, product_id, variation_id = null, qnt, btn_id = null) {

            this.loader = true
            let btn = btn_id;
            let data = new FormData();
            data.append('action', 'cart_action');
            data.append('details', 'add_to_cart');
            data.append('product_id', product_id);
            data.append('qnt', qnt);

            if (variable === true && variation_id != null) {
                data.append('variation_id', variation_id);
            }

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
                    if (Object.keys(res.cart.coupons).length) {
                        this.coupon = res.cart.coupons;
                        this.couponIsEmpty = false;
                    }
                    let btn_in_dom = document.getElementById(btn);
                    btn_in_dom.style.backgroundColor = 'green';
                    btn_in_dom.textContent = 'Додано!';

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
                    if (Object.keys(res.cart.coupons).length) {
                        this.coupon = res.cart.coupons;
                        this.couponIsEmpty = false;
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },

        openCart: function () {
            const CART_BLOCK = document.querySelector('.cart-block');
            const CART_BG = document.querySelector('.cart-bg');
            CART_BLOCK.classList.toggle('cart-block-open');
            CART_BG.classList.toggle('cart-bg-open');
            document.body.classList.toggle('no-scroll');
        },

        closeCart: function () {
            const CART_BLOCK = document.querySelector('.cart-block');
            const CART_BG = document.querySelector('.cart-bg');
            CART_BLOCK.classList.remove('cart-block-open');
            CART_BG.classList.remove('cart-bg-open');
            document.body.classList.remove('no-scroll');
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
                    if (Object.keys(res.cart.coupons).length) {
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
                    if (Object.keys(res.cart.coupons).length) {
                        this.coupon = res.cart.coupons;
                        this.couponIsEmpty = false;
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }

    },
    mounted: function () {
        this.updateCart();
    },
}).mount('#cart-container');


let addToCartBtn = document.querySelectorAll('.woocommerce-variation-add-to-cart .add-btn, .simple_form .add-btn');

addToCartBtn.forEach((btn) => {
    btn.addEventListener('click', function (e) {
        e.preventDefault();

        let btn_id = this.id;
        let btn_text = this.textContent;
        let btn_bck = this.style.backgroundColor;
        let form = btn.closest('form');

        let buttonCont = btn.closest('.woocommerce-variation-add-to-cart');

        if (btn.getAttribute('data-type') === 'simple' || !buttonCont.classList.contains('woocommerce-variation-add-to-cart-disabled')) {
            let product_id = form.querySelector('input[name=product_id]').value;

            let variationFields = form.querySelector('input[name=variation_id]')
            let variation_id = undefined

            if (variationFields != null) {
                variation_id = form.querySelector('input[name=variation_id]').value;
            }

            let qnt = form.querySelector('input[name=quantity]').value;

            if (product_id !== undefined) {
                btn.style.backgroundColor = 'gray';
                btn.setAttribute('disabled', true);
                btn.textContent = 'Додаємо...';

                if (variation_id !== undefined) {
                    cartApp.addToCart(true, product_id, variation_id, qnt, btn_id);
                } else {
                    cartApp.addToCart(true, product_id, null, qnt, btn_id);
                }

                setTimeout(function () {
                    form.reset();
                    btnFastPurchase = form.querySelector('.purchase-onclick');
                    if (!btnFastPurchase.classList.contains('simple_product')) {
                        btnFastPurchase.setAttribute('disabled', true)
                    }
                    btn.textContent = btn_text;
                    btn.removeAttribute('disabled');
                    btn.style.backgroundColor = btn_bck;
                }, 5000)
            } else {
                // alert('Виберіть колір та розмір товару');
            }
        }
    })
})

let form = document.querySelector('.variations_form');

if (form !== null) {
    form.addEventListener('change', function (e) {
        let attrKeys = JSON.parse(form.getAttribute('data-keys'))
        let keysStatuses = []

        attrKeys.forEach((key) => {
            let data = {
                status: false,
                value: null
            }

            let fieldsContainer = document.getElementById(key);
            let fields = fieldsContainer.querySelectorAll('input[type=radio]')

            fields.forEach((field) => {
                if (field.checked === true) {
                    data.status = true
                    data.value = field.value
                }
            })

            keysStatuses[key] = data
        })

        const areTrue = Object.values(keysStatuses).every(
            item => item.status === true
        );

        let variation_id_field = form.querySelector('input[name=variation_id]');
        let variationBtnBlock = form.querySelector('.woocommerce-variation-add-to-cart')
        let variationBtn = variationBtnBlock.querySelector('.add-btn');
        let fastPurchaseBtn = variationBtnBlock.querySelector('.purchase-onclick');
        let pricesBlock = document.querySelector('.prices .new-price')

        let res = null

        if (areTrue === true) {
            res = findVariation(keysStatuses)
        }

        if (res !== null && res !== undefined) {
            let variation_id = res.variation_id;
            pricesBlock.textContent = res.display_price + ' грн.'
            pricesBlock.setAttribute('data-product-price', res.display_price + ' грн.')
            variation_id_field.value = variation_id;

            variationBtnBlock.classList.remove('woocommerce-variation-add-to-cart-disabled');
            variationBtnBlock.classList.add('woocommerce-variation-add-to-cart-enabled');

            variationBtn.classList.remove('disabled');
            variationBtn.classList.remove('wc-variation-selection-needed');

            fastPurchaseBtn.removeAttribute('disabled');
        }
    })
}


function findVariation(attributes) {

    // let form_var_data = document.querySelector('.variations_form').getAttribute('data-product_variations');
    let form_var_data = document.querySelector('.variations_form').getAttribute('data-vars');
    let form_data = JSON.parse(form_var_data);
    let attrs = []

    for (const [key, value] of Object.entries(attributes)) {
        attrs['attribute_' + key] = value.value
    }
    let res = null

    if(form_data.length == 1){
        res = form_data[0]
    } else{
        for (const [key, value] of Object.entries(attrs)) {
            form_data.forEach((item, index) => {

                if (Object.values(item.attributes).indexOf(value) > -1) {
                } else {
                    delete form_data[index]
                }
            })
        }
        form_data.forEach((item, index) => {
            res = item
        })
    }
    return res;
}