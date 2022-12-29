<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package womazing
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function womazing_woocommerce_setup()
{
    add_theme_support(
        'woocommerce',
        array(
            'thumbnail_image_width' => 150,
            'single_image_width' => 300,
            'product_grid' => array(
                'default_rows' => 3,
                'min_rows' => 1,
                'default_columns' => 4,
                'min_columns' => 1,
                'max_columns' => 6,
            ),
        )
    );
//	add_theme_support( 'wc-product-gallery-zoom' );
//	add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support('wc-product-gallery-slider');
}

add_action('after_setup_theme', 'womazing_woocommerce_setup');


/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function womazing_woocommerce_active_body_class($classes)
{
    $classes[] = 'woocommerce-active';

    return $classes;
}

add_filter('body_class', 'womazing_woocommerce_active_body_class');

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function womazing_woocommerce_related_products_args($args)
{
    $defaults = array(
        'posts_per_page' => 3,
        'columns' => 3,
    );

    $args = wp_parse_args($defaults, $args);

    return $args;
}

add_filter('woocommerce_output_related_products_args', 'womazing_woocommerce_related_products_args');


function action_woocommerce_shop_loop_item_title()
{
    remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

    $str = '<h3 class="item-title ' . esc_attr(apply_filters('woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title')) . '">' . get_the_title() . '</a></h3>';
    echo $str;
}

add_action('woocommerce_shop_loop_item_title', 'action_woocommerce_shop_loop_item_title', 9);


function action_woocommerce_template_loop_price()
{

    global $product;

    if ($product->is_type('variable')) {
        $product_variations = $product->get_available_variations();

        if(!empty($product_variations)){
            $var_id = $product_variations[0]['variation_id'];
            $var_product = wc_get_product($var_id);
            $regular_price = $var_product->get_regular_price();
            $sale_price = $var_product->get_sale_price();
        } else{
            $regular_price = '';
            $sale_price = '';
        }

    } else {
        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();
    }

    $str_start = '<div class="prices">';
    if (!empty($sale_price)) {
        $str_prices = '<span class="old-price">' . $regular_price . get_woocommerce_currency_symbol() . '</span><div class="new-price">' . $sale_price . get_woocommerce_currency_symbol() . '</div>';
    } elseif($regular_price == ''){
        $str_prices = '<div class="new-price">' . __('Немає наявності', 'woomazing') . '</div>';
    } else {
        $str_prices = '<div class="new-price">' . $regular_price . get_woocommerce_currency_symbol() . '</div>';
    }
    $str_end = '</div>';
    $str = $str_start . $str_prices . $str_end;

    echo $str;
}

add_action('woocommerce_after_shop_loop_item_title', 'action_woocommerce_template_loop_price', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);


function action_woocommerce_template_loop_thumb()
{
    remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
}

add_action('woocommerce_before_shop_loop_item_title', 'action_woocommerce_template_loop_thumb', 9);


//add_action('woocommerce_before_main_content', 'woocommerce_template_single_title');

remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
add_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 15);
add_action('woocommerce_after_shop_loop', 'woocommerce_result_count', 5);

remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);


add_filter('woocommerce_checkout_fields', 'custom_wc_checkout_fields_no_label');

function custom_wc_checkout_fields_no_label($fields)
{
//    d($fields);
    foreach ($fields as $category => $value) {
        foreach ($value as $field => $property) {

            if ($field === 'billing_phone') {
                $fields[$category][$field]['placeholder'] = __('Телефон', 'woomazing');
                $fields[$category][$field]['priority'] = 15;
            } elseif ($field === 'billing_email') {
                $fields[$category][$field]['placeholder'] = __('E-mail', 'woomazing');
                $fields[$category][$field]['priority'] = 20;
            }

            unset($fields[$category][$field]['label']);
        }
    }

//    d($fields);
    return $fields;
}

add_filter('woocommerce_default_address_fields', 'custom_override_default_checkout_fields', 10, 1);
function custom_override_default_checkout_fields($address_fields)
{

//    d($address_fields );
    foreach ($address_fields as $key => $field) {
        unset($address_fields[$key]['label']);

        if ($key === 'first_name') {
            $address_fields[$key]['placeholder'] = __('Ваше ім\'я', 'woomazing');
            $address_fields[$key]['priority'] = 10;
        } elseif ($key === 'last_name') {
            $address_fields[$key]['placeholder'] = __('Ваше призвіще', 'woomazing');
            $address_fields[$key]['priority'] = 15;
        } elseif ($key === 'company') {
            unset($address_fields[$key]);
        } elseif ($key === 'country') {
            $address_fields[$key]['placeholder'] = __('Країна', 'woomazing');
            $address_fields[$key]['priority'] = 25;
        } elseif ($key === 'city') {
            $address_fields[$key]['placeholder'] = __('Місто', 'woomazing');
            $address_fields[$key]['priority'] = 30;
        } elseif ($key === 'address_1') {
            unset($address_fields[$key]);
//            $address_fields[$key]['placeholder'] = __('Вулиця', 'woomazing');
//            $address_fields[$key]['priority'] = 35;
        } elseif ($key === 'address_2') {
            unset($address_fields[$key]);
//            $address_fields[$key]['placeholder'] = __('Будинок', 'woomazing');
//            $address_fields[$key]['priority'] = 40;
        } elseif ($key === 'state') {
            unset($address_fields[$key]);
        } elseif ($key === 'postcode') {
            unset($address_fields[$key]);
        }
    }

    $address_fields['delivery_type'] = [
        'placeholder' => __('Тип доставки', 'woomazing'),
        'priority' => 27,
        'required' => false,
        'class' => '',
    ];

    $address_fields['warehouse'] = [
        'placeholder' => __('Відділення', 'woomazing'),
        'priority' => 35,
        'required' => false,
        'class' => 'hideInput',
    ];

    $address_fields['courier'] = [
        'placeholder' => __('Адрес', 'woomazing'),
        'priority' => 40,
        'required' => false,
        'class' => 'hideInput',
    ];

//    d($address_fields);
    return $address_fields;
}

add_filter('woocommerce_form_field_country', 'filter_form_field_country', 10, 4);
function filter_form_field_country($field, $key, $args, $value)
{
    $str = '<p class="form-row form-row-wide address-field update_totals_on_change validate-required" id="billing_country_field" data-priority="25" style="font-weight: 700; border-bottom: unset; height: min-content; display: none">Україна  <input type="hidden" name="' . $key . '" value="UA"></p>';
    return $str;
}


add_action( 'woocommerce_checkout_update_order_meta', 'checkout_custom_field_action' );
function checkout_custom_field_action( $order_id ){

    $order = wc_get_order($order_id);



    if(!empty($order)){

        $del_type = '';
        $order->set_shipping_city($_POST[ 'billing_city' ]);
        if($_POST[ 'billing_delivery_type'] == 'courier'){
            $del_type = "Курʼєр";
            $order->set_shipping_address_2($_POST[ 'billing_courier']);
        } elseif ($_POST['billing_delivery_type'] === 'warehouse'){
            $del_type = "Відділення";
            $order->set_shipping_address_2($_POST[ 'billing_warehouse' ]);
        } else{
            $del_type = "Не відомо";
        }
        $order->set_shipping_address_1($del_type);

        $order->save();
//        file_put_contents(get_stylesheet_directory_uri() . '/log.log', print_r([$_POST, $order_id, $order, true]));


    }

    if( ! empty( $_POST[ 'billing_delivery_type' ] ) ) {
        update_post_meta( $order_id, 'Тип доставки', wc_clean( $_POST[ 'billing_delivery_type' ] ) );
    }
    if( ! empty( $_POST[ 'billing_warehouse' ] ) ) {
        update_post_meta( $order_id, 'Відділення', wc_clean( $_POST[ 'billing_warehouse' ] ) );
    }
    if( ! empty( $_POST[ 'billing_courier' ] ) ) {
        update_post_meta( $order_id, 'Адрес доставки курʼєром', wc_clean( $_POST[ 'billing_courier' ] ) );
    }


}

add_filter('default_checkout_billing_country', 'change_default_checkout_country');
function change_default_checkout_country()
{
    return 'UA'; // country code
}


remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);


remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);


remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

add_action('woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 35);

function hide_coupon_field_on_cart( $enabled ) {
    if ( is_checkout() ) {
        $enabled = false;
    }
    return $enabled;
}
add_filter( 'woocommerce_coupons_enabled', 'hide_coupon_field_on_cart' );

//remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
//    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20  );


//
//function register_accepted_processing_order_status() {
//    register_post_status( 'wc-accepted-processing', array(
//        'label'                     => __('wc-accepted-processing', 'womazing'),
//        'public'                    => true,
//        'show_in_admin_status_list' => true,
//        'show_in_admin_all_list'    => true,
//        'exclude_from_search'       => false,
//        'label_count'               => _n_noop( 'Accepted for processing (%s)', 'Accepted for processing (%s)' )
//    ) );
//}
//
//function add_accepted_processing_to_order_statuses( $order_statuses ) {
//    $new_order_statuses = array();
//    $new_order_statuses['wc-accepted-processing'] = __('Accepted for processing', 'womazing');
//
//    foreach ( $order_statuses as $key => $status ) {
//        $new_order_statuses[ $key ] = $status;
//    }
//
//    return $new_order_statuses;
//}
//add_action( 'init', 'register_accepted_processing_order_status' );
//add_filter( 'wc_order_statuses', 'add_accepted_processing_to_order_statuses' );