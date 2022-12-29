<?php

/**
 * Enqueue scripts and styles.
 */
function womazing_scripts()
{
    wp_deregister_style('wc-blocks-vendors-style');
    wp_deregister_style('wc-blocks-style');
    wp_deregister_style('classic-theme-styles');

    wp_enqueue_style('reset', get_stylesheet_directory_uri() . '/libs/reset.css', array(), _S_VERSION);
    wp_enqueue_style('fonts',  'https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700&display=swap', array(), _S_VERSION);
    wp_enqueue_style('font-awesome',  'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css', array(), _S_VERSION);
    wp_enqueue_style('tiny-css', get_stylesheet_directory_uri() .  '/libs/tiny-slider.min.css', array(), _S_VERSION);
    wp_enqueue_style('womazing-style', get_stylesheet_directory_uri() .  '/css/style.min.css', array(), _S_VERSION);
    wp_enqueue_style('womazing-add-style', get_stylesheet_directory_uri() .  '/css/add.min.css', array(), _S_VERSION);
    wp_style_add_data('womazing-style', 'rtl', 'replace');

    if(is_page() || is_single('post')){
        wp_enqueue_style('content_styles', get_stylesheet_directory_uri() .  '/css/page_content.min.css', array(), _S_VERSION);
    }

    wp_enqueue_script('womazing-phone-masks', get_stylesheet_directory_uri(). '/libs/jquery.maskedinput.min.js', [],_S_VERSION, true);

    wp_enqueue_script('vue-js', get_stylesheet_directory_uri(). '/libs/vue.global.prod.min.js', [],_S_VERSION, true);

    wp_enqueue_script('axios-js', get_stylesheet_directory_uri(). '/libs/axios.min.js', [],_S_VERSION, true);

    if(is_front_page()){
        wp_enqueue_script('tiny-js', get_stylesheet_directory_uri(). '/libs/tiny-slider.js', [],_S_VERSION, true);
        wp_enqueue_script('front-sliders', get_stylesheet_directory_uri(). '/js/slider.min.js', [],_S_VERSION, true);
    }

    wp_enqueue_script('womazing-scripts', get_stylesheet_directory_uri(). '/js/script.min.js', [],_S_VERSION, true);

    wp_enqueue_script('cart-modal-scripts', get_stylesheet_directory_uri(). '/js/modal-cart.min.js', [],_S_VERSION, true);


    if(is_cart()){
        wp_enqueue_script('cart-page-scripts', get_stylesheet_directory_uri(). '/js/page-cart.min.js', [],_S_VERSION, true);
    }

    if(is_checkout()){

        $np_api_key = carbon_get_theme_option('np_key') ? carbon_get_theme_option('np_key') : "1cacce8796b9324ed2ceb118d77bf6ce";
        wp_enqueue_script( 'jquery_ui', get_stylesheet_directory_uri() . '/libs/jquery-ui.min.js',array( 'jquery' ), null, false);
        wp_enqueue_script('cart-page-scripts', get_stylesheet_directory_uri(). '/js/checkout.min.js', [],_S_VERSION, true);
        wp_localize_script( 'cart-page-scripts', 'np_key', array( 'key' => $np_api_key));
    }

    if(is_product()){
        wp_enqueue_style('product_page-slider__css', get_stylesheet_directory_uri() .  '/libs/splide.min.css', array(), _S_VERSION);
        wp_enqueue_script('product_page-slider__js', get_stylesheet_directory_uri(). '/libs/splide.min.js', [],_S_VERSION, true);
    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'womazing_scripts');