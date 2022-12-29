let LOADER_WRAPPER = document.querySelector('.loader-wrapper');
window.addEventListener('load', function () {
    LOADER_WRAPPER.classList.add('loader-wrapper-open');
    setTimeout(() => {
        LOADER_WRAPPER.remove();
    }, 600)
})

let phoneInputs = jQuery('input[name=phone], input[name=billing_phone]');
phoneInputs.mask("+38(999) 999-99-99")

// SCROLL HEADER
const HEADER = document.querySelector('.header');
window.onscroll = function () {
    // let scrollTrigger = 60;
    if (window.scrollY >= 60 || window.pageYOffset >= 60) {
        HEADER.classList.add('header-scroll');
    } else {
        HEADER.classList.remove('header-scroll');
    }
};


// BURGER MENU

const BURGER_BTN = document.querySelector('.burger-btn');
const BURGER_MENU = document.querySelector('.burger-menu');

BURGER_BTN.addEventListener('click', function () {
    BURGER_MENU.classList.toggle('burger-menu-open');
});


// CART

const CART_BTN = document.querySelector('.cart-btn');
const CART_BLOCK = document.querySelector('.cart-block');
const CART_CLOSE = document.querySelector('.close-cart');
const CART_BG = document.querySelector('.cart-bg');

// CART_BTN.addEventListener('click', function() {
//     CART_BLOCK.classList.toggle('cart-block-open');
//     CART_BG.classList.toggle('cart-bg-open');
//     document.body.classList.toggle('no-scroll');
// });

CART_CLOSE.addEventListener('click', function () {
    CART_BLOCK.classList.remove('cart-block-open');
    CART_BG.classList.remove('cart-bg-open');
    document.body.classList.remove('no-scroll');
});

CART_BG.addEventListener('click', function () {
    CART_BLOCK.classList.remove('cart-block-open');
    CART_BG.classList.remove('cart-bg-open');
    document.body.classList.remove('no-scroll');
});


const QUANTITY_CARD = document.querySelector('.quantity-card');
const DASH = document.querySelector('.minus');
const CROSS = document.querySelector('.plus');

if (QUANTITY_CARD !== null) {

    DASH.addEventListener('click', function minusProduct() {
        if (QUANTITY_CARD.value == 1) {
            QUANTITY_CARD.value = 1;
        } else {
            QUANTITY_CARD.value--;
        }
    });

    CROSS.addEventListener('click', function plusProduct() {
        QUANTITY_CARD.value++;
    });
}


document.addEventListener('DOMContentLoaded', function () {

    let product_gallery = document.querySelector('.product-gallery');
    let product_gallery__thumbs = document.querySelector('.product-gallery__thumbs');

    if (product_gallery !== null) {

        var main = new Splide('.product-gallery', {
            type: 'fade',
            rewind: true,
            pagination: false,
            arrows: true,
        });

        if(product_gallery__thumbs !== null){
            var thumbnails = new Splide('.product-gallery__thumbs', {
                fixedWidth: 90,
                fixedHeight: 100,
                gap: 10,
                arrows: false,
                rewind: true,
                pagination: false,
                isNavigation: true,
                breakpoints: {
                    600: {
                        fixedWidth: 60,
                        fixedHeight: 80,
                        gap: false,
                    },
                },
            });

            main.sync(thumbnails);
            thumbnails.mount()
        } main.mount();
    }
});


let openCallbackModalBtns = document.querySelectorAll('.tel-icon');
if (openCallbackModalBtns !== null) {
    openCallbackModalBtns.forEach((btn) => {

        btn.addEventListener('click', function () {
            showCallbackModal();
        })
    })
}


let closeModalBtns = document.querySelectorAll('.modal-callback .fa-xmark, .green-bg');
if (closeModalBtns !== null) {
    closeModalBtns.forEach((btn) => {
        btn.addEventListener('click', function () {
            hideCallbackModal();
        })
    })
}


let closeSuccessModalBtns = document.querySelectorAll('.thank-close-btn');
if (closeSuccessModalBtns !== null) {
    closeSuccessModalBtns.forEach((btn) => {
        btn.addEventListener('click', function () {
            hideSuccessModal();
        })
    })
}


let openFastPurchaseModalBtns = document.querySelectorAll('.purchase-onclick');

if (openFastPurchaseModalBtns !== null) {

    openFastPurchaseModalBtns.forEach((btn) => {
        btn.addEventListener('click', function () {
            // getProductDataAjax(this.getAttribute('data-product'), this.getAttribute('data-variation'),);
            if(btn.classList.contains('simple_product')){
                getProductDetails('simple')
                showFastPurchaseModal('simple');
            } else{
                getProductDetails('variation')
                showFastPurchaseModal()
            }


        })
    })
}

let closeFastPurchaseModalBtns = document.querySelectorAll('.fast-purchase-close, .fast-bg');
if (closeFastPurchaseModalBtns !== null) {
    closeFastPurchaseModalBtns.forEach((btn) => {
        btn.addEventListener('click', function () {
            hideFastPurchaseModal();
        })
    })
}

const ITEM_TOP = document.querySelectorAll('.item-top');
ITEM_TOP.forEach((element) => {
    element.addEventListener('click', () => {
        element.classList.toggle('item-top-active');
        let itemBottom = element.nextElementSibling;
        if (itemBottom.style.maxHeight) {
            itemBottom.style.maxHeight = null;
        } else {
            itemBottom.style.maxHeight = itemBottom.scrollHeight + "px";
        }
    });
});


function showSuccessModal() {
    let successModal = document.getElementById('thanks_modal');
    let successModalBg = document.getElementById('thanks_modal_bg');

    successModal.classList.add('thank-modal-open');
    successModalBg.classList.add('green-bg-open');
}

function hideSuccessModal() {
    let successModal = document.getElementById('thanks_modal');
    let successModalBg = document.getElementById('thanks_modal_bg');

    successModal.classList.remove('thank-modal-open');
    successModalBg.classList.remove('green-bg-open');
}


function showCallbackModal() {
    let callbackModal = document.getElementById('modal_callback');
    let callbackModalBg = document.getElementById('modal_callback_bg');

    callbackModal.classList.add('modal-callback-open');
    callbackModalBg.classList.add('green-bg-open');
}

function hideCallbackModal() {
    let callbackModal = document.getElementById('modal_callback');
    let callbackModalBg = document.getElementById('modal_callback_bg');

    callbackModal.classList.remove('modal-callback-open');
    callbackModalBg.classList.remove('green-bg-open');
}


function showFastPurchaseModal(action = 'variable') {

    let fastPurchaseModal = document.getElementById('fast_purchase');
    let fastPurchaseModalBg = document.getElementById('fast_purchase_bg');

    fastPurchaseModal.classList.add('fast-purchase-open');
    fastPurchaseModalBg.classList.add('fast-bg-open');
    document.querySelector('html').style.overflow = 'hidden';
}

function hideFastPurchaseModal() {
    let fastPurchaseModal = document.getElementById('fast_purchase');
    let fastPurchaseModalBg = document.getElementById('fast_purchase_bg');

    fastPurchaseModal.classList.remove('fast-purchase-open');
    fastPurchaseModalBg.classList.remove('fast-bg-open');

    document.querySelector('html').style.overflow = 'unset';
}

// FAST PURCHASE


// const FAST_PURCHASE = document.querySelector('.fast-purchase');
// const FAST_PURCHASE_CLOSE = document.querySelector('.fast-purchase-close');
// const FAST_PURCHASE_BTN = document.querySelector('.fast-purchase-btn');
// const FAST_BG = document.querySelector('.fast-bg');
// const PURCHASE_ONCLICK = document.querySelector('.purchase-onclick');
// const THANK_MODAL = document.querySelector('.thank-modal');
// const THANK_CLOSE_BTN = document.querySelector('.thank-close-btn');
//
// PURCHASE_ONCLICK.addEventListener('click', function() {
//     FAST_PURCHASE.classList.add('fast-purchase-open');
//     FAST_BG.classList.add('fast-bg-open');
// });
//
// FAST_PURCHASE_CLOSE.addEventListener('click', function() {
//     FAST_PURCHASE.classList.remove('fast-purchase-open');
//     FAST_BG.classList.remove('fast-bg-open');
// });
//
// FAST_BG.addEventListener('click', function() {
//     FAST_PURCHASE.classList.remove('fast-purchase-open');
//     FAST_BG.classList.remove('fast-bg-open');
//     THANK_MODAL.classList.remove('thank-modal-open');
// });
//
// FAST_PURCHASE_BTN.addEventListener('click', function() {
//     FAST_PURCHASE.classList.remove('fast-purchase-open');
//     THANK_MODAL.classList.add('thank-modal-open');
// });
//
// THANK_CLOSE_BTN.addEventListener('click', function() {
//     THANK_MODAL.classList.remove('thank-modal-open');
//     FAST_BG.classList.remove('fast-bg-open');
// });


function getProductDetails(action = 'simple') {
    let title = document.querySelector('.product-card-header h3').getAttribute('data-product-title')
    let price = document.querySelector('.prices .new-price').getAttribute('data-product-price')
    let img = document.querySelector('.splide__slide img').src
    let product_id = document.querySelector('input[name=product_id]').value

    document.getElementById('fp_img').src = img;
    document.getElementById('fp_title').textContent = title;
    document.getElementById('fp_price').textContent = price;
    document.getElementById('fp_product_id').value = product_id;

    if(action === 'variation'){

        let data = []
        let variation_id = document.querySelector('input[name=variation_id]').value
        let inputsContainer = document.querySelectorAll('.product-attr')

        inputsContainer.forEach((cont) => {
            let input = cont.querySelector('input[type=radio]:checked')

            if(input.name === 'attribute_pa_color'){
                let inputData = {
                    title: input.getAttribute('data-name'),
                    value: input.getAttribute('data-var-color'),
                    type: "color"
                }

                data.push(inputData)
            } else{
                let inputData = {
                    title: input.getAttribute('data-name'),
                    value: input.value,
                    type: "option"
                }

                data.push(inputData)
            }
        })
        let fpAttrsContainer = document.querySelector('.fast-product__attrs')
        fpAttrsContainer.innerHTML = ''

        data.forEach((item) => {
            let itemClass = null

            if(item.type === 'color'){
                itemClass = 'fast-product-color'
            } else {
                itemClass = 'fast-product-size'
            }

            let attrItem = document.createElement('div')
            attrItem.classList.add(itemClass)

            let arrItemTitle = document.createElement('div')
            arrItemTitle.classList.add('size-title')
            arrItemTitle.textContent = item.title

            attrItem.appendChild(arrItemTitle)

            let arrItemValue = document.createElement('span')

            let arrItemValueClass = null

            if(item.type === 'color'){
                arrItemValueClass = 'client-color'
                arrItemValue.style.backgroundColor = item.value

            } else {
                arrItemValueClass = 'client-size'
                arrItemValue.textContent = item.value.toUpperCase()
            }
            arrItemValue.classList.add(arrItemValueClass)
            attrItem.appendChild(arrItemValue)
            fpAttrsContainer.appendChild(attrItem)
        })
        document.getElementById('fp_variation_id').value = variation_id;
    }
}


let fastPurchaseForm = document.getElementById('fast_purchase_form');

if (fastPurchaseForm !== null) {
    fastPurchaseForm.addEventListener('submit', function (e) {
        e.preventDefault();
        sendFastPurchaseForm(this)
    })
}


let callbackForms = document.querySelectorAll('.callback-form');

if (callbackForms !== null) {
    callbackForms.forEach((form) => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            sendForm(form)
        })
    })
}


let contactsForms = document.querySelectorAll('.contacts_form');

if (contactsForms !== null) {
    contactsForms.forEach((form) => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            sendForm(form)
        })
    })
}

function sendFastPurchaseForm(form) {
    if (form !== null && form !== undefined) {

        let formBtn = form.querySelector('button[type=submit]');

        let data = new FormData(form);
        data.append('action', 'send_form');
        data.append('details', 'fast_purchase_form');

        var config = {
            method: 'post',
            url: '/wp-admin/admin-ajax.php',
            data: data
        };

        formBtn.textContent = 'Відправка...'
        formBtn.setAttribute('disabled', true)

        axios(config)
            .then(response => {
                let res = response.data;

                if (res.status === true) {
                    hideFastPurchaseModal()
                    showSuccessModal()
                    form.reset();
                    formBtn.textContent = 'Відправлено'
                    formBtn.style.backgroundColor = 'green'

                    fbq('track', 'Lead');
                    console.log('Lead');
                } else {
                    alert('Якась проблема... Звʼяжіться будь ласка з нами по мобільному телефону, вказаному в верхній частині сайту')
                }
            })
            .catch(error => {
                console.log(error);
            });
    }
}

function sendForm(form) {
    if (form !== null && form !== undefined) {

        let formBtn = form.querySelector('button[type=submit]');

        let data = new FormData(form);
        data.append('action', 'send_form');
        data.append('details', 'callback_form');

        var config = {
            method: 'post',
            url: '/wp-admin/admin-ajax.php',
            data: data
        };

        formBtn.textContent = 'Відправка...'
        formBtn.setAttribute('disabled', true)

        axios(config)
            .then(response => {
                let res = response.data;

                if (res.status === true) {
                    hideCallbackModal()
                    showSuccessModal()
                    form.reset();
                    formBtn.textContent = 'Відправлено'
                    formBtn.style.backgroundColor = 'green'
                } else {
                    alert('Якась проблема... Звʼяжіться будь ласка з нами по мобільному телефону, вказаному в верхній частині сайту')
                }
            })
            .catch(error => {
                console.log(error);
            });
    }
}
