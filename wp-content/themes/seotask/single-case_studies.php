<?php
get_header();
?>

<div class="single-case-study">
    <div>
        <?php while ( have_posts() ) : the_post(); ?>
            <!-- Hero Section -->
            <div class="case-study-hero" style="background-color: #0056b3; padding: 30px 0; color: white;">
                <div class="container">
                    <h1 class="case-study-title"><?php the_title(); ?></h1>
                    <p class="case-study-breadcrumb">
                        <a href="<?php echo get_permalink(get_option('page_on_front')); ?>" style="color: #fff;">Home</a> /
                        <a href="<?php echo get_post_type_archive_link('case_studies'); ?>" style="color: #fff;">Case Study</a> / <?php the_title(); ?>
                    </p>
                </div>
            </div>

            <!-- Info Section -->
            <div class="case-study-info" style="padding: 100px;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Info</h3>
                            <p><strong>Category:</strong> <?php the_terms( get_the_ID(), 'case_study_category', '', ', ' ); ?></p>
                           <?php $client = get_post_meta(get_the_ID(), 'client_name', true);
                                if ($client) {
                                    echo '<p><strong>Client:</strong> ' . esc_html($client) . '</p>';
                                }

                                // Get the published date
                                $date = get_the_date();
                                echo '<p><strong>Date:</strong> ' . esc_html($date) . '</p>';
                                ?>
                            <!-- <p><strong>Date:</strong> <?php echo get_the_date(); ?></p>
                            <p><strong>Client:</strong> <?php echo get_post_meta( get_the_ID(), 'client_name', true ); ?></p> -->
                        </div>
                        <div class="col-md-6">
                            <div class="case-study-image">
                                <?php if ( has_post_thumbnail() ) {
                                    the_post_thumbnail( 'medium_large', array( 'class' => 'img-fluid' ) );
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Brief -->
            <div class="case-study-content" style="padding: 20px 0;">
                <div class="container">
                    <h2>Project Brief:</h2>
                    <div class="content">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>

            <!-- Bullet Points Section -->
            <div class="case-study-bullets">
                <div class="container">
                    <ul class="row">
                        <div class="col-md-4">
                            <li><img src="<?php echo get_template_directory_uri(); ?>/images/Vector.png" alt="Check"> Separated they live in Bookmarksgrove</li>
                            <li><img src="<?php echo get_template_directory_uri(); ?>/images/Vector.png" alt="Check"> Right at the coast of</li>
                            <li><img src="<?php echo get_template_directory_uri(); ?>/images/Vector.png" alt="Check"> The Semantics</li>
                            <li><img src="<?php echo get_template_directory_uri(); ?>/images/Vector.png" alt="Check"> A large language ocean.</li>
                        </div>
                        <div class="col-md-4">
                            <li><img src="<?php echo get_template_directory_uri(); ?>/images/Vector.png" alt="Check"> The Semantics</li>
                            <li><img src="<?php echo get_template_directory_uri(); ?>/images/Vector.png" alt="Check"> A large language ocean</li>
                            <li><img src="<?php echo get_template_directory_uri(); ?>/images/Vector.png" alt="Check"> Separated they live in Bookmarksgrove</li>
                            <li><img src="<?php echo get_template_directory_uri(); ?>/images/Vector.png" alt="Check"> Right at the coast of</li>
                        </div>
                        <div class="col-md-4">
                            <li><img src="<?php echo get_template_directory_uri(); ?>/images/Vector.png" alt="Check"> Separated they live in Bookmarksgrove</li>
                            <li><img src="<?php echo get_template_directory_uri(); ?>/images/Vector.png" alt="Check"> Right at the coast of</li>
                            <li><img src="<?php echo get_template_directory_uri(); ?>/images/Vector.png" alt="Check"> The Semantics</li>
                            <li><img src="<?php echo get_template_directory_uri(); ?>/images/Vector.png" alt="Check"> A large language ocean</li>
                        </div>
                    </ul>
                </div>
            </div>

        <?php endwhile; ?>
    </div>
</div>


<?php
get_footer();
?>
