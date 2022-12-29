<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>


<section class="shopping-cart">
    <div class="container">
        <form id="pageCart" action="<?php echo esc_url(wc_get_cart_url()); ?>"
              method="post">
            <div class="shopping-cart-header">
                <h3>
                    <?php the_title(); ?>
                </h3>
                <?php echo get_breadcrumb(); ?>
            </div>
            <div class="shopping-cart-top">
                <div class="shopping-top title">
                    <?php esc_html_e('Product', 'woocommerce'); ?>
                </div>
                <div class="shopping-top price">
                    <?php esc_html_e('Price', 'woocommerce'); ?>
                </div>
                <div class="shopping-top quantity">
                    <?php esc_html_e('Quantity', 'woocommerce'); ?>
                </div>
                <div class="shopping-top sum">
                    <?php esc_html_e('Subtotal', 'woocommerce'); ?>
                </div>
            </div>
            <div class="shopping-cart-content shop_table shop_table_responsive cart woocommerce-cart-form__contents">
                <div class="cart-with-loader" v-if="loader === true">
                    <div class="cart-loader-container">
                        <span class="cart-loader"></span>
                    </div>
                </div>
                <div v-else>
                    <div v-if="isEmpty != false">
                        <div class="shopping-cart-middle" v-for="(item, index) in cart" :key="item.id">
                            <div class="shopping-middle-main">
                                <div class="cart-remove">
                                    <i class="fa-solid fa-xmark" @click="removeFromCart(index)"></i>
                                </div>
                                <div class="cart-image">
                                    <img v-if="item.image" :src="item.image" title="{{item.title}}">
                                    <img v-else
                                         src="https://cdn.shopify.com/s/files/1/0533/2089/files/placeholder-images-image_large.png"
                                         :title="item.title">
                                </div>
                                <div class="cart-name">
                                    <span class="mobile-title"><?php esc_html_e('Product', 'woocommerce'); ?>:</span>
                                    <div class="cart-item__text__column">
                                        <span>{{item.title}}</span>
                                        <span style="text-transform: capitalize;">
                                {{item.size}}
                            </span>
                                        <span style="text-transform: capitalize;" v-if="item.color">
                                {{item.color.title}}
                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="shopping-middle-price">
                                <span class="mobile-title"><?php esc_html_e('Price', 'woocommerce'); ?>:</span>
                                {{item.price}} <?php echo get_woocommerce_currency_symbol(); ?>
                            </div>
                            <div class="shopping-middle-quantity">
                                <span class="mobile-title"><?php esc_html_e('Quantity', 'woocommerce'); ?>:</span>
                                <div class="product-card-quantity">
                                    <span class="plus" @click="qntItemPlus(index)">+</span>
                                    <input type="number" class="quantity-card" step="1" min="1" max=""
                                           :value="item.qnt">
                                    <span class="minus" @click="qntItemMinus(index)">-</span>
                                </div>
                            </div>
                            <div class="shopping-middle-sum">
                                <span class="mobile-title"><?php esc_html_e('Subtotal', 'woocommerce'); ?>:</span>
                                <div class="cart-item__text__row">
                                    {{item.subtotal}} <?php echo get_woocommerce_currency_symbol(); ?>
                                    <span v-if="couponIsEmpty === false" style="margin-left: 10px;">(з купоном)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-else class="pageCart__empty">
                        Корзина пуста
                    </div>
                </div>


            </div>
            <?php do_action('woocommerce_cart_contents'); ?>
<!--            <div class="shopping-cart-btns" >-->
<!--                <div class="shopping-cart-coupon" v-if="couponIsEmpty === true">-->
<!--                    <div class="coupon-wrapper">-->
<!--                        <input type="text" placeholder="Введіть купон" name="coupon_code" v-model="coupon">-->
<!--                        <button type="button" @click="setCoupon">Примінити купон</button>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

            <div class="cart-checkout">
                <div class="cart-checkout__wrapper">
<!--                    <div class="cart-checkout__subtotal">-->
<!--                        <h5>Підсумок</h5>-->
<!--                        <span class="cart-price">-->
<!--                            {{total_w_coupon}} --><?php //echo get_woocommerce_currency_symbol(); ?>
<!--                        </span>-->
<!--                    </div>-->
                    <div class="cart-checkout__total">
                        <h5>Всього:</h5>
                        <span v-if="couponIsEmpty === false" style="margin-right: 10px;">(з купоном)</span>
                        <span class="cart-price">
                            {{total}} <?php echo get_woocommerce_currency_symbol(); ?>
                        </span>

                    </div>
                </div>
                <div class="cart-checkout_btn">
                    <a href="<?php echo wc_get_checkout_url();  ?>">
                        Оформити замовлення
                    </a>
                </div>
            </div>
            <?php do_action('woocommerce_after_cart_table'); ?>
        </form>
    </div>
</section>


<?php do_action('woocommerce_after_cart'); ?>
