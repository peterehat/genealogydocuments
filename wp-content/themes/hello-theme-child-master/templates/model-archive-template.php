<?php
/*
 * Template Name: Model Archive
 * description: >-
  Page template without sidebar
 */
get_header(); ?>
<style>
    model-viewer {
        --progress-bar-color: red;
    }

    .slider-nav {
        padding: 0px 58px;
    }

    .a-left {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
    }

    .a-right {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
    }

    .slider-detail {
        height: auto !important;
    }

    .object-detail-right {
        overflow-y: hidden;
    }

    .slider-detail .slick-slide {
        max-height: calc(100vh - 145px);
        overflow-y: auto;
    }

    .slider-detail .slick-slide {
        left: 0px !important;
        top: 0px !important;
        height: calc(100vh - 142px) !important;
        width: calc(100% - 30px) !important;
        position: absolute !important;
        padding: 15px;
    }

    .object-detail-right {
        padding: 0px;
    }

    .object-detail-right .slick-track {
        height: calc(100vh - 112px) !important;
        width: 100% !important;
        margin-top: 14px;
    }

    /***** updates chnages 23 AUG ********/
    .header-box {
        padding: 13px 20px;
    }

    .header-box .header-logo {
        width: 170px;
    }

    .object-detail-left {
        width: 100% !important;
        border-right: 0;
    }

    .object-detail-left .main {
        border-right: solid 2px #f1d9c0;
    }

    .object-detail-left .model-thumbnail img {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }

    .object-detail-left .model-thumbnail img {
        margin: 0 auto;
        height: 500px;
        object-fit: contain;
    }

    .slider-for {
        height: calc(100vh - 212px);
    }

    .slider-bottom img {
        height: 70px;
    }

    .slider-nav {
        height: auto;
    }

    .slider-nav .slick-slide {
        height: auto;
        padding-top: 15px;
        padding-bottom: 15px;
    }

    #lazy-load-poster {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        background-image: url("../../assets/poster-damagedhelmet.webp");
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
    }

    .button-load a {
        background-color: #000;
        color: white;
        cursor: pointer;
        border-radius: 6px;
        display: inline-block;
        padding: 10px 18px 10px 18px;
        font-weight: 500;
        box-shadow: 0 0 8px rgba(0, 0, 0, .2), 0 0 4px rgba(0, 0, 0, .25);
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate3d(-50%, -50%, 0);
        z-index: 100;
        text-decoration: none;
        text-transform: capitalize;
        width: 165px;
        text-align: center;
    }

    .object-detail-new{
        gap: 20px 70px;
    padding: 20px 70px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    }
    .thumb-grid{
        background: #f3f3f3;
    padding: 15px;
    text-align: center;
    }
    .grid-thumb-container{
        height:155px;
        width:auto;
}
    .thumb-grid img{
        width: 100%;
        height:100%;
        object-fit:contain;
        mix-blend-mode: multiply;
        transition: transform 0.3s ease;
    }
    .thumb-grid:hover img{
        transform: scale(1.1);
    }
    .thumb-grid a{
        color:#000;
        text-decoration:none;
    }

    @media(max-width:1200px) {
        .object-detail-new{
    grid-template-columns: repeat(3, 1fr);
    }
    }

    @media screen and (max-width: 1024px) {
        .object-detail-left {
            width: 100% !important;
        }

        .object-detail-right {
            width: 100% !important;
        }
        
    }

    @media(max-width:1023px) {
        .slider-detail .slick-slide {
            max-height: auto;
        }
        .object-detail-new{
    grid-template-columns: repeat(2, 1fr);
    }
    }

    @media(max-width:767px) {
        .object-detail-new{
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    }

.object-detail-new {
    padding: 20px;
}
    }

    @media(max-width:575px) {
        .object-detail-left .model-thumbnail img {
            width: 100%;
        }
    }
</style>
<header class="header-box">
    <div><a href="<?php echo esc_url(home_url('/')); ?>"><img class="header-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Logo.svg" /></a></div>
    <div><a href="<?php echo esc_url(home_url('/')); ?>" class="back-link"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/arrow.svg" /> Back</a></div>
</header>

<section class="object-detail-new">

<?php
                $args = array(
                    'post_type' => '3d_model',
                    'posts_per_page' => -1,
                    'order'    => 'ACS',
                    'post_status' => 'publish',
                );
                $models_query = new WP_Query($args);
                
                ?>


                <?php
                if ($models_query->have_posts()) :
                    while ($models_query->have_posts()) : $models_query->the_post(); ?>
                        <div class="thumb-grid">
                                <a href="<?php the_permalink(); ?>">
                                    <!-- Display Post Thumbnail and Title for Navigation -->
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="grid-thumb-container"><img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" alt="<?php the_title(); ?>" /></div>
                                    <?php endif; ?>
                                    <p><?php the_title(); ?></p> <!-- Display Post Title -->
                                    </a>
                                </div>
                <?php endwhile;
                    wp_reset_postdata();
                endif;
                ?>


</section>

<?php get_footer(); ?>