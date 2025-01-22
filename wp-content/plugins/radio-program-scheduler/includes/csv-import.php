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

    echo '<div class="wrap" style="padding: 20px;font-size: 16px;">';
    echo '<h1>Boardcast Schedule</h1>';
    echo '<p>Use the form below to import a CSV file with program data.</p>';
    echo '<div style="border: 1px solid #ccc; padding: 20px; margin-top: 20px;">';
    echo '<form method="post" enctype="multipart/form-data">
            <input type="file" name="csv_file" required>
            <button type="submit" name="rps_upload_csv">Import CSV</button>
          </form>';
    echo '</div>';
    echo '</div>';
}

function get_existing_program_post_id($program_name) {
    $query = new WP_Query([
        'post_type'      => 'program',
        'post_status'    => 'publish',
        'title'          => $program_name,
        'posts_per_page' => 1,
        'fields'         => 'ids', // Only return post IDs for performance
    ]);

    return !empty($query->posts) ? $query->posts[0] : false;
}

function rps_handle_csv_import() {
    if (!isset($_FILES['csv_file'])) {
        echo 'No file uploaded.';
        return;
    }

    $file = fopen($_FILES['csv_file']['tmp_name'], 'r');
    $header = fgetcsv($file); // Read the CSV header

    while ($row = fgetcsv($file)) {
        $data = array_combine($header, $row);

        // Check if a post with the same program name exists
        $post_id = get_existing_program_post_id($data['Program Name']);

        if ($post_id) {
            // Update the existing post
            wp_update_post([
                'ID'           => $post_id,
                'post_content' => $data['Program Description'],
            ]);
        } else {
            // Create a new post
            $post_id = wp_insert_post([
                'post_title'   => $data['Program Name'],
                'post_content' => $data['Program Description'],
                'post_type'    => 'program',
                'post_status'  => 'publish',
            ]);
        }

        // Update or add meta fields
        update_post_meta($post_id, '_rps_start_date', $data['Program Start Date']);
        update_post_meta($post_id, '_rps_end_date', $data['Program End Date']);
        update_post_meta($post_id, '_rps_broadcast_schedule', json_decode($data['Broadcast Schedule'], true));

        // Handle the featured image
        $thumbnail_url = !empty($data['Program Thumbnail']) ? $data['Program Thumbnail'] : 'https://picsum.photos/200/300';
        $attachment_id = rps_upload_image_from_url($thumbnail_url, $post_id);
        if ($attachment_id) {
            delete_post_thumbnail($post_id); // Remove existing image
            set_post_thumbnail($post_id, $attachment_id); // Set the new image
        }
    }

    fclose($file);
    echo 'CSV imported successfully.';
}


//Helper function to upload an image from URL
function rps_upload_image_from_url($image_url, $post_id) {
    // Validate the URL
    if (!filter_var($image_url, FILTER_VALIDATE_URL)) {
        error_log('Invalid URL: ' . $image_url);
        return false;
    }

    // Download the image
    $temp_file = download_url($image_url);
    if (is_wp_error($temp_file)) {
        error_log('Failed to download image: ' . $image_url . ' - Error: ' . $temp_file->get_error_message());
        return false;
    }

    // Prepare file array for sideloading
    $file_array = [
        'name'     => basename($image_url),
        'tmp_name' => $temp_file,
    ];

    // Include WordPress file functions
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    // Sideload the image
    $attachment_id = media_handle_sideload($file_array, $post_id);

    // Check for errors
    if (is_wp_error($attachment_id)) {
        @unlink($temp_file); // Clean up the temporary file
        error_log('Failed to sideload image: ' . $image_url . ' - Error: ' . $attachment_id->get_error_message());
        return false;
    }

    // Clean up the temporary file
    @unlink($temp_file);

    return $attachment_id;
}


?>