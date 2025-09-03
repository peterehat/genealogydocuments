<?php
/*
 * Template Name: Tree Page
 * description: >-
  Page template without sidebar
 */

 get_header(); ?>

<header class="header-box">
        <div><a href="<?php echo esc_url(home_url('/')); ?>"><img class="header-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Logo.svg" /></a></div>
        <div><a href="<?php echo esc_url(home_url('/')); ?>" class="back-link"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/arrow.svg" /> Back</a></div>
    </header>

<div class="container">
<?php
$page_id = get_queried_object_id(); 
$content_post = get_post($page_id); 
$content = apply_filters('the_content', $content_post->post_content); 

echo $content; 
?>
</div>
 <?php get_footer(); ?>

