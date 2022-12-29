<?php /* Template Name: About page */ ?>


<?php

get_header();
?>
    <section class="about-brand">
        <div class="container">
            <div class="about-brand-header">
                <h3>
                    <?php the_title(); ?>
                </h3>
                <?php echo get_breadcrumb(); ?>
            </div>
            <div class="entry-content" style="margin-bottom: 50px">
                <?php
                if (have_posts()):
                    while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                else:
                    echo '<p>' . __('Постів не знайдено', 'womazing') .  '</p>';
                endif;
                ?>
            </div>
            <a href="<?php echo wc_get_page_permalink('shop'); ?>" class="about-brand-btn">
                <?php _e('До магазину', 'womazing'); ?>
            </a>
        </div>
    </section>

<?php get_footer(); ?>