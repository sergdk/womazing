<?php


function add_menus(){
    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(
        array(
            'header_nav' => esc_html__( 'Header', 'womazing' ),
            'burger_nav' => esc_html__( 'Burger', 'womazing' ),
            'footer_nav' => esc_html__( 'Footer', 'womazing' ),
            'policy_nav' => esc_html__( 'Policy', 'womazing' ),
            'catalog_nav' => esc_html__( 'Catalog categories', 'womazing' ),
        )
    );
}

add_action('after_setup_theme', 'add_menus');