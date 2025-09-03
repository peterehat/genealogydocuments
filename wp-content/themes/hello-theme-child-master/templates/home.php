<?php
/*
 * Template Name: Home HTML
 * description: >-
  Page template without sidebar
 */

 get_header(); ?>

<?php
$main_heading = get_field('main_heading');
$sub_heading = get_field('sub_heading');

$elizabeth_photo = get_field('elizabeth_photo');
$elizabeth_details = get_field('elizabeth_details');
$elizabeth_link = get_field('elizabeth_link');

$family_tree_text = get_field('family_tree_text');
$family_tree = get_field('family_tree');
$family_tree_link = get_field('family_tree_link');

$map_heading = get_field('map_heading');
$map_sub_heading = get_field('map_sub_heading');
$map_photo = get_field('map_photo');
?>
<style>
    @media(max-width:1023px){
        .home-page-content {
        height: auto;
    }
    .home-page-content-inner{
        position:relative !important;
    }
    .home-header{
        margin-bottom:50px;
    }
    }
</style>

<div class="home-page-container">
        <div class="home-page-content">
            <div class="video-bg">
            <video class="header-banner-video" autoplay muted loop playsinline>
    <source src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/video-bg-1920.mp4" type="video/mp4">
    Your browser does not support HTML5 video.
</video>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var videoElements = document.querySelectorAll('video');

        videoElements.forEach(function(videoElement) {
            videoElement.controls = false;

            videoElement.addEventListener('play', function () {
                this.controls = false;
            });

            videoElement.addEventListener('pause', function () {
                this.controls = false;
            });
        });
    });
</script>
            </div>
            <div class="home-page-content-inner">
                <div class="container">
                    <div class="home-header">
                    <?php echo '<h1>' . $main_heading . '</h1>'; ?>
                    <?php echo '<p>' . $sub_heading . '</p>'; ?>
                    </div>
                    <div class="home-placeholders-box">
                        <div class="home-placeholders-box-inner">                        
                            <a href="<?php echo $elizabeth_link ?>">
                            <div class="home-placeholders-box-photo">
                            <?php
                                if($elizabeth_photo) {
                                    echo '<img src="' . $elizabeth_photo . '" alt="">';
                                }
                                ?>
                            </div>
                            <?php echo '<p>' . $elizabeth_details . '</p>'; ?>
                        </a>
                        </div>
                        <div class="home-placeholders-box-inner">
                            <a href="<?php echo $family_tree_link ?>">
                            <div class="home-placeholders-box-photo">
                                <?php
                                if($family_tree) {
                                    echo '<img class="tree-pic" src="' . $family_tree . '" alt="">';
                                }
                                ?>
                            </div>
                            <?php echo '<p>' . $family_tree_text . '</p>'; ?>
                        </a>
                        </div>
                    </div>
                    </div>
            </div>
        </div>
        <div class="map-box">
            <div class="container">
                <?php echo '<h2>' . $map_heading . '</h2>'; ?>
                <?php echo '<p>' . $map_sub_heading . '</p>'; ?>
                <?php
                                if($map_photo) {
                                    echo '<img class="map-img" src="' . $map_photo . '" alt="">';
                                }
                                ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>