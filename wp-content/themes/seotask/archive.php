<?php
get_header();
?>
<main>
    <h1>
        <?php
        if (is_category()) {
            single_cat_title('Category: ');
        } elseif (is_tag()) {
            single_tag_title('Tag: ');
        } elseif (is_author()) {
            the_author();
        } elseif (is_year()) {
            echo 'Year: ' . get_the_date('Y');
        } elseif (is_month()) {
            echo 'Month: ' . get_the_date('F Y');
        } elseif (is_day()) {
            echo 'Day: ' . get_the_date('F j, Y');
        } else {
            esc_html_e('Archives', 'custom-theme');
        }
        ?>
    </h1>
    <div class="posts">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                ?>
                <article>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div><?php the_excerpt(); ?></div>
                </article>
                <?php
            endwhile;
        else :
            echo '<p>No posts found.</p>';
        endif;
        ?>
    </div>
</main>
<?php
get_footer();
?>
