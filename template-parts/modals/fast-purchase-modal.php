<div id="fast_purchase" class="fast-purchase modal">
    <div class="fast-purchase-close">
        <i class="fa-solid fa-xmark"></i>
    </div>
    <div class="fast-purchase-title">
        <?php _e('Швидке замовлення', 'womazing'); ?></div>
    <div class="fast-purchase-content">
        <div class="fast-purchase-product">
            <div class="fast-product-image">
                <img id="fp_img" src="<?php echo theme_path(); ?>img/good1.jpg" alt="">
            </div>
            <div class="fast-product-info">
                <h3 id="fp_title" class="fast-product-title">Футболка USA</h3>
                <div class="fast-product__attrs"></div>
                <div id="fp_price" class="fast-product-price">
                    $129
                </div>
            </div>
        </div>
        <form id="fast_purchase_form" action="#" method="POST">
            <input type="text" name="name" placeholder="<?php _e('ПІБ', 'womazing'); ?>" minlength="3">
            <input type="text" name="phone" placeholder="<?php _e('Номер телефону', 'womazing'); ?>" required>
            <button type="submit" class="fast-purchase-btn">
                <?php _e('Замовити', 'womazing'); ?>
            </button>

            <input type="hidden" id="fp_product_id" name="fp_product_id" value="">
            <input type="hidden" id="fp_variation_id" name="fp_variation_id" value="">
        </form>
    </div>
</div>
<div id="fast_purchase_bg" class="fast-bg"></div>