<?php
get_header();
?>

<section class="case-study-header">
    <div class="container" style="text-align: justify;">
        <?php
            if ( single_term_title('', false) ) {
                echo '<h3>' . single_term_title('', false) . '</h3>';
            } else {
                echo '<h3>Case Study</h3>';
            }
        ?>
        <p class="breadcrumb">
            <a href="<?php echo home_url(); ?>">Home</a> /  
            <a href="<?php echo get_post_type_archive_link('case_studies'); ?>"> Case Study</a> 
            <?php
                if ( single_term_title('', false) ) {
                    echo '/' . single_term_title('', false);
                }
            ?>
        </p>
    </div>
</section>

<section class="case-study-filters">
    <div class="container">
        <ul class="filters">
            <li><a href="<?php echo get_post_type_archive_link('case_studies'); ?>" class="filter-link <?php if (!is_tax()) echo 'active'; ?>">All</a></li>
            <?php
            $categories = get_terms('case_study_category');
            foreach ($categories as $category) {
                echo '<li><a href="' . get_term_link($category) . '" class="filter-link ' . (is_tax('case_study_category', $category->slug) ? 'active' : '') . '">' . $category->name . '</a></li>';
            }
            ?>
        </ul>
    </div>
</section>

<section class="case-study-listing">
    <div class="container">
        <div class="row">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <div class="col-md-4">
                        <div class="case-study-card">
                            <div class="card-image">
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>" class="img-fluid">
                                </a>
                            </div>
                            <div class="card-content">
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
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
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <p>No case studies found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
get_footer();
?>
