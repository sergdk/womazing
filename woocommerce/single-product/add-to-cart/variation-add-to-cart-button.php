<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>
<div class="woocommerce-variation-add-to-cart variations_button">

    <div class="product-card-btns">
        <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

        <?php do_action( 'woocommerce_before_add_to_cart_quantity' ); ?>

        <div class="product-card-quantity">
            <span class="plus">+</span>
            <input type="number" class="quantity-card" step="1" min="1" max="" name="quantity" value="<?php echo isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(); ?>" autocomplete="off">
            <span class="minus">-</span>
        </div>

        <?php do_action( 'woocommerce_after_add_to_cart_quantity' ); ?>

        <div class="product-card-btns">
            <div class="purchase-btns">
                <button type="submit" id="btn_<?php echo $product->get_id(); ?>" class="add-btn single_add_to_cart_button button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>">
                    <?php echo esc_html( $product->single_add_to_cart_text() ); ?>
                </button>
                <button type="button" class="purchase-onclick" data-details="" disabled>
                    <?php _e('Купити в один клік', 'woomazing'); ?>
                </button>
            </div>
        </div>

        <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
    </div>

	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>
