<?php

add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);

function change_existing_currency_symbol($currency_symbol, $currency)
{
    switch ($currency) {
        case 'UAH':
            $currency_symbol = 'грн.';
            break;
    }
    return $currency_symbol;
}

add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 3);

function special_nav_class ($classes, $item, $args) {

    if ( 'catalog_nav' === $args->theme_location ) {
        if (in_array('current-menu-item', $classes) ){
            $classes[] = 'type-item-active ';
        }
    }

    return $classes;
}