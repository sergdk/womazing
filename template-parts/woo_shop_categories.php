<?php if (has_nav_menu('catalog_nav')): ?>
    <?php
    $menu_args = [
        'theme_location' => 'catalog_nav',
        'menu_class' => 'catalog-type',
        'container' => false,
        'add_li_class'  => 'type-item'
    ];

    wp_nav_menu($menu_args);
    ?>
<?php endif; ?>