<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package womazing
 */


$logo = get_theme_mod('custom_logo');
$image = wp_get_attachment_image_src($logo, 'full');
if (!empty($image)) {
    $image_url = $image[0];
} else {
    $image_url = get_stylesheet_directory_uri() . '/img/logo.png';
}
$site_title = get_bloginfo('name');
$site_url = get_bloginfo('site_url');
$phone = carbon_get_theme_option('phone');
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="loader-wrapper">
    <div class="loader"></div>
</div>
<header class="header">
    <div class="container">
        <div class="burger">
            <div class="burger-btn"><?php _e('Меню', 'womazing'); ?></div>
            <div class="burger-menu">
                <?php if (has_nav_menu('burger_nav')): ?>
                    <?php
                    $menu_args = [
                        'theme_location' => 'burger_nav',
                    ];

                    wp_nav_menu($menu_args);
                    ?>
                <?php endif; ?>
            </div>
        </div>
        <a href="/">
            <img src="<?php echo $image_url; ?>" alt="<?php echo $site_title; ?>" title="<?php echo $site_title; ?>" class="logo">
        </a>
        <nav class="navigation">
            <?php if (has_nav_menu('header_nav')): ?>
                <?php
                $menu_args = [
                    'theme_location' => 'header_nav',
                ];

                wp_nav_menu($menu_args);
                ?>
            <?php endif; ?>
        </nav>
        <div class="call">
            <svg class="icon tel-icon">
                <use xlink:href="<?php echo theme_path(); ?>img/sprite.svg#tel"></use>
            </svg>
            <?php if (!empty($phone)): ?>
                <a href="tel:<?php echo $phone; ?>">
                    <?php echo $phone; ?>
                </a>
            <?php endif; ?>
        </div>
        <?php get_template_part('template-parts/modals/cart-modal');   ?>

    </div>
</header>
<main>