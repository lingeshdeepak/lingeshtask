<?php
get_header();
?>
<main>
    <h1>Welcome to <?php bloginfo('name'); ?></h1>
    <p><?php bloginfo('description'); ?></p>
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
