<?php
/*
 * Plugin Name:       فاکتور دوره های سمپاشی
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       افزونه ای که کمک میکند فاکتور های دوره های سم پاشی را به حساب کاربری شخص اضافه کنیم.
 * Version:           1.0.0
 * Requires PHP:      7.2
 * Author:            فرزانه نظم آبادی
 * Author URI:        https://farzanenazmabadi.ir/
 * Text Domain:       factor
 * Domain Path:       /languages
 * Requires Plugins:  woocommerce
 */



// جلوگیری از دسترسی مستقیم
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

// تعریف ثابت‌ها
define( 'FACTOR_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

// وارد کردن فایل‌های جداگانه
require_once FACTOR_PLUGIN_PATH . 'includes/account-tab.php';
require_once FACTOR_PLUGIN_PATH . 'includes/user-meta-fields.php';
 //////////////////////////

 

/////////////////////
