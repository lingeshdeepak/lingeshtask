<?php
// Add theme support
function custom_theme_setup() {
    add_theme_support('title-tag'); // Dynamic <title> tags
    add_theme_support('post-thumbnails'); // Featured images
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'custom-theme'),
    ));
}
add_action('after_setup_theme', 'custom_theme_setup');

// Enqueue styles and scripts
function custom_theme_scripts() {
    wp_enqueue_style('theme-style', get_stylesheet_uri());

    wp_enqueue_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js', array(), null, true);

	wp_enqueue_script(
        'menu-toggle',
        get_template_directory_uri() . '/js/menutoggle.js',
        array(),
        null,
        true
    );

    wp_enqueue_script('js-script', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.0', true);

    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css', array(), null);

    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'custom_theme_scripts');

function custom_theme_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'custom-theme'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here.', 'custom-theme'),
        'before_widget' => '<div class="widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'custom_theme_widgets_init');

function create_case_studies_post_type() {
    $labels = array(
        'name'               => 'Case Studies',
        'singular_name'      => 'Case Study',
        'menu_name'          => 'Case Studies',
        'name_admin_bar'     => 'Case Study',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Case Study',
        'new_item'           => 'New Case Study',
        'edit_item'          => 'Edit Case Study',
        'view_item'          => 'View Case Study',
        'all_items'          => 'All Case Studies',
        'search_items'       => 'Search Case Studies',
        'not_found'          => 'No Case Studies found.',
        'not_found_in_trash' => 'No Case Studies found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'case-studies'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'taxonomies'         => array('case_study_category'), // Link taxonomy
        'has_archive'        => true,
        'show_in_rest'       => true, // Enable Gutenberg editor
    );

    register_post_type('case_studies', $args);
}
add_action('init', 'create_case_studies_post_type');

function create_case_study_taxonomy() {
    $labels = array(
        'name'              => 'Case Study Categories',
        'singular_name'     => 'Case Study Category',
        'search_items'      => 'Search Case Study Categories',
        'all_items'         => 'All Case Study Categories',
        'parent_item'       => 'Parent Category',
        'parent_item_colon' => 'Parent Category:',
        'edit_item'         => 'Edit Category',
        'update_item'       => 'Update Category',
        'add_new_item'      => 'Add New Category',
        'new_item_name'     => 'New Category Name',
        'menu_name'         => 'Categories',
    );

    $args = array(
        'hierarchical'      => true, // Makes it act like categories
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'case-study-category'),
    );

    register_taxonomy('case_study_category', array('case_studies'), $args);
}
add_action('init', 'create_case_study_taxonomy');

function display_case_studies_with_scroll($atts) {
    // Set default attributes
    $atts = shortcode_atts(
        array(
            'posts_per_page' => 2, // Number of case studies to display
        ),
        $atts
    );

    // Query for case studies
    $query = new WP_Query(array(
        'post_type' => 'case_studies', // Your custom post type
        'posts_per_page' => $atts['posts_per_page'],
    ));

    // Start output buffering
    ob_start();

    if ($query->have_posts()) {
        // HTML Structure for scrollable case studies
        ?>
        <div class="case-studies-slider">
            <div class="slider-container">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <div class="case-study-card">
                        <div class="card-image">
                            <a href="<?php the_permalink(); ?>">
                                <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" alt="<?php the_title(); ?>" class="img-fluid">
                            </a>
                        </div>
                        <div class="card-content">
                            <h3><?php the_title(); ?></h3>
                            <p>
                                <?php
                                $terms = get_the_terms(get_the_ID(), 'case_study_category');
                                if ($terms) {
                                    echo implode(', ', wp_list_pluck($terms, 'name'));
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="slider-dots"></div>
        </div>

        <?php
    } else {
        echo '<p>No case studies found.</p>';
    }

    // Reset post data
    wp_reset_postdata();

    // Return the buffered content
    return ob_get_clean();
}
add_shortcode('case_studies_slider', 'display_case_studies_with_scroll');
