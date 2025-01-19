<aside id="secondary" class="widget-area">
    <?php
    if (is_active_sidebar('sidebar-1')) :
        dynamic_sidebar('sidebar-1');
    else :
        ?>
        <div class="widget">
            <h2 class="widget-title"><?php esc_html_e('Search', 'custom-theme'); ?></h2>
            <?php get_search_form(); ?>
        </div>
        <div class="widget">
            <h2 class="widget-title"><?php esc_html_e('Recent Posts', 'custom-theme'); ?></h2>
            <ul>
                <?php
                wp_get_archives(array(
                    'type' => 'postbypost',
                    'limit' => 5,
                ));
                ?>
            </ul>
        </div>
        <?php
    endif;
    ?>
</aside>
