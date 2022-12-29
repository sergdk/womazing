<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

global $product;

if (!$product->is_purchasable()) {
    return;
}

echo wc_get_stock_html($product); // WPCS: XSS ok.

if ($product->is_in_stock()) : ?>

    <div class="">
        <?php do_action('woocommerce_before_add_to_cart_form'); ?>
        <form class="simple_form cart"
              action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>"
              method="post" enctype='multipart/form-data'>
            <div class="product-card-btns">


                <?php do_action('woocommerce_before_add_to_cart_quantity'); ?>

                <div class="product-card-quantity">
                    <span class="plus">+</span>
                    <input type="number" class="quantity-card" step="1" min="1" max="" name="quantity"
                           value="<?php echo isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(); ?>"
                           autocomplete="off">
                    <span class="minus">-</span>
                </div>

                <?php do_action('woocommerce_after_add_to_cart_quantity'); ?>

                <div class="product-card-btns">
                    <div class="purchase-btns">
                        <button type="submit" id="btn_<?php echo $product->get_id(); ?>"
                                class="add-btn single_add_to_cart_button button alt<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" data-type="simple">
                            <?php echo esc_html($product->single_add_to_cart_text()); ?>
                        </button>
                        <button type="button" class="purchase-onclick simple_product" data-details="">
                            <?php _e('Купити в один клік', 'woomazing'); ?>
                        </button>
                    </div>

                    <?php do_action('woocommerce_after_add_to_cart_button'); ?>
                </div>

                <input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()); ?>"/>
                <input type="hidden" name="product_id" value="<?php echo absint($product->get_id()); ?>"/>
            </div>
        </form>

        <?php do_action('woocommerce_after_add_to_cart_form'); ?>
    </div>


<!--    --><?php //do_action('woocommerce_before_add_to_cart_form'); ?>
<!---->
<!---->
<!--    --><?php //do_action('woocommerce_before_add_to_cart_button'); ?>

<!--    --><?php
//    do_action('woocommerce_before_add_to_cart_quantity');
//
//    woocommerce_quantity_input(
//        array(
//            'min_value' => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
//            'max_value' => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
//            'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
//        )
//    );
//
//    do_action('woocommerce_after_add_to_cart_quantity');
//    ?>
<!---->
<!--    <button type="submit" name="add-to-cart" value="--><?php //echo esc_attr($product->get_id()); ?><!--"-->
<!--            class="single_add_to_cart_button button alt--><?php //echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?><!--">--><?php //echo esc_html($product->single_add_to_cart_text()); ?><!--</button>-->
<!---->
<!--    --><?php //do_action('woocommerce_after_add_to_cart_button'); ?>
<!--    </form>-->
<!---->
<!--    --><?php //do_action('woocommerce_after_add_to_cart_form'); ?>

<?php endif; ?>
