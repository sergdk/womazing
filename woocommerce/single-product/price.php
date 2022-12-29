<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product;


?>
<!--<p class="--><?php //echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?><!--">--><?php //echo $product->get_price_html(); ?><!--</p>-->

<?php if ($product->is_type('variable')): ?>
    <?php
    $regularPriceMin = $product->get_variation_regular_price(); // Min regular price
    $salePriceMin = $product->get_variation_sale_price(); // Min sale price
    $priceMin = $product->get_variation_price(); // Min price

    $regularPriceMax = $product->get_variation_regular_price('max'); // Max regular price
    $salePriceMax = $product->get_variation_sale_price('max'); // Max sale price
    $priceMax = $product->get_variation_price('max'); // Max price

    if((int)$regularPriceMin === 0 ): ?>

    <?php elseif((int) $regularPriceMin === (int) $salePriceMin): ?>
        <div class="prices">
            <div class="new-price" data-product-price="<?php echo (int)$salePriceMin . ' ' . get_woocommerce_currency_symbol() ?> ">
                <?php echo (int)$salePriceMin . ' ' . get_woocommerce_currency_symbol() ?>
            </div>
        </div>
    <?php else: ?>
        <div class="prices">
            <div class="new-price" data-product-price="<?php echo (int)$salePriceMin . ' ' . get_woocommerce_currency_symbol() ?> ">
                <?php echo (int)$salePriceMin . ' ' . get_woocommerce_currency_symbol() ?>
            </div>
            <span class="old-price">
                <?php echo (int)$regularPriceMin . ' ' . get_woocommerce_currency_symbol() ?>
            </span>
        </div>
    <?php endif; ?>

<?php else: ?>
    <?php
    $regular_price = $product->get_regular_price();
    $sale_price = $product->get_sale_price();
    ?>
    <div class="prices">
        <div class="new-price" data-product-price="<?php echo (int)$sale_price . ' ' . get_woocommerce_currency_symbol() ?>">
            <?php echo $sale_price . ' ' . get_woocommerce_currency_symbol(); ?>
        </div>
        <span class="old-price">
            <?php echo $regular_price . ' ' . get_woocommerce_currency_symbol(); ?>
        </span>
    </div>
<?php endif; ?>
