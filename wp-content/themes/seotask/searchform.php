<form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
    <label>
        <span class="screen-reader-text"><?php _e('Search for:', 'custom-theme'); ?></span>
        <input type="search" class="search-field" placeholder="<?php _e('Search...', 'custom-theme'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
    </label>
    <button type="submit" class="search-submit"><?php _e('Search', 'custom-theme'); ?></button>
</form>
