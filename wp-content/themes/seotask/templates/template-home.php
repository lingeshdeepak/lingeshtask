<?php
/*
Template Name: Home Page
*/

get_header();
?>

<main class="home-page">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <p class="subheading">Grow Your Business with</p>
                <p class="heading">Digital Marketing</p>
                <p class="description">Share processes and data secure lona need to know basis our
                team assured your web site is always safe and secure</p>
                <a href="#" class="btn btn-primary">Get Started</a>
            </div>
            <div class="hero-image">
                <img src="<?php echo get_template_directory_uri(); ?>/images/hero-image.png" alt="Hero Image">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <h2 class="centered-heading">Customers Win at Content Marketing <br> with <span style="color: #0c5adb;">SEO Platform</span></h2>
            <div class="features">
                <div class="feature">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/icon1.png" alt="Link Building">
                    <h3>Link Building</h3>
                    <p>Behind the word mountains, far from the countries Vokalia and Consonantia, there</p>
                </div>
                <div class="feature">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/icon2.png" alt="Monthly SEO Task">
                    <h3>Monthly SEO Task</h3>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there</p>
                </div>
                <div class="feature">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/icon3.png" alt="On Page SEO">
                    <h3>On Page SEO</h3>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <h2>Increase Your Client for <br><span style="color: #0c5adb;">Better </span> Position of Business</h2>
            <div class="row">
                <div class="col-6 left">
                    <div class="about-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/about.png" alt="Business Illustration">
                    </div>
                </div>
                <div class="col-6 right">
                    <p>Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
                    <ul style="padding-left: 0;">
                        <li><img src="<?php echo get_template_directory_uri(); ?>/images/Vector.png" alt="Checkmark" style="width:16px; height:16px; vertical-align:middle; margin-right:10px;"> Separated they live</li>
                        <li><img src="<?php echo get_template_directory_uri(); ?>/images/Vector.png" alt="Checkmark" style="width:16px; height:16px; vertical-align:middle; margin-right:10px;"> Grove right at</li>
                    </ul>
                    <ul>
                        <li><img src="<?php echo get_template_directory_uri(); ?>/images/Vector.png" alt="Checkmark" style="width:16px; height:16px; vertical-align:middle; margin-right:10px;"> The coast of the</li>
                        <li><img src="<?php echo get_template_directory_uri(); ?>/images/Vector.png" alt="Checkmark" style="width:16px; height:16px; vertical-align:middle; margin-right:10px;"> Semantics, a large</li>
                    </ul>
                    </br>
                    <a href="#" class="btn btn-primary">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Case Studies Section -->
    <section class="case-studies-section">
        <div class="container">
            <p>Previous Projects</p>
            <h2>Our Case Studies</h2>
            <?php echo do_shortcode('[case_studies_slider]'); ?>
        </div>
    </section>

    <!-- Case Studies Section -->
    <section class="client-section">
        <div class="container">
            <p>Clients Love</p>
            <h2>Love From Clients</h2>
           <img src="<?php echo get_template_directory_uri(); ?>/images/clientreview.png" alt="clients review" style="width:inherit; padding:50px 0 0;">
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <h2>Get In Touch</h2>
            <p>Far far away, behind the word mountains, far from the </br>
                countries Vokalia and Consonantia, there live the blind texts. </br>
                Separated they live in Bookmarksgrove right</p>
            <?php echo do_shortcode('[wpforms id="53" title="false"]'); ?>
        </div>
    </section>
</main>

<?php
get_footer();
?>
