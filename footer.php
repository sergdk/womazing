<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
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
$email = carbon_get_theme_option('email');
$social_media = carbon_get_theme_option('social_media');
?>
</main>
<?php
    get_template_part('template-parts/modals/callback-modal');
    get_template_part('template-parts/modals/fast-purchase-modal');
    get_template_part('template-parts/modals/success-modal');

?>
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <a href="/">
                <img src="<?php echo $image_url; ?>" alt="<?php echo $site_title; ?>" title="<?php echo $site_title; ?>">
            </a>
            <div class="footer-content__wrapper">
                <p><?php _e('© Усі права захищені', 'womazing'); ?></p>
                <?php if (has_nav_menu('policy_nav')): ?>
                    <div class="content-links">
                        <?php
                        $menu_args = [
                            'theme_location' => 'policy_nav',
                        ];

                        wp_nav_menu($menu_args);
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if (has_nav_menu('footer_nav')): ?>
            <div class="footer-menu">
                <?php
                $menu_args = [
                    'theme_location' => 'footer_nav',
                ];
                wp_nav_menu($menu_args);
                ?>
            </div>
        <?php endif; ?>
        <div class="footer-contacts">
            <div class="contacts-links">
                <?php if (!empty($phone)): ?>
                    <a href="tel:<?php echo $phone; ?>">
                        <?php echo $phone; ?>
                    </a>
                <?php endif; ?>
                <?php if (!empty($email)): ?>
                    <a href="mailto:<?php echo $email; ?>">
                        <?php echo $email; ?>
                    </a>
                <?php endif; ?>
            </div>
            <?php if (!empty($social_media)): ?>
                <ul class="social">
                    <?php foreach ($social_media as $media): ?>
                        <li>
                            <?php
                            if ($media['type'] == 'inst') {
                                $img = '<svg class="icon"><use xlink:href="' . theme_path() . 'img/sprite.svg#insta' . '"></use></svg>';
                            } elseif ($media['type'] == 'fb') {
                                $img = '<svg class="icon"><use xlink:href="' . theme_path() . 'img/sprite.svg#fb' . '"></use></svg>';
                            } elseif ($media['type'] == 'tiktok') {
                                $img = '<svg class="icon" viewBox="0 0 512 512" id="icons" xmlns="http://www.w3.org/2000/svg"><path d="M412.19,118.66a109.27,109.27,0,0,1-9.45-5.5,132.87,132.87,0,0,1-24.27-20.62c-18.1-20.71-24.86-41.72-27.35-56.43h.1C349.14,23.9,350,16,350.13,16H267.69V334.78c0,4.28,0,8.51-.18,12.69,0,.52-.05,1-.08,1.56,0,.23,0,.47-.05.71,0,.06,0,.12,0,.18a70,70,0,0,1-35.22,55.56,68.8,68.8,0,0,1-34.11,9c-38.41,0-69.54-31.32-69.54-70s31.13-70,69.54-70a68.9,68.9,0,0,1,21.41,3.39l.1-83.94a153.14,153.14,0,0,0-118,34.52,161.79,161.79,0,0,0-35.3,43.53c-3.48,6-16.61,30.11-18.2,69.24-1,22.21,5.67,45.22,8.85,54.73v.2c2,5.6,9.75,24.71,22.38,40.82A167.53,167.53,0,0,0,115,470.66v-.2l.2.2C155.11,497.78,199.36,496,199.36,496c7.66-.31,33.32,0,62.46-13.81,32.32-15.31,50.72-38.12,50.72-38.12a158.46,158.46,0,0,0,27.64-45.93c7.46-19.61,9.95-43.13,9.95-52.53V176.49c1,.6,14.32,9.41,14.32,9.41s19.19,12.3,49.13,20.31c21.48,5.7,50.42,6.9,50.42,6.9V131.27C453.86,132.37,433.27,129.17,412.19,118.66Z"/></svg>';
                            } elseif ($media['type'] == 'pinterest') {
                                $img = '<svg class="icon" xmlns="http://www.w3.org/2000/svg"viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0z"/><path fill-rule="nonzero" d="M8.49 19.191c.024-.336.072-.671.144-1.001.063-.295.254-1.13.534-2.34l.007-.03.387-1.668c.079-.34.14-.604.181-.692a3.46 3.46 0 0 1-.284-1.423c0-1.337.756-2.373 1.736-2.373.36-.006.704.15.942.426.238.275.348.644.302.996 0 .453-.085.798-.453 2.035-.071.238-.12.404-.166.571-.051.188-.095.358-.132.522-.096.386-.008.797.237 1.106a1.2 1.2 0 0 0 1.006.456c1.492 0 2.6-1.985 2.6-4.548 0-1.97-1.29-3.274-3.432-3.274A3.878 3.878 0 0 0 9.2 9.1a4.13 4.13 0 0 0-1.195 2.961 2.553 2.553 0 0 0 .512 1.644c.181.14.25.383.175.59-.041.168-.14.552-.176.68a.41.41 0 0 1-.216.297.388.388 0 0 1-.355.002c-1.16-.479-1.796-1.778-1.796-3.44 0-2.985 2.491-5.584 6.192-5.584 3.135 0 5.481 2.329 5.481 5.14 0 3.532-1.932 6.104-4.69 6.104a2.508 2.508 0 0 1-2.046-.959l-.043.177-.207.852-.002.007c-.146.6-.248 1.017-.288 1.174-.106.355-.24.703-.4 1.04a8 8 0 1 0-1.656-.593zM12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>';
                            } elseif ($media['type'] == 'youtube') {
                                $img = '<svg class="icon" xmlns="http://www.w3.org/2000/svg"  version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 49 49" style="enable-background:new 0 0 49 49;" xml:space="preserve"><path d="M39.256,6.5H9.744C4.371,6.5,0,10.885,0,16.274v16.451c0,5.39,4.371,9.774,9.744,9.774h29.512    c5.373,0,9.744-4.385,9.744-9.774V16.274C49,10.885,44.629,6.5,39.256,6.5z M47,32.726c0,4.287-3.474,7.774-7.744,7.774H9.744    C5.474,40.5,2,37.012,2,32.726V16.274C2,11.988,5.474,8.5,9.744,8.5h29.512c4.27,0,7.744,3.488,7.744,7.774V32.726z"/><path d="M33.36,24.138l-13.855-8.115c-0.308-0.18-0.691-0.183-1.002-0.005S18,16.527,18,16.886v16.229    c0,0.358,0.192,0.69,0.502,0.868c0.154,0.088,0.326,0.132,0.498,0.132c0.175,0,0.349-0.046,0.505-0.137l13.855-8.113    c0.306-0.179,0.495-0.508,0.495-0.863S33.667,24.317,33.36,24.138z M20,31.37V18.63l10.876,6.371L20,31.37z"/></svg>';
                            }
                            ?>
                            <a href="<?php echo $media['link']; ?>">
                                <?php echo $img; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <div class="payment">
                <img src="<?php echo theme_path(); ?>img/visa-mastercard.png" alt="">
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
