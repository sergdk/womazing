<div id="modal_callback" class="modal-callback modal">
    <h3 class="callback-title">
        <?php _e('Замовити зворотний дзвінок', 'womazing'); ?>
    </h3>
    <i class="fa-solid fa-xmark"></i>
    <form id="callback-form" action="#" class="callback-form" method="post">
        <input type="text" name="name" placeholder="<?php _e('Ваше ім\'я', 'womazing'); ?>" required minlength="3">
        <input type="text" name="email" placeholder="E-mail">
        <input type="text" name="phone" placeholder="<?php _e('Телефон', 'womazing'); ?>" required>
        <button type="submit"><?php _e('Замовити Дзвінок', 'womazing'); ?></button>
    </form>
</div>
<div class="modal-answer">
    <h3 class="answer-title"><?php _e('Чудово! Ми незабаром вам передзвонимо.', 'womazing'); ?></h3>
    <!-- <i class="fa-solid fa-xmark"></i> -->
    <div class="answer-button"><?php _e('Закрити', 'womazing'); ?></div>
</div>
<div id="modal_callback_bg" class="green-bg"></div>