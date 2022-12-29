<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$img = wp_get_attachment_image_src($product->get_image_id(), 'full');


// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( 'catalog-item', $product ); ?>>

	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
//	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 */
    ?>
    <a href="<?php echo get_permalink( $product->get_id() ); ?>" class="link-photo">
        <div class="overlay">
            <svg class="icon">
                <use xlink:href="<?php echo theme_path(); ?>img/sprite.svg#arrow-right"></use>
            </svg>
        </div>
        <?php if($img) : ?>
        <img src="<?php echo $img[0];  ?>" alt="<?php echo $product->get_name(); ?>">
        <?php else: ?>
            <img src="https://cdn.shopify.com/s/files/1/0533/2089/files/placeholder-images-image_large.png" alt="<?php echo $product->get_name(); ?>">
        <?php endif; ?>
    </a>
    <?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
    <?php do_action( 'woocommerce_shop_loop_item_title' ); ?>
    <?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
    <?php do_action( 'woocommerce_after_shop_loop_item' );; ?>
</li>
