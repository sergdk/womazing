<?php /* Template Name: Contacts page */ ?>


<?php

get_header();

$phone = carbon_get_theme_option('phone');
$email = carbon_get_theme_option('email');
$adress = carbon_get_theme_option('adress');
?>

    <section class="contacts">
        <div class="container">
            <div class="contacts-header">
                <h3>
                    <?php _e('Контакти', 'womazing'); ?>
                </h3>
                <?php echo get_breadcrumb(); ?>
            </div>
            <ul class="contacts-text">
                <?php if (!empty($phone)): ?>
                    <li>
                        <span>
                            <?php _e('Телефон', 'womazing'); ?>
                        </span>
                        <a href="<?php echo $phone; ?>"><?php echo $phone; ?></a>
                    </li>
                <?php endif; ?>

                <?php if (!empty($email)): ?>
                    <li>
                        <span>
                            <?php _e('E-mail', 'womazing'); ?>
                        </span>
                        <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                    </li>
                <?php endif; ?>

                <?php if (!empty($adress)): ?>
                    <li>
                        <span>
                            <?php _e('Адреса', 'womazing'); ?>
                        </span>
                        <p><?php echo $adress; ?></p>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="contacts-form">
                <h3 class="contacts-form__title">
                    <?php _e('Напишіть нам', 'womazing'); ?>
                </h3>
                <form id="contacts_form" class="contacts_form" action="" method="POST">
                    <input type="text" name="name" placeholder="<?php _e('Ваше ім\'я', 'womazing'); ?>" required minlength="3">
                    <input type="text" name="email" placeholder="E-mail" required>
                    <input type="tel" name="phone" placeholder="<?php _e('Телефон', 'womazing'); ?>" required>
                    <textarea name="message" id="" cols="40" rows="10" placeholder="<?php _e('Повідомлення', 'womazing'); ?>"></textarea>
                    <button type="submit">
                        <?php _e('Відправити', 'womazing'); ?>
                    </button>
                </form>
            </div>
        </div>
    </section>

<?php
get_footer();
?>