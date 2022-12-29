<?php

/**
 * Dump variable.
 */
if ( ! function_exists('d') ) {

    function d() {
        call_user_func_array( 'dump' , func_get_args() );
    }

}

/**
 * Dump variables and die.
 */
if ( ! function_exists('dd') ) {

    function dd() {
        call_user_func_array( 'dump' , func_get_args() );
        die();
    }

}

function theme_path(){
    return get_stylesheet_directory_uri() . '/';
}

function add_additional_class_on_li($classes, $item, $args) {
    if(isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);



function get_breadcrumb($items = null) {


    $crumbs = '<div class="crumbs">';
    $crumbs .= '<div class="crumbs-item"><a href="' . home_url() . '">' . __('Головна', 'woomazing') . '</a></div><div class="crumbs-item crumbs-decorate"></div>';
    if(!empty($items)){
        foreach ($items as $item){
            if(!empty($item['link'])){
                $link = $item['link'];
            } else{
                $link = '';
            }
            $crumbs .= '<div class="crumbs-item"><a href="' . $link . '">' . $item['title'] . '</a></div><div class="crumbs-item crumbs-decorate"></div>';
        }
    }
    $crumbs .= '<div class="crumbs-item"><a href="#">' . get_the_title() . '</a></div>';
    $crumbs .= '</div>';
    return $crumbs;
}

function get_variations_json($id){
    if(!empty($id)){
        $product = wc_get_product($id);

        if(!empty($product)){
            $vars = $product->get_available_variations();
            $var_data = [];

            foreach ($vars as $variation) {
                $data = [
                    'variation_id' => $variation['variation_id'],
                    'display_price' => $variation['display_price'],
                    'attributes' => $variation['attributes']
                ];

                array_push($var_data, $data);

            }

            return json_encode($var_data);
        }
    }

}