<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$product_cross_ids = $product->get_cross_sell_ids();



if ( !empty($product_cross_ids) ) : ?>

    <?php
    $args = [
        'posts_per_page' => 3,
        'post_type' => 'product',
        'include' => $product_cross_ids
    ];
    $products_cross = get_posts($args);

    $heading = apply_filters( 'woocommerce_product_upsells_products_heading', __( 'You may also like&hellip;', 'woocommerce' ) ); ?>

    <section class="similar-products">
        <div class="container">
            <?php if ( $heading ) : ?>
                <h2 class="similar-title">
                    <?php echo esc_html( $heading ); ?>
                </h2>
            <?php endif; ?>
            <ul class="similar-list">
            <?php foreach ($products_cross as $item): ?>
                <?php
                $product = wc_get_product($item->ID);
                $product_id = $product->get_id();
                $product_image = $product->get_image_id();
                $product_title = $product->get_name();

                if ($product->is_type('variable')) {
                    $product_variations = $product->get_available_variations();
                    $var_id = $product_variations[0]['variation_id'];
                    $var_product = wc_get_product($var_id);
                    $regular_price = $var_product->get_regular_price();
                    $sale_price = $var_product->get_sale_price();

                } else {
                    $regular_price = $product->get_regular_price();
                    $sale_price = $product->get_sale_price();
                }

                $img = wp_get_attachment_image_src($product_image, 'large');
                ?>
                <li class="similar-item">
                    <a href="<?php echo get_permalink($product_id); ?>" class="link-photo">
                        <div class="overlay">
                            <svg class="icon">
                                <use xlink:href="<?php echo theme_path(); ?>img/sprite.svg#arrow-right"></use>
                            </svg>
                        </div>
                        <?php if($img) : ?>
                            <img src="<?php echo $img[0];  ?>" alt="<?php echo $product->get_name(); ?>" alt="<?php echo $product_title; ?>">
                        <?php else: ?>
                            <img src="https://cdn.shopify.com/s/files/1/0533/2089/files/placeholder-images-image_large.png" alt="<?php echo $product->get_name(); ?>" style="border: 2px solid black">
                        <?php endif; ?>
                    </a>
                    <h3 class="item-title">
                        <a href="<?php echo get_permalink($product_id); ?>" class="link-title">
                            <?php echo $product_title; ?>
                        </a>
                    </h3>
                    <div class="prices">
                        <?php if (!empty($regular_price)): ?>
                            <span class="old-price">
                            <?php echo $regular_price . get_woocommerce_currency_symbol() ?>
                        </span>
                        <?php endif; ?>
                        <?php if (!empty($sale_price)): ?>
                            <div class="new-price">
                                <?php echo $sale_price . get_woocommerce_currency_symbol() ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </li>

    <?php endforeach; ?>
            </ul>
        </div>
    </section>



	<?php
endif;

wp_reset_postdata();
