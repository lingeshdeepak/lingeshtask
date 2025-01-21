<?php
// CSV Import Functionality
add_action('admin_menu', 'rps_add_admin_menu');
function rps_add_admin_menu() {
    add_submenu_page(
        'edit.php?post_type=program',
        'Import CSV',
        'Import CSV',
        'manage_options',
        'import-csv',
        'rps_import_csv_page'
    );
}

function rps_import_csv_page() {
    if (isset($_POST['rps_upload_csv'])) {
        rps_handle_csv_import();
    }
    echo '<form method="post" enctype="multipart/form-data">
            <input type="file" name="csv_file" required>
            <button type="submit" name="rps_upload_csv">Import CSV</button>
          </form>';
}

function rps_handle_csv_import() {
    if (!isset($_FILES['csv_file'])) {
        echo 'No file uploaded.';
        return;
    }

    $file = fopen($_FILES['csv_file']['tmp_name'], 'r');
    $header = fgetcsv($file);
    while ($row = fgetcsv($file)) {
        $data = array_combine($header, $row);
        $post_id = wp_insert_post([
            'post_title' => $data['Program Name'],
            'post_content' => $data['Program Description'],
            'post_type' => 'program',
            'post_status' => 'publish',
        ]);

        update_post_meta($post_id, '_rps_start_date', $data['Program Start Date']);
        update_post_meta($post_id, '_rps_end_date', $data['Program End Date']);
        update_post_meta($post_id, '_rps_broadcast_schedule', json_decode($data['Broadcast Schedule'], true));

        if ($data['Program Thumbnail']) {
            $attachment_id = media_sideload_image($data['Program Thumbnail'], $post_id, null, 'id');
            set_post_thumbnail($post_id, $attachment_id);
        }
    }

    fclose($file);
    echo 'CSV imported successfully.';
}
?>