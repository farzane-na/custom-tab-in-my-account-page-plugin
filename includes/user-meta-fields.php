<?php
function add_custom_user_fields($user) {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    $spraying_data = get_user_meta($user->ID, 'spraying_records', true);
    if (!$spraying_data) {
        $spraying_data = [];
    }
    ?>
    <h2>تاریخچه سمپاشی</h2>
    <table class="form-table" id="spraying_records_table">
        <tr>
            <th>نوع سمپاشی</th>
            <th>تاریخ سمپاشی</th>
            <th>مبلغ (تومان)</th>
            <th>دوره</th>
            <th>حذف</th>
        </tr>
        <?php foreach ($spraying_data as $index => $record) : ?>
            <tr>
                <td><input type="text" name="spraying_records[<?php echo $index; ?>][type]" value="<?php echo esc_attr($record['type']); ?>" /></td>
                <td><input type="text" name="spraying_records[<?php echo $index; ?>][date]" value="<?php echo esc_attr($record['date']); ?>" /></td>
                <td><input type="text" name="spraying_records[<?php echo $index; ?>][price]" value="<?php echo esc_attr($record['price']); ?>" /></td>
                <td>
                    <select name="spraying_records[<?php echo $index; ?>][plan]">
                        <option value="monthly" <?php selected($record['plan'], 'monthly'); ?>>ماهانه</option>
                        <option value="quarterly" <?php selected($record['plan'], 'quarterly'); ?>>سه ماهه</option>
                        <option value="semiannual" <?php selected($record['plan'], 'semiannual'); ?>>سه ماهه</option>
                        <option value="yearly" <?php selected($record['plan'], 'yearly'); ?>>سالانه</option>
                    </select>
                </td>
                <td><button type="button" class="remove-record">❌</button></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <button type="button" id="add_spraying_record">➕ افزودن سمپاشی جدید</button>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const table = document.getElementById("spraying_records_table");
            const addButton = document.getElementById("add_spraying_record");

            addButton.addEventListener("click", function() {
                let rowCount = table.rows.length;
                let row = table.insertRow(-1);
                row.innerHTML = `
                    <td><input type="text" name="spraying_records[${rowCount}][type]" /></td>
                    <td><input type="text" name="spraying_records[${rowCount}][date]" /></td>
                    <td><input type="text" name="spraying_records[${rowCount}][price]" /></td>
                    <td>
                        <select name="spraying_records[${rowCount}][plan]">
                            <option value="ماهانه">ماهانه</option>
                            <option value="سه ماهه">سه ماهه</option>
                            <option value="شش ماهه">شش ماهه</option>
                            <option value="سالانه">سالانه</option>
                        </select>
                    </td>
                    <td><button type="button" class="remove-record">❌</button></td>
                `;
            });

            table.addEventListener("click", function(event) {
                if (event.target.classList.contains("remove-record")) {
                    event.target.closest("tr").remove();
                }
            });
        });
    </script>
    <?php
}
add_action('show_user_profile', 'add_custom_user_fields');
add_action('edit_user_profile', 'add_custom_user_fields');




function save_custom_user_fields($user_id) {
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_POST['spraying_records'])) {
        $spraying_records = array_values($_POST['spraying_records']); // بازسازی ایندکس‌های آرایه
        update_user_meta($user_id, 'spraying_records', $spraying_records);
    }
}
add_action('personal_options_update', 'save_custom_user_fields');
add_action('edit_user_profile_update', 'save_custom_user_fields');
