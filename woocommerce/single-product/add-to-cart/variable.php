<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 6.1.0
 */

defined('ABSPATH') || exit;

global $product;



$attribute_keys = array_keys($attributes);
$variations_json = wp_json_encode($available_variations);
$variations_attr = function_exists('wc_esc_json') ? wc_esc_json($variations_json) : _wp_specialchars($variations_json, ENT_QUOTES, 'UTF-8', true);
$keys = json_encode(array_keys($attributes));

$var_data = get_variations_json($product->get_id());

do_action('woocommerce_before_add_to_cart_form'); ?>

    <form class="variations_form cart" data-keys='<?php echo $keys; ?>'
          action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" data-vars='<?php echo $var_data; ?>'
          method="post" enctype='multipart/form-data' data-product_id="<?php echo absint($product->get_id()); ?>"
          data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">

        <?php do_action('woocommerce_before_variations_form'); ?>

        <?php
        $attribute_taxonomies = wc_get_attribute_taxonomies();
        ?>

        <?php if (empty($available_variations) && false !== $available_variations) : ?>
            <p class="stock out-of-stock"><?php echo esc_html(apply_filters('woocommerce_out_of_stock_message', __('This product is currently out of stock and unavailable.', 'woocommerce'))); ?></p>
        <?php else : ?>
            <?php if (!empty($attributes)): ?>
                <?php foreach ($attributes as $key => $term): ?>
                    <?php
                    $title = '';
                    foreach ($attribute_taxonomies as $tax) {
                        if ('pa_' . $tax->attribute_name == $key) {
                            $title = $tax->attribute_label;
                        }
                    }
                    ?>
                    <?php if ($key == 'pa_color'): ?>
                        <div id="<?php echo $key; ?>" class="product-card-colors product-attr">
                            <h3>
                                <?php _e('Колір', 'woomazing'); ?>
                            </h3>
                            <ul class="colors-list">
                                <?php foreach ($term as $color): ?>
                                    <?php
                                    $color_term = get_term_by('slug', $color, 'pa_color');
                                    $color_data = carbon_get_term_meta($color_term->term_id, 'color');
                                    ?>
                                    <li class="colors-item">
                                        <input type="radio" id="<?php echo $key . $color ?>"
                                               name="attribute_<?php echo $key; ?>" value="<?php echo $color; ?>"
                                               data-attribute_name="attribute_<?php echo $key; ?>"
                                               data-var-color="<?php echo $color_data; ?>"
                                               data-name="<?php _e('Колір', 'woomazing'); ?>" class="radio-label">
                                        <label for="<?php echo $key . $color ?>" class="colors <?php echo $color; ?>"
                                               style="background-color: <?php echo $color_data; ?>;"></label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php else: ?>
                        <div id="<?php echo $key; ?>" class="product-card-sizes product-attr">
                            <h3>
                                <?php echo $title; ?>
                            </h3>
                            <ul class="sizes-list">
                                <?php foreach ($term as $size): ?>
                                    <li class="sizes-item">
                                        <input type="radio" name="attribute_<?php echo $key; ?>"
                                               data-attribute_name="attribute_<?php echo $key; ?>"
                                               data-name="<?php echo $title ?>"
                                               value="<?php echo $size; ?>" id="<?php echo $key . $size ?>"
                                               class="radio-label">
                                        <label for="<?php echo $key . $size ?>" class="sizes <?php echo $size; ?>">
                                            <?php echo strtoupper($size); ?>
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php do_action('woocommerce_after_variations_table'); ?>

            <div class="single_variation_wrap">
                <?php
                /**
                 * Hook: woocommerce_before_single_variation.
                 */
                do_action('woocommerce_before_single_variation');

                /**
                 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
                 *
                 * @since 2.4.0
                 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
                 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
                 */
                do_action('woocommerce_single_variation');

                /**
                 * Hook: woocommerce_after_single_variation.
                 */
                do_action('woocommerce_after_single_variation');
                ?>
            </div>
        <?php endif; ?>

        <?php do_action('woocommerce_after_variations_form'); ?>
    </form>

<?php
do_action('woocommerce_after_add_to_cart_form');
