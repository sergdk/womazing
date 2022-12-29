<?php
$args = array(
    'post_type'=> 'product',
    'post_status' => 'publish',
    'posts_per_page' => 6,
    'orderby' => 'priority',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'front_show',
            'value' => 'true',
        ),
        'priority' => array(
            'key' => 'priority',
            'compare' => 'EXISTS',
        ),
    )
);
$loop = new WP_Query( $args );


if (!empty($loop->get_posts()) && $loop->post_count > 0): ?>
    <section class="collection">
        <div class="container">
            <h2 class="collection-title">
                <?php _e('Нова колекція', 'womazing'); ?>
            </h2>
            <ul class="collection-list">
                <?php foreach ($loop->get_posts() as $loop_item): ?>
                    <?php
                    $product = wc_get_product($loop_item->ID);
                    $product_id = $product->get_id();
                    $product_image = $product->get_image_id();
                    $product_title = $product->get_name();

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

                    $img = wp_get_attachment_image_src($product_image, 'large');

                    ?>
                    <li class="collection-item">
                        <a href="<?php echo get_permalink($product_id); ?>" class="link-photo">
                            <div class="overlay">
                                <svg class="icon">
                                    <use xlink:href="<?php echo theme_path(); ?>img/sprite.svg#arrow-right"></use>
                                </svg>
                            </div>
                            <?php if($img) : ?>
                                <img src="<?php echo $img[0];  ?>" alt="<?php echo $product->get_name(); ?>" alt="<?php echo $product_title; ?>">
                            <?php else: ?>
                                <img src="<?php echo theme_path()?>img/placeholder-image.png" alt="<?php echo $product->get_name(); ?>">
                            <?php endif; ?>
                        </a>
                        <h3 class="item-title">
                            <a href="<?php echo get_permalink($product_id); ?>" class="link-title">
                                <?php echo $product_title; ?>
                            </a>
                        </h3>
                        <div class="prices">
                            <?php if($regular_price !== ''): ?>
                                <?php if (!empty($sale_price)): ?>
                                    <div class="new-price">
                                        <?php echo $sale_price . get_woocommerce_currency_symbol() ?>
                                    </div>
                                    <span class="old-price">
                                        <?php echo $regular_price . get_woocommerce_currency_symbol() ?>
                                    </span>
                                <?php else: ?>
                                    <div class="new-price">
                                        <?php echo $regular_price . get_woocommerce_currency_symbol() ?>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="new-price">
                                     Немає в наявності
                                </div>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <a href="<?php echo wc_get_page_permalink('shop'); ?>" class="collection-btn">
                <?php _e('До магазину', 'womazing'); ?>
            </a>
        </div>
    </section>
<?php endif; ?>