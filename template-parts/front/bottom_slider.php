<?php

$bottom_slider = carbon_get_theme_option('front_page_bottom_gallery');

?>

<section class="team">
    <div class="container">
        <h2 class="team-title">
            <?php _e('Наша Команда мрії', 'womazing'); ?>
        </h2>
        <div class="team-wrapper">

            <?php if(!empty($bottom_slider)): ?>
            <div class="photo-wrapper">
                <div class="controls-team">
                    <div class="arrows left-arrow">
                        <svg class="icon">
                            <use xlink:href="<?php echo theme_path(); ?>img/sprite.svg#l-arrow-team"></use>
                        </svg>
                    </div>
                    <div class="arrows right-arrow">
                        <svg class="icon">
                            <use xlink:href="<?php echo theme_path(); ?>img/sprite.svg#r-arrow-team"></use>
                        </svg>
                    </div>
                </div>
                <ul class="team-photo">
                    <?php foreach ($bottom_slider as $slider): ?>
                    <?php $img_link = wp_get_attachment_image_src($slider['photo'], 'full')[0]; ?>
                    <li class="photo-item">
                        <img src="<?php echo $img_link; ?>" alt="">
                    </li>
                    <?php endforeach; ?>
                </ul>
                <div class="nav-team">
                    <?php foreach ($bottom_slider as $nav_item): ?>
                        <div class="nav-team__item"></div>
                    <?php endforeach; ?>
                </div>

            </div>
            <?php endif; ?>

            <div class="team-info">
                <h3 class="team-info__title">
                    <?php _e('Для кожної', 'womazing'); ?>
                </h3>
                <p class="first-text">
                    <?php _e('Кожна дівчина є унікальною. Однак, ми схожі на мільйон дрібниць.', 'womazing'); ?>
                </p>
                <p class="second-text">
                    <?php _e('Womazing шукає ці дрібниці та створює чудові речі, які вигідно підкреслюють переваги кожної дівчини.', 'womazing'); ?>
                </p>
                <a href="<?php echo get_permalink( get_page_by_path( 'about_brand' ) ); ?>" class="team-link">
                    <?php _e('Детальніше про бренд', 'womazing'); ?>
                </a>
            </div>
        </div>
    </div>
</section>