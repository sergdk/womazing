<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined('ABSPATH') || exit;
?>

<div class="woocommerce-order">
    <?php
    if ($order) :

        do_action('woocommerce_before_thankyou', $order->get_id());
        ?>

        <?php if ($order->has_status('failed')) : ?>
        <section class="thank">
            <div class="container">
                <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce'); ?></p>

                <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                    <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>"
                       class="button pay"><?php esc_html_e('Pay', 'woocommerce'); ?></a>
                    <?php if (is_user_logged_in()) : ?>
                        <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>"
                           class="button pay"><?php esc_html_e('My account', 'woocommerce'); ?></a>
                    <?php endif; ?>
                </p>
            </div>
        </section>
    <?php else : ?>
        <script>
            fbq('track', 'Lead');
            console.log('Lead')
        </script>
        <section class="thank">
            <div class="container">
                <div class="thank-header">
                    <h3>
                        <?php _e('Замовлення успішно оформлено', 'womazing'); ?>
                    </h3>
                    <?php echo woocommerce_breadcrumb(); ?>
                </div>
                <div class="thank-wrapper">
                    <div class="thank-content">
                        <div class="decorate-image">
                            <img src="<?php echo theme_path() ?>img/thank.png" alt="<?php echo bloginfo('title'); ?>">
                        </div>
                        <h3 class="thank-title">
                            <?php _e('Замовлення успішно оформлено', 'womazing'); ?>
                        </h3>

                        <div class="order-thank-you">
                            <span>
                                <?php esc_html_e('Order number:', 'woocommerce'); ?>
                                <strong>
                                    <?php echo $order->get_order_number(); ?>
                                </strong>
                            </span>

                            <span>
                                <?php esc_html_e('Date:', 'woocommerce'); ?>
                                <strong>
                                    <?php echo wc_format_datetime($order->get_date_created());
                                    ?>
                                </strong>
                            </span>


                            <?php if (is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email()) : ?>
                                <span>
                                    <?php esc_html_e('Email:', 'woocommerce'); ?>
                                    <strong><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
                                </span>
                            <?php endif; ?>

                            <span>
                                <?php esc_html_e('Total:', 'woocommerce'); ?>
                                <strong><?php echo $order->get_formatted_order_total(); ?>
                                </strong>
                            </span>
                        </div>


                        <span class="thank-subtitle">
                        <?php _e('Ми зв\'яжемося з вами найближчим часом!', 'womazing'); ?>
                    </span>
                    </div>
                    <a class="thank-link" href="<?php echo home_url(); ?>">
                        <?php _e('Перейти на головну', 'womazing') ?>
                    </a>
                </div>
            </div>
        </section>

    <?php endif; ?>

    <?php endif; ?>

</div>
