<?php
/**
 * womazing functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package womazing
 */

require_once __DIR__ . '/vendor/autoload.php';

if (! defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}

require get_template_directory() . '/inc/carbon_fields.php';
require get_template_directory() . '/inc/styleScripts.php';
require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/inc/filters.php';
require get_template_directory() . '/inc/menus.php';
require get_template_directory() . '/inc/ajax.php';

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function womazing_setup()
{
    /*
        * Make theme available for translation.
        * Translations can be filed in the /languages/ directory.
        * If you're building a theme based on womazing, use a find and replace
        * to change 'womazing' to the name of your theme in all the template files.
        */
    load_theme_textdomain('womazing', get_template_directory() . '/languages');

    /*
        * Let WordPress manage the document title.
        * By adding theme support, we declare that this theme does not use a
        * hard-coded <title> tag in the document head, and expect WordPress to
        * provide it for us.
        */
    add_theme_support('title-tag');

    /*
        * Enable support for Post Thumbnails on posts and pages.
        *
        * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
        */
    add_theme_support('post-thumbnails');

    /*
        * Switch default core markup for search form, comment form, and comments
        * to output valid HTML5.
        */
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
            'wp-block-styles',
            'editor-styles'
        )
    );
    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );
}
add_action('after_setup_theme', 'womazing_setup');

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';


/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
  require get_template_directory() . '/inc/woocommerce.php';
}


add_filter( 'woocommerce_breadcrumb_defaults', 'wcc_change_breadcrumb_home_text' );
function wcc_change_breadcrumb_home_text( $defaults ) {

    $defaults['delimiter'] = '<div class="crumbs-item crumbs-decorate"></div>';
    $defaults['wrap_before'] = '<div class="crumbs">';
    $defaults['wrap_after'] = '</div>';
    $defaults['before'] = '<div class="crumbs-item">';
    $defaults['after'] = '</div>';

    return $defaults;
}


add_action('woocommerce_checkout_order_processed', 'afterCheckoutSend', 10, 1);
function afterCheckoutSend( $order_id ) {

    $order = new WC_Order( $order_id );

    if($order){
        $data = [
            'type' => 'Замовлення через корзину',
            'first_name' => $order->get_billing_first_name(),
            'last_name' => $order->get_billing_last_name(),
            'phone' => $order->get_billing_phone(),
            'email' => $order->get_billing_email(),
            'delivery_type' => $order->get_shipping_address_1(),
            'city' => $order->get_shipping_city(),
            'address' => $order->get_shipping_address_2(),
            'amount' => $order->get_total(),
            'message' => $order->get_customer_note(),
        ];

        $cartItems = [];

        foreach ( $order->get_items() as $item_id => $item ) {
            $itemOfCart = [
                'product_id' => $item->get_product_id(),
                'variation_id' => $item->get_variation_id(),
                'title' => $item->get_name(),
                'qnt' => $item->get_quantity(),
            ];

            array_push($cartItems, $itemOfCart);
        }
        $data['products'] = json_encode($cartItems);

        sendToTelegram($data);
    }

}



function sendToTelegram($data)
{

    if(carbon_get_theme_option('telegram_token') != ''){
        $tg_token = carbon_get_theme_option('telegram_token');
    } else{
        $tg_token = '1036526242:AAFLC_x7aSWWDijoGqjJ1uLs69oPQzjCkvE';
    }

    if(carbon_get_theme_option('telegram_chat_id') != ''){
        $tg_chatid = carbon_get_theme_option('telegram_chat_id');
    } else{
        $tg_chatid = '-1001658311451';
    }

    $send_data = [];

    $send_data['Нова форма Ін-магазин: '] = '';
    $send_data['Сайт: '] = $_SERVER['SERVER_NAME'];

    foreach ($data as $key => $value) {
        if ($key == 'action') {
            continue;
        }
        if($key == 'type'){
            $send_data['Тип заявки' . ': '] = $value;
        } elseif ($key == 'name') {
            $send_data['Імʼя' . ': '] = $value;
        } elseif ($key == 'first_name') {
            $send_data['Імʼя' . ': '] = $value;
        } elseif ($key == 'last_name') {
            $send_data['Призвіще' . ': '] = $value;
        } elseif ($key == 'delivery_type') {
            $send_data['Тип доставки' . ': '] = $value;
        } elseif ($key == 'city') {
            $send_data['Місто' . ': '] = $value;
        } elseif ($key == 'address') {
            $send_data['Адреса' . ': '] = $value;
        } elseif ($key == 'phone') {
            $send_data['Телефон' . ': '] = preg_replace('/[^0-9]/', '', $value);
        } elseif ($key == 'email') {
            $send_data['Email' . ': '] = $value;
        } elseif ($key == 'details') {
            $send_data['Форма' . ': '] = $value;
        } elseif ($key == 'amount') {
            $send_data['Сума з доставкою' . ': '] = $value;
        } elseif ($key == 'fp_product_id') {
            $send_data['ID товару на сайті' . ': '] = $value;
        } elseif ($key == 'fp_variation_id') {
            $send_data['ID варіації товару' . ': '] = $value;
        } elseif ($key == 'product') {
            $send_data['Товар' . ': '] = $value;
        } elseif ($key == 'message') {
            $send_data['Повідомлення' . ': '] = $value;
        } elseif($key == 'products'){
            $products = json_decode($value, true);

            $counter = 1;
            foreach ($products as $product){
                $str = 'Назва: ' . $product['title'] . '| ' . 'ID Товару: ' . $product['product_id'] . '( ' . $product['variation_id'] . ' ) ' . '| Кількість: ' . $product['qnt'] . ';';

                $send_data['Товар ' . $counter . ': '] = $str;
                $counter++;
            }
        } else{
            $send_data[$key . ': '] = $value;
        }
    }

    $send_data['Дата відправки: '] = date("Y-m-d H:i:s");
    $send_data['IP адреса клієнта: '] = $_SERVER['REMOTE_ADDR'];

    $send_to_tg_res = '';

    if (!empty($tg_token) && !empty($tg_chatid) && !empty($send_data)) {
        $txt = '';

        foreach ($send_data as $key => $value) {
            $txt .= "<b>" . $key . "</b> " . $value . "%0A";
        };

        $link = "https://api.telegram.org/bot{$tg_token}/sendMessage?chat_id={$tg_chatid}&parse_mode=html&text={$txt}";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $out = curl_exec($curl);
        curl_close($curl);

        $send_to_tg_res = json_decode($out, true)['ok'];
    }

    $res = [
        'status' => $send_to_tg_res,
        'send_data' => $send_data,
    ];

    return $res;
}


function custom_content_after_body_open_tag() {

    $body_scripts = carbon_get_theme_option('body_open_scripts');

    if(!empty($body_scripts)){
        echo $body_scripts;
    }

}

add_action('wp_body_open', 'custom_content_after_body_open_tag');


add_action('init', function (){
    session_start();
    $period_cookie = 2592000;

    if(isset($_GET['utm_source'])){
        setcookie("utm_source",$_GET['utm_source'],time()+$period_cookie);
    }
    if(isset($_GET['utm_medium'])){
        setcookie("utm_medium",$_GET['utm_medium'],time()+$period_cookie);
    }
    if(isset($_GET['utm_term'])){
        setcookie("utm_term",$_GET['utm_term'],time()+$period_cookie);
    }
    if(isset($_GET['utm_content'])){
        setcookie("utm_content",$_GET['utm_content'],time()+$period_cookie);
    }
    if(isset($_GET['utm_campaign'])){
        setcookie("utm_campaign",$_GET['utm_campaign'],time()+$period_cookie);
    }
});

function custom_loginlogo() {

    $logo = get_theme_mod('custom_logo');
    $image = wp_get_attachment_image_src($logo, 'full');
    if (!empty($image)) {
        $image_url = $image[0];
    } else {
        $image_url = get_stylesheet_directory_uri() . '/img/logo.png';
    }

    echo '<style>
        .login h1 a{
            background-image: url(' . $image_url . ');
            background-position: center;
            background-size: contain;
            width: 170px;
        }  </style>';

}
add_action('login_head', 'custom_loginlogo');



function woo_product_query($query, $that){

        $query->query_vars['order'] = 'asc';
//        $query->query_vars['meta_key'] = 'priority_catalog';
//        $query->query_vars['orderby'] = 'priority_catalog';
        $query->query_vars['orderby'] = 'meta_value_num';

        $query->query_vars['meta_query'] = array(
            'relative' => 'OR',
            'priority_catalog' => array(
                'key' => 'priority_catalog',
                'compare' => 'EXIST',
            ),
            array(
                'key' => 'catalog_show',
                'value' => 'true',
            ),
        );
    return $query;
}

add_action( 'woocommerce_product_query', 'woo_product_query', 10, 2 );