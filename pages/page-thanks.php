<?php /* Template Name: Thanks page */ ?>


<?php get_header(); ?>
<section class="thank">
    <div class="container">
        <div class="thank-header">
            <h3>
                <?php _e('Оформлення замовлення', 'womazing'); ?>
            </h3>
            <?php
            $br_args = [
                [
                    'title' => 'Оформлення замовлення',
                    'link' => null
                ]
            ];
            echo get_breadcrumb($br_args); ?>
        </div>
        <div class="thank-wrapper">
            <div class="thank-content">
                <div class="decorate-image">
                    <img src="img/thank.png" alt="">
                </div>
                <h3 class="thank-title">
                    <?php _e('Замовлення успішно оформлено', 'womazing'); ?>
                </h3>
                <span class="thank-subtitle">
                    <?php _e('Ми зв\'яжемося з вами найближчим часом!', 'womazing'); ?>
                </span>
            </div>
            <a class="thank-link" href="<?php echo home_url(); ?>">
                <?php _e('Перейти на головну', 'womazing'); ?>
            </a>
        </div>
    </div>
</section>
<?php get_footer(); ?>
