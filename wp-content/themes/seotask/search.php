<?php
get_header();
?>
<main class="search-results">
    <div class="container">
        <h1>
            <?php
            printf(
                esc_html__('Search Results for: %s', 'custom-theme'),
                '<span>' . get_search_query() . '</span>'
            );
            ?>
        </h1>

        <?php if (have_posts()) : ?>
            <div class="posts">
                <?php
                while (have_posts()) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <div class="excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    </article>
                    <?php
                endwhile;
                ?>
            </div>

            <div class="pagination">
                <?php
                the_posts_pagination(array(
                    'prev_text' => __('Previous', 'custom-theme'),
                    'next_text' => __('Next', 'custom-theme'),
                ));
                ?>
            </div>

        <?php else : ?>
            <div class="no-results">
                <h2><?php esc_html_e('No results found', 'custom-theme'); ?></h2>
                <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'custom-theme'); ?></p>
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php
get_footer();
?>
