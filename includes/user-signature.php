<?php
function factor_add_signature_field($user) {
    ?>
    <h3>امضای کاربر</h3>
    <form enctype="multipart/form-data" method="post"> <!-- فرم آپلود فایل -->
        <?php wp_nonce_field('save_user_signature', 'user_signature_nonce'); ?> <!-- امنیت با nonce -->
        <table class="form-table">
            <tr>
                <th><label for="user_signature">آپلود امضا</label></th>
                <td>
                    <?php 
                    $signature_url = get_user_meta($user->ID, 'user_signature', true);
                    if ($signature_url) {
                        echo '<img src="' . esc_url($signature_url) . '" width="200"><br>';
                    }
                    ?>
                    <input type="file" name="user_signature" id="user_signature">
                    <p class="description">یک فایل تصویری (JPG یا PNG) آپلود کنید.</p>
                </td>
            </tr>
        </table>
        <input type="submit" value="ذخیره تغییرات">
    </form>
    <?php
}
add_action('show_user_profile', 'factor_add_signature_field');
add_action('edit_user_profile', 'factor_add_signature_field');

// ذخیره‌سازی امضا
function factor_save_signature($user_id) {
    // بررسی nonce برای امنیت
    if (!isset($_POST['user_signature_nonce']) || !wp_verify_nonce($_POST['user_signature_nonce'], 'save_user_signature')) {
        return;
    }

    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    if (!empty($_FILES['user_signature']['name'])) {
        $file = $_FILES['user_signature'];

        // بررسی نوع فایل
        $allowed_types = array('image/jpeg', 'image/png');
        if (!in_array($file['type'], $allowed_types)) {
            echo 'فقط فایل‌های JPG یا PNG قابل آپلود هستند.';
            return;
        }

        // بارگذاری فایل
        $upload = wp_handle_upload($file, array('test_form' => false));

        if (isset($upload['error'])) {
            // نمایش خطای بارگذاری
            echo 'خطا در بارگذاری فایل: ' . $upload['error'];
        } else {
            // ذخیره مسیر فایل در متا داده‌های کاربر
            update_user_meta($user_id, 'user_signature', esc_url($upload['url']));
        }
    }
}
add_action('personal_options_update', 'factor_save_signature');
add_action('edit_user_profile_update', 'factor_save_signature');
