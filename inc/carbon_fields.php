<?php

use Carbon_Fields\Carbon_Fields;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'crb_attach_theme_options');
add_action('carbon_fields_register_fields', 'crb_attach_terms_options');
add_action('carbon_fields_register_fields', 'crb_attach_product_options');
function crb_attach_theme_options()
{
    Container::make('theme_options', __('Options', 'womazing'))
        ->set_page_menu_position(3)

        ->add_tab(__('Analytics', 'womazing'), array(
            Field::make( 'header_scripts', 'facebook_pixels', __( 'Facebook pixels' ) ),
            Field::make( 'header_scripts', 'header_scripts', __( 'Header Scripts' ) ),
            Field::make( 'textarea', 'body_open_scripts', __( 'Body open Scripts' ) ),
            Field::make( 'footer_scripts', 'footer_scripts', __( 'Footer Scripts' ) )
        ))
        ->add_tab(__('Front page', 'womazing'), array(
            Field::make('complex', 'front_page_top_slider', __('Front page - Top slider', 'womazing'))
                ->add_fields(array(
                    Field::make('text', 'title', __('Slide Title', 'womazing'))->set_width(50),
                    Field::make('image', 'pc_photo', __('Slide Photo (for PC)', 'womazing'))->set_width(50),
                    Field::make('image', 'tablet_photo', __('Slide Photo (for tablet)', 'womazing'))->set_width(50),
                    Field::make('image', 'mobile_photo', __('Slide Photo (for mobile)', 'womazing'))->set_width(50),
                    Field::make('rich_text', 'subtitle', __('Slide Subtitle', 'womazing')),

                )),
            Field::make('complex', 'front_page_bottom_gallery', __('Front page - Bottom slider', 'womazing'))
                ->add_fields(array(
                    Field::make('image', 'photo', __('Slide Photo', 'womazing'))->set_width(50),
                ))
        ))
        ->add_tab(__('Contacts', 'womazing'), array(
            Field::make('text', 'phone', __('Phone Number', 'womazing'))->set_width(50),
            Field::make('text', 'email', __('Email'))->set_width(50),
            Field::make('text', 'adress', __('Address', 'womazing'))->set_width(50),
            Field::make('complex', 'social_media', __('Social medias', 'womazing'))
                ->add_fields(array(
                    Field::make('text', 'link', __('Link', 'womazing'))->set_width(50),
                    Field::make('select', 'type', __('Type', 'womazing'))->set_width(50)
                        ->set_options( array(
                            'inst' => 'Instagram',
                            'tiktok' => 'TikTok',
                            'fb' => 'Facebook',
                            'youtube' => 'YouTube',
                            'pinterest' => 'Pinterest',
                        ) )
                ,
                ))
        ))
        ->add_tab(__('Settings', 'womazing'), array(
            Field::make('text', 'telegram_token', __('Telegram Bot token'))->set_width(50),
            Field::make('text', 'telegram_chat_id', __('Telegram chat_id'))->set_width(50),
            Field::make('text', 'np_key', __('Nova Poshta Api Key'))->set_width(50),
        ));
}


function crb_attach_terms_options(){
    Container::make( 'term_meta', __( 'Category Properties', 'womazing' ) )
        ->where( 'term_taxonomy', '=', 'pa_color' )
        ->add_fields( array(
            Field::make( 'color', 'color', __( 'Color', 'womazing' ) )
        ) );
}


function crb_attach_product_options(){
    Container::make( 'post_meta', __( 'Product Options', 'womazing' ) )
        ->where( 'post_type', '=', 'product' )
        ->add_fields( array(
            Field::make( 'text', 'priority', __( 'Product priority', 'womazing' ) )
                ->set_attribute( 'type', 'integer' )
                ->set_width(25),
            Field::make( 'checkbox', 'front_show', __( 'Show on front page', 'womazing' ) )
                ->set_option_value( 'true' )
                ->set_width(25),
            Field::make( 'text', 'priority_catalog', __( 'Product priority in catalog', 'womazing' ) )
                ->set_attribute( 'type', 'integer' )
                ->set_default_value( '3' )
                ->set_width(25),
            Field::make( 'checkbox', 'catalog_show', __( 'Show on catalog page', 'womazing' ) )
                ->set_option_value( 'true' )
                ->set_default_value( 'true' )
                ->set_width(25),
        ) );
}


add_action('after_setup_theme', 'crb_load');
function crb_load()
{
    Carbon_Fields::boot();
}
