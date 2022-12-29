<?php

$main_slider = carbon_get_theme_option('front_page_top_slider');
$site_title = get_bloginfo('name');

?>

<?php if (!empty($main_slider)): ?>
    <section class="intro">
        <div class="intro-wrapper">
            <div class="left-side">
                <div class="container">
                    <ul class="intro-list">
                        <?php foreach ($main_slider as $slider_item): ?>
                            <?php $pc_img_link = wp_get_attachment_image_src($slider_item['pc_photo'], 'full')[0]; ?>
                            <?php $tablet_img_link = wp_get_attachment_image_src($slider_item['tablet_photo'], 'full')[0]; ?>
                            <?php $mobile_img_link = wp_get_attachment_image_src($slider_item['mobile_photo'], 'full')[0]; ?>
                            <li class="intro-item">
                                <div class="intro-photo">
                                    <img src="<?php echo $mobile_img_link; ?>" alt="<?php echo $site_title; ?>" class="mob-img">
                                    <img src="<?php echo $tablet_img_link; ?>" alt="<?php echo $site_title; ?>" class="tab-img">
                                    <img src="<?php echo $pc_img_link; ?>" alt="<?php echo $site_title; ?>" class="desktop-img">
                                </div>
                                <div class="intro-info">
                                    <h2 class="intro-title">
                                        <?php echo $slider_item['title']; ?>
                                    </h2>
                                    <p class="intro-text">
                                        <?php echo $slider_item['subtitle'];?>
                                    </p>
                                    <div class="intro-btns">
                                        <div class="btn-arrow">
                                            <a href="">
                                                <svg class="icon">
                                                    <use xlink:href="<?php echo theme_path(); ?>img/sprite.svg#arrow-down"></use>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="btn-shop">
                                            <a href="<?php echo wc_get_page_permalink( 'shop' ); ?>">
                                                <?php _e('До магазину', 'womazing'); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="slider-nav">
                        <?php foreach ($main_slider as $slider_nav): ?>
                            <div class="slider-nav__item"></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>