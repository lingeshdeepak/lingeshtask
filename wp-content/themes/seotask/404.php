<?php
get_header();
?>
<main class="error-404">
    <h1><?php esc_html_e('Oops! That page can’t be found.', 'custom-theme'); ?></h1>
    <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try a search?', 'custom-theme'); ?></p>
    <?php get_search_form(); ?>
    <a href="<?php echo home_url(); ?>" class="btn btn-primary"><?php esc_html_e('Back to Home', 'custom-theme'); ?></a>
</main>
<?php
get_footer();
?>
