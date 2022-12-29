<?php
/**
 * Additional Information tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/additional-information.php.
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

defined('ABSPATH') || exit;

global $product;

$heading = apply_filters('woocommerce_product_additional_information_heading', __('Additional information', 'woocommerce'));

$attributes = $product->get_attributes();
foreach ($attributes as $attribute):
    $tax = get_taxonomy( $attribute->get_name());
    $tax_name = $tax->labels->singular_name;
    $data = wp_get_post_terms( $product->get_id(), $attribute->get_name(), 'all' );
    $titles = [];

    foreach ($data as $item) {
        $titles[] = $item->name;
    }
    ?>
    <p>
        <?php echo $tax_name; ?>:
        <?php echo implode(', ', $titles); ?>
    </p>
<?php endforeach; ?>
