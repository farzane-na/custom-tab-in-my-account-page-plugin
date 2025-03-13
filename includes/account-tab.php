<?php
function factor_endpoints() {
    add_rewrite_endpoint( 'factor-tab', EP_ROOT | EP_PAGES );
}

add_action( 'init', 'factor_endpoints' );



// add_action('woocommerce_account_factor-tab_endpoint', function(){
//     echo '<h2>فاکتور دوره‌های سمپاشی</h2>';
//     echo '<table border="1" width="100%">
//         <tr>
//             <th>نوع سمپاشی</th>
//             <th>تاریخ</th>
//             <th>مبلغ</th>
//             <th>وضعیت</th>
//         </tr>
//         <tr>
//             <td>12345</td>
//             <td>1402/12/15</td>
//             <td>500,000 تومان</td>
//             <td>پرداخت شده</td>
//         </tr>
//     </table>'; 
// } );
add_action('woocommerce_account_factor-tab_endpoint', function(){
    $current_user = get_current_user_id();
    $spraying_type = get_user_meta($current_user, 'spraying_records', true);
    $user_signature = get_avatar_url($current_user);
    
    if (is_array($spraying_type) && !empty($spraying_type)) {
        echo '<h2>فاکتور دوره‌های سمپاشی</h2>';
        echo '<table border="1" width="100%">
            <tr>
                <th>نوع سمپاشی</th>
                <th>تاریخ</th>
                <th>مبلغ</th>
                <th>وضعیت</th>
            </tr>';

        foreach ($spraying_type as $record) {
            echo '<tr>';
            echo '<td>' . esc_html($record['type']) . '</td>';
            echo '<td>' . esc_html($record['date']) . '</td>';
            echo '<td>' . esc_html($record['price']) . ' تومان</td>';
            echo '<td>' . esc_html($record['plan']) . '</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo "<img src=".$user_signature." style='width:200px;margin-top:10px;border-radius:10px;' alt='امضای کاربر'/>";
    } else {
        echo '<p>هیچ فاکتوری برای نمایش وجود ندارد.</p>';
    }
} );



 function adding_custom_tab_my_account_page($items){
    // var_dump($items);
    $items = array(
        'dashboard'         => __( 'Dashboard', 'woocommerce' ),
        'orders'            => __( 'Orders', 'woocommerce' ),
        'edit-address'    => __( 'Addresses', 'woocommerce' ),
        'edit-account'      => __( ' ویرایش اطلاعات', 'woocommerce' ),
        'factor-tab'      => 'فاکتور دوره‌ها',
        'customer-logout'   => __( 'Logout', 'woocommerce' ),
    );
    return $items;
 }
 add_filter("woocommerce_account_menu_items","adding_custom_tab_my_account_page");

 
