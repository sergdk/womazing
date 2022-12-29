<div id="cart-container" class="cart-container">
    <div class="cart-btn" @click="openCart">
        <svg class="icon">
            <use xlink:href="<?php echo theme_path(); ?>img/sprite.svg#bag"></use>
        </svg>
        <div class="cart-count" v-if="isEmpty != false">
            {{cartCount}}
        </div>
    </div>
    <!-- popup cart -->
    <div class="cart-block">
        <h3 class="cart-block-title">Кошик</h3>
        <div class="close-cart js-close-cart" @click="closeCart">
            <i class="fa-solid fa-xmark"></i>
        </div>
        <div class="cart-with-loader" v-if="loader === true">
            <div class="cart-loader-container">
                <span class="cart-loader"></span>
            </div>
        </div>
        <div class="cart-content" v-else>
            <div class="cart-content__main" v-if="isEmpty != false">
                <ul class="cart-products" >
                    <li class="cart-item" v-for="(item, index) in cart" :key="item.id">
                        <div class="cart-item-image">
                            <img v-if="item.image" :src="item.image" title="{{item.title}}">
                            <img v-else
                                 src="https://cdn.shopify.com/s/files/1/0533/2089/files/placeholder-images-image_large.png"
                                 :title="item.title">
                        </div>
                        <div class="cart-item-info">
                            <h4 class="cart-title">
                                {{item.title}}
                                <span style="text-transform: capitalize;">
                                            {{item.size}}
                                        </span>
                                <span style="text-transform: capitalize;" v-if="item.color">
                                           ({{item.color.title}} )
                                        </span>
                            </h4>
                            <div class="cart-quantity">
                                <div class="quantity-minus" @click="qntItemMinus(index)">
                                    <i class="fa-solid fa-minus"></i>
                                </div>
                                <input type="number" min="1" step="1" :value="item.qnt" class="quantity-number">
                                <div class="quantity-plus" @click="qntItemPlus(index)">
                                    <i class="fa-solid fa-plus"></i>
                                </div>
                            </div>
                            <span class="cart-price">
                                    {{item.subtotal}} <?php echo get_woocommerce_currency_symbol(); ?>
                                </span>
                            <div class="cart-remove" @click="removeFromCart(index)">
                                Видалити
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="cart-footer">
                    <div class="cart-footer-content">
                        <h4>Разом :</h4>
                        <span v-if="couponIsEmpty === false" style="margin-left: 10px;">(з купоном)</span>
                        <span class="sum">
                                {{total}} <?php echo get_woocommerce_currency_symbol(); ?>
                        </span>
                    </div>
                    <div class="cart-footer-btns">
                        <div class="btn-show-bag">
                            <a href="<?php echo wc_get_cart_url();  ?>">
                                Переглянути кошик
                            </a>
                        </div>
                        <div class="btn-purchase">
                            <a href="<?php echo wc_get_checkout_url();  ?>">
                                Перейти до оплати
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cart-content__main cartEmpty" v-else>
                Корзина пуста
            </div>
        </div>
    </div>
    <div class="cart-bg" @click="closeCart"></div>
</div>