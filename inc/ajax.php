<?php

add_action('wp_ajax_cart_action', 'cart_action_ajax');
add_action('wp_ajax_nopriv_cart_action', 'cart_action_ajax');

function cart_action_ajax()
{

    $res = [
        'request' => $_POST,
    ];

    if ($_POST['details'] == 'add_to_cart') {
        $product_id = $_POST['product_id'];
        $qnt = $_POST['qnt'];
        $var_count = 0;
        $var_id = $_POST['variation_id'] ? $_POST['variation_id'] : '';

        if (!empty($var_id)) {
            $var_count = count(wc_get_product($product_id)->get_available_variations());
        }

        if($var_count > 1){
            $add_to_cart = WC()->cart->add_to_cart((int)$product_id, $qnt, $var_id);
        } else{
            $add_to_cart = WC()->cart->add_to_cart((int)$product_id, $qnt);
        }

        if($add_to_cart){
            $res['cart_item'] = WC()->cart->get_cart_item($add_to_cart);
            $res['status'] = 'success';
        }

//        $res['test'] = $var_id;

        $res['cart'] = getCart();
    } elseif ($_POST['details'] == 'get_cart') {
        $res['status'] = true;
        $res['cart'] = getCart();
    } elseif ($_POST['details'] == 'remove_from_cart') {

        $remove = WC()->cart->remove_cart_item($_POST['item']);
        if ($remove) {
            $res['status'] = true;
        } else {
            $res['status'] = false;
        }

        $res['cart'] = getCart();
    } elseif ($_POST['details'] == 'item_plus') {

        $index = $_POST['index'];
        $cart = WC()->cart;
        $cart_item = $cart->get_cart()[$index];
        $qnt = $cart_item['quantity'];

        $change = WC()->cart->set_quantity($index, (int)$qnt + 1);
        if ($change) {
            $res['status'] = true;
        } else {
            $res['status'] = false;
        }

        $res['cart'] = getCart();
    } elseif ($_POST['details'] == 'item_minus') {

        $index = $_POST['index'];
        $cart = WC()->cart;
        $cart_item = $cart->get_cart()[$index];
        $qnt = $cart_item['quantity'];

        $change = WC()->cart->set_quantity($index, (int)$qnt - 1);
        if ($change) {
            $res['status'] = true;
        } else {
            $res['status'] = false;
        }

        $res['cart'] = getCart();
    } elseif ($_POST['details'] == 'set_coupon') {
        $coupon = $_POST['coupon'];
        $cart = WC()->cart;
        $set = $cart->add_discount($coupon);;

        if ($set) {
            $res['status'] = true;
        } else {
            $res['status'] = false;
        }

        $res['coupon'] = $coupon;

        $res['cart'] = getCart();
    }

    echo json_encode($res);
    die;
}


function getCart()
{
    $cart = WC()->cart;
    $get_cart = $cart->get_cart();
    $count = $cart->get_cart_contents_count();
    $total_without_coupon = $cart->get_totals()['subtotal'];
    $total = $cart->get_cart_contents_total();
    $coupons = $cart->get_coupons();

    $cart_sorted = [
        'products' => [],
        'count' => $count,
        'total' => (int)$total,
        'total_w_coupon' => (int)$total_without_coupon,
        'coupons' => $coupons,

    ];

    foreach ($get_cart as $key => $item) {
        $product = wc_get_product($item['product_id']);
        $data = [
            'id' => $product->get_id(),
            'sku' => $product->get_sku(),
            'title' => $product->get_name(),
            'qnt' => $item['quantity'],
            'subtotal' => $item['line_total'],
            'item' => $item
        ];

        if(!empty($product->get_gallery_image_ids())){
            $data['image'] = wp_get_attachment_image_src($product->get_gallery_image_ids()[0], 'middle')[0];
        } elseif (!empty($product->get_image_id())){
            $data['image'] = wp_get_attachment_image_src($product->get_image_id(), 'middle')[0];
        } else{
            $data['image'] = '';
        }


        if ($product->is_type('simple')) {
            $data['price'] = $product->get_price();
        } elseif ($product->is_type('variable')) {
            $variation_id = $item['variation_id'];

            $variations = $product->get_available_variations();

            foreach ($variations as $var_key => $var) {
                if ($var['variation_id'] === $variation_id) {
                    $data['variation'] = $variations[$var_key];
                    $data['price'] = $variations[$var_key]['display_price'];
                }
            }
        } else {
            $data['price'] = $product->get_price();
        }

        if (isset($get_cart[$key]['variation']['attribute_pa_size'])) {
            $data['size'] = $get_cart[$key]['variation']['attribute_pa_size'];
        }

        if (isset($get_cart[$key]['variation']['attribute_pa_color'])) {
            $data['color']['slug'] = $get_cart[$key]['variation']['attribute_pa_color'];
            $term = get_term_by('slug', $data['color']['slug'], 'pa_color');
            $data['color']['title'] = $term->name;
        }

        $cart_sorted['products'][$key] = $data;
    }

    return $cart_sorted;
}


add_action('wp_ajax_send_form', 'formActionsAjax');
add_action('wp_ajax_nopriv_send_form', 'formActionsAjax');


function formActionsAjax()
{

    $res = '';

    $action = $_POST['details'];
    if ($action === 'fast_purchase_form') {
        $sendedData = $_POST;
        $sendedData['type'] = 'Швидке замовлення';

        if(!empty($sendedData['fp_variation_id'])){
            $product =  wc_get_product( (int) $sendedData['fp_variation_id'] );
            $product_title = $product->get_name();

            if($product->get_sale_price() == ''){
                $product_price = $product->get_regular_price();
            } else{
                $product_price = $product->get_sale_price();
            }

            $sendedData['product'] = $product_title . ' | ' . $product_price . ' грн';

        } else{
            $product = ( wc_get_product( (int) $sendedData['fp_product_id'] ) );
        }
        $send_to_tg = sendToTelegram($sendedData);
        $createOrder = createOrderFastPurchase($_POST);

        if($send_to_tg['status'] === true && $createOrder['status'] === true){
            $res = [
                'status' => true,
                'data' => $_POST,
                'telegram' => $send_to_tg,
                'order' => $createOrder,
            ];
        } else{
            $res = [
                'status' => false,
                'data' => $_POST,
                'telegram' => $send_to_tg,
                'order' => $createOrder,
            ];
        }
    } elseif($action === 'callback_form'){
        $sendedData = $_POST;
        $sendedData['type'] = 'Зворотній дзвінок';

        $send_to_tg = sendToTelegram($sendedData);

        if($send_to_tg['status'] === true){
            $res = [
                'status' => true,
                'telegram' => $send_to_tg,
            ];
        } else{
            $res = [
                'status' => false,
                'telegram' => $send_to_tg,
            ];
        }
    }


    wp_send_json($res);
}





function createOrderFastPurchase($data){

    $res = [];

    if(!empty($data)){
        $order = wc_create_order();
        if(!empty($data['fp_variation_id'])){
            $order->add_product( wc_get_product( (int) $data['fp_variation_id'] ));
        } else{
            $order->add_product( wc_get_product( (int) $data['fp_product_id'] ) );
        }

        $shipping = new WC_Order_Item_Shipping();
        $shipping->set_method_title( 'Нова Пошта' );
        $shipping->set_method_id( 'free_shipping:1' );
        $shipping->set_total( 80 );
        $order->add_item( $shipping );
        $order->calculate_totals();

        $address = array(
            'first_name' => $data['name'],
            'last_name'  => '',
            'company'    => '',
            'email'      => '',
            'phone'      => preg_replace('/[^0-9]/', '', $data['phone']),
            'address_1'  => '',
            'address_2'  => '',
            'city'       => '',
            'state'      => '',
            'postcode'   => '',
            'country'    => 'UA'
        );

        $order->set_address( $address, 'billing' );
        $order->set_address( $address, 'shipping' );
        $order->set_status( 'wc-pending' );
        $save_order = $order->save();

        if($save_order){
            $res['status'] = true;
        } else{
            $res['status'] = false;
            $res['data'] = $data;
        }

    } else{
        $res['status'] = false;
        $res['data'] = $data;
    }


    return $res;
}