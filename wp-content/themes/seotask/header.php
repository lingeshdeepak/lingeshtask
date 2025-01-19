<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="site-header">
    <div class="container">
        <div class="logo">
            <a href="<?php echo home_url(); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Site Logo">
            </a>
        </div>
        <nav class="main-navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class' => 'menu',
            ));
            ?>
        </nav>
        <!-- Search Icon -->
        <div class="search-icon">
            <button id="search-toggle" aria-label="Toggle Search">
                <span class="dashicons dashicons-search"></span>
            </button>
        </div>
    </div>

    <!-- Hidden Search Form -->
    <div id="search-bar" class="search-bar">
        <?php get_search_form(); ?>
    </div>
</header>
