<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo("charset"); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?php echo esc_url(home_url("/")); ?>/wp-content/themes/hello-theme-child-master/assets/images/favicon.jpg">
    <link rel="stylesheet" href="<?php echo esc_url(home_url("/")); ?>/wp-content/themes/hello-theme-child-master/assets/dist/main.min.css">
    <title><?php wp_title(""); ?></title>
</head>

<body>
    <style>
        model-viewer {
            --progress-bar-color: red;
        }

        .slider-nav {
            padding: 0px 58px;
            position: relative;
        }

        .slider-nav .swiper-slide {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Hide Swiper's default navigation buttons */
        .swiper-button-next,
        .swiper-button-prev {
            display: none !important;
        }

        .a-left {
            position: absolute;
            left: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: #df2f2f;
            color: white;
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            font-size: 16px;
            cursor: pointer;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .a-right {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: #df2f2f;
            color: white;
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            font-size: 16px;
            cursor: pointer;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .slider-detail {
            height: auto !important;
        }

        .header-box {
            padding: 13px 20px;
            position: relative;
            z-index: 999999;
        }

        .header-box .header-logo {
            width: 170px;
        }

        .object-detail {
            height: calc(100vh - 63px);
        }

        .object-detail-left {
            width: calc(100% - 400px) !important;
            border-right: 0;
            overflow: hidden;
        }

        .object-detail-right {
            width: 400px !important;
            border-left: solid 2px #f1d9c0;
            padding: 0px;
            overflow-y: hidden;
        }

        .slider.slider-for.slider-detail {
            padding: 15px;
            height: calc(100vh - 112px) !important;
            margin-top: 14px;
            overflow: auto;
        }

        #threejs-container {
            width: 100%;
            height: calc(100vh - 282px);
            position: relative;
            overflow: hidden;
            background-color: white;
        }

        #threejs-container canvas {
            display: block;
            background-color: white;
            width: 100% !important;
            height: 100% !important;
        }

        .slider-bottom a {
            height: 110px;
            width: auto;
            display: block;
            padding-bottom: 15px;
        }

        /* Desktop carousel - show only on desktop */
        .slider-nav.desktop {
            display: block;
        }
        
        /* Mobile carousel - hide on desktop */
        .slider-nav.mobile {
            display: none;
        }
        
        /* Simple mobile carousel - hide on desktop */
        .simple-mobile-carousel {
            display: none;
        }

        /* Mobile carousel optimizations */
        @media screen and (max-width: 1024px) {
            /* Hide desktop carousel on mobile */
            .slider-nav.desktop {
                display: none !important;
            }
            
            .slider-bottom a {
                height: 50px !important;
                width: 50px !important;
                padding-bottom: 4px;
                margin: 0 auto;
            }
            
            .slider-bottom p {
                display: none;
            }
            
            .slider-nav.mobile {
                padding: 4px 8px;
                max-height: 70px !important;
                display: flex !important;
                align-items: center !important;
                visibility: visible !important;
                position: relative;
                background-color: #f9f9f9;
                border-top: 1px solid #ddd;
                border-bottom: 1px solid #ddd;
                z-index: 10;
                margin: 0;
                min-height: 70px !important;
            }
            
            /* Show mobile carousel on mobile */
            .simple-mobile-carousel {
                display: flex !important;
            }
            
            .slider-nav.mobile .swiper-slide {
                padding: 0 2px !important;
                width: 60px !important;
                height: 60px !important;
                display: flex !important;
                flex-direction: column !important;
                justify-content: center !important;
                align-items: center !important;
                visibility: visible !important;
            }
            
            .slider-nav.mobile .swiper-wrapper {
                display: flex !important;
                align-items: flex-end !important;
                justify-content: center !important;
                height: 60px !important;
                visibility: visible !important;
                padding-bottom: 5px;
            }
            
            .slider-nav.mobile .slider-bottom {
                visibility: visible !important;
            }
            
            .slider-nav.mobile .slider-bottom a {
                visibility: visible !important;
            }
            
            .slider-nav.mobile .slider-bottom img {
                visibility: visible !important;
                display: block !important;
            }
            
            /* Clean mobile carousel styling */
            .slider-nav.mobile {
                min-height: 80px !important;
            }
            
            /* Prevent Swiper from hiding slides - more aggressive */
            .slider-nav.mobile .swiper-slide.swiper-slide-hidden {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
            
            .slider-nav.mobile .swiper-slide.swiper-slide-duplicate {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
            
            .slider-nav.mobile .swiper-slide[style*="display: none"] {
                display: flex !important;
            }
            
            .slider-nav.mobile .swiper-slide[style*="visibility: hidden"] {
                visibility: visible !important;
            }
            
            .slider-nav.mobile .swiper-slide[style*="opacity: 0"] {
                opacity: 1 !important;
            }
            
            /* Override any Swiper inline styles */
            .slider-nav.mobile .swiper-slide[style] {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
            
            /* More aggressive overrides for all possible Swiper states */
            .slider-nav.mobile .swiper-slide,
            .slider-nav.mobile .swiper-slide.swiper-slide-active,
            .slider-nav.mobile .swiper-slide.swiper-slide-next,
            .slider-nav.mobile .swiper-slide.swiper-slide-prev,
            .slider-nav.mobile .swiper-slide.swiper-slide-duplicate,
            .slider-nav.mobile .swiper-slide.swiper-slide-duplicate-active,
            .slider-nav.mobile .swiper-slide.swiper-slide-duplicate-next,
            .slider-nav.mobile .swiper-slide.swiper-slide-duplicate-prev {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                transform: none !important;
            }
        }

        /* Simple Mobile Carousel - Clean Implementation */
        @media screen and (max-width: 1024px) {
            .simple-mobile-carousel {
                display: flex;
                align-items: center;
                position: relative;
                background-color: #f9f9f9;
                border-top: 1px solid #ddd;
                border-bottom: 1px solid #ddd;
                padding: 8px 50px;
                height: 70px;
                overflow: hidden;
            }
            
            .carousel-container {
                display: flex;
                gap: 8px;
                overflow-x: auto;
                scroll-behavior: smooth;
                flex: 1;
                scrollbar-width: none;
                -ms-overflow-style: none;
            }
            
            .carousel-container::-webkit-scrollbar {
                display: none;
            }
            
            .carousel-item {
                flex-shrink: 0;
                width: 60px;
                height: 60px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .carousel-item a {
                display: block;
                width: 100%;
                height: 100%;
            }
            
            .carousel-item img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 4px;
            }
            
            .carousel-item.current-item {
                border: 2px solid #df2f2f;
                border-radius: 4px;
            }
            
            .carousel-prev,
            .carousel-next {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                background: #df2f2f;
                color: white;
                border: none;
                border-radius: 50%;
                width: 35px;
                height: 35px;
                font-size: 16px;
                cursor: pointer;
                z-index: 10;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .carousel-prev {
                left: 8px;
            }
            
            .carousel-next {
                right: 8px;
            }
        }

        /* Extra small mobile devices */
        @media screen and (max-width: 480px) {
            .slider-bottom a {
                height: 45px !important;
                width: 45px !important;
                padding-bottom: 3px;
                margin: 0 auto;
            }
            
            .slider-bottom p {
                display: none;
            }
            
            .slider-nav.mobile {
                padding: 3px 6px;
                max-height: 60px !important;
                display: flex !important;
                align-items: center !important;
                visibility: visible !important;
            }
            
            .slider-nav.mobile .swiper-slide {
                padding: 0 1px !important;
                width: 50px !important;
                height: 50px !important;
                display: flex !important;
                flex-direction: column !important;
                justify-content: center !important;
                align-items: center !important;
                visibility: visible !important;
            }
            
            .slider-nav.mobile .swiper-wrapper {
                display: flex !important;
                align-items: flex-end !important;
                justify-content: center !important;
                height: 50px !important;
                visibility: visible !important;
                padding-bottom: 3px;
            }
        }

        .slider-bottom a img {
            margin: 0 auto;
            width: 100%;
            height: 100%;
            object-fit: contain;
            mix-blend-mode: multiply;
            transition: transform 0.3s ease;
        }

        .slider-bottom:hover a img {
            transform: scale(1.1);
        }
        .object-detail-right h2{
            font-size:30px;
        }
        .object-detail-right h4 {
            font-size: 16px;
            margin-bottom: 6px;
            margin-top: 10px;
        }
        .slider-nav.desktop {
            display: block;
        }
        .slider-nav.mobile {
            display: none;
        }

        @media screen and (max-width: 1024px) {

            .slider-nav.desktop {
                display: none !important;
            }
            .slider-nav.mobile {
                display: block !important;
                visibility: visible !important;
            }
            .object-detail-left {
                width: 100% !important;
            }

            /* #threejs-container {
                height: 100%;
            } */
            /* 
            #threejs-container canvas {
                height: 650px !important;
            } */

            .object-detail-right {
                border-top: solid 2px #f1d9c0;
                position: relative;
                background-color: #fff;
                width: 100% !important;
                max-height: calc(100vh - 60vh);
                overflow-y: auto;
                margin-top: 0;
                margin-bottom: 0;
            }

            .slider.slider-for.slider-detail {
                overflow: unset;
            }
        }

        .slider-detail a {
            color: #df2f2f;
        }

        @media(max-width:1024px) {
            .slider-detail .slick-slide {
                max-height: auto;
            }

            #threejs-container {
                width: 100%;
                height: calc(100vh - 180px);
                position: relative;
                overflow: hidden;
                background-color: white;
                margin-bottom: 0;
            }
            .object-detail{
                flex-wrap:wrap;
                height: auto;
            }
            .object-detail-right {
                border-top: solid 2px #f1d9c0;
            }
            .slider.slider-for.slider-detail {
                overflow: unset;
                height: auto !important;
            }
        }
    </style>
    <header class="header-box">
        <div><a href="<?php echo esc_url(home_url("/")); ?>"><img class="header-logo"src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Logo.svg" /></a></div>
        <div><a href="<?php echo esc_url(home_url('/three-dimensional-scans/')); ?>" class="back-link"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/arrow.svg" />Back</a></div>
    </header>
    <section class="object-detail">
        <div class="object-detail-left">
            <div class="main">
                <div class="">
                    <div id="threejs-container"></div>
                    <?php
                        $args = [
                            "post_type"      => "3d_model",
                            "posts_per_page" => -1,
                            "order"          => "ASC",
                            "post_status"    => "publish",
                        ];
                        $models_query = new WP_Query($args);
                        $current_post_id = get_the_ID();
                    ?>
                    <div class="swiper slider-nav desktop" style="visibility:hidden;">
                        <div class="swiper-wrapper">
                            <?php if ($models_query->have_posts()): ?>
                                <?php while ($models_query->have_posts()): $models_query->the_post(); ?>
                                    <?php 
                                        $post_id = get_the_ID();
                                        $active_class = ($post_id == $current_post_id) ? ' current-slick' : ''; 
                                    ?>
                                    <div class="swiper-slide<?php echo esc_attr($active_class); ?>" data-post-id="<?php echo esc_attr($post_id); ?>">
                                        <div class="slider-bottom">
                                            <?php if (has_post_thumbnail()): ?>
                                                <a href="<?php the_permalink(); ?>">
                                                    <img src="<?php echo esc_url(get_the_post_thumbnail_url(null, "full")); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
                                                </a>
                                            <?php endif; ?>
                                            <p><?php the_title(); ?></p>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                                <?php wp_reset_postdata(); ?>
                            <?php endif; ?>
                        </div>
                        <button class="a-left control-c prev">←</button>
                        <button class="a-right control-c next">→</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="object-detail-right">
            <?php
                $args = [
                    "post_type"      => "3d_model",
                    "posts_per_page" => -1,
                    "order"          => "ASC",
                    "post_status"    => "publish",
                ];
                $models_query = new WP_Query($args);
                $current_post_id = get_the_ID();
            ?>
            <div class="simple-mobile-carousel" style="visibility:hidden;">
                <div class="carousel-container">
                    <?php if ($models_query->have_posts()): ?>
                        <?php while ($models_query->have_posts()): $models_query->the_post(); ?>
                            <?php 
                                $post_id = get_the_ID();
                                $active_class = ($post_id == $current_post_id) ? ' current-item' : ''; 
                            ?>
                            <div class="carousel-item<?php echo esc_attr($active_class); ?>" data-post-id="<?php echo esc_attr($post_id); ?>">
                                <?php if (has_post_thumbnail()): ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(null, "medium")); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    <?php endif; ?>
                </div>
                <button class="carousel-prev">←</button>
                <button class="carousel-next">→</button>
            </div>
            <div class="slider slider-for slider-detail">
                <div>
                    <h2><?php the_title(); ?></h2>
                    <div class="content-scroll">
                        <?php if (have_rows("three_dimensional_object_details_section")): ?>
                        <?php while (have_rows("three_dimensional_object_details_section")): the_row(); ?>
                            <div>
                                <h4><?php the_sub_field("three_dimensional_object_details_sub_title"); ?></h4>
                                <p><?php the_sub_field("three_dimensional_object_details_sub_detail"); ?></p>
                            </div>
                        <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/build/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/DRACOLoader.js"></script>
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Swiper for desktop
        const desktopSwiper = new Swiper('.slider-nav.desktop', {
            slidesPerView: 4,
            spaceBetween: 10,
            navigation: false,
            breakpoints: {
                1025: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                },
                480: {
                    slidesPerView: 3,
                }
            }
        });

        // Simple mobile carousel functionality
        function initSimpleCarousel() {
            const carousel = document.querySelector('.simple-mobile-carousel');
            const container = carousel?.querySelector('.carousel-container');
            const prevBtn = carousel?.querySelector('.carousel-prev');
            const nextBtn = carousel?.querySelector('.carousel-next');
            
            if (!carousel || !container || !prevBtn || !nextBtn) {
                console.log('Simple carousel elements not found');
                return;
            }
            
            console.log('Initializing simple carousel');
            carousel.style.visibility = 'visible';
            
            // Center current item
            const currentItem = container.querySelector('.current-item');
            if (currentItem) {
                currentItem.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }
            
            // Navigation
            prevBtn.addEventListener('click', () => {
                container.scrollBy({ left: -70, behavior: 'smooth' });
            });
            
            nextBtn.addEventListener('click', () => {
                container.scrollBy({ left: 70, behavior: 'smooth' });
            });
        }

        // Initialize everything
        setTimeout(() => {
            // Show desktop carousel
            const desktopCarousel = document.querySelector('.slider-nav.desktop');
            if (desktopCarousel) {
                desktopCarousel.style.visibility = 'visible';
            }
            
            // Initialize simple mobile carousel
            initSimpleCarousel();
        }, 500);

        // Add custom navigation functionality
        document.querySelectorAll('.a-left').forEach(button => {
            button.addEventListener('click', function() {
                const swiper = this.closest('.slider-nav').swiper;
                if (swiper) {
                    swiper.slidePrev();
                }
            });
        });

        document.querySelectorAll('.a-right').forEach(button => {
            button.addEventListener('click', function() {
                const swiper = this.closest('.slider-nav').swiper;
                if (swiper) {
                    swiper.slideNext();
                }
            });
        });
    });

    jQuery(document).ready(function($) {
        var currentPostId = <?php echo json_encode(get_the_ID()); ?>;
        
        // Handle slider navigation
        $('.slider-nav').on('click', '.slick-slide', function() {
            var slideIndex = $(this).data('slick-index');
            $('.slider-nav').slick('slickGoTo', slideIndex);
        });
    });
</script>

<!-- Model Viewer Script -->
<script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const container = document.getElementById('threejs-container');

        if (!container) {
            console.error('Error: threejs-container not found!');
            return;
        }

        // Model-viewer setup (replaces Three.js)        
        // Replace Three.js canvas with model-viewer
        const modelUrl = "<?php echo esc_url(get_field('upload_three_dimensional_scans') ?: ''); ?>";

        if (!modelUrl || modelUrl === 'false') {
            console.error('Error: Model URL is empty or invalid:', modelUrl);
            container.innerHTML = '<div style="text-align: center; padding: 50px; color: #666;">No 3D model found in this post.</div>';
            return;
        }

            console.log('Loading Model from:', modelUrl);

        // Replace container content with model-viewer
        container.innerHTML = `
            <model-viewer 
                id="model-viewer"
                src="${modelUrl}"
                alt="3D Model"
                auto-rotate
                shadow-intensity="1.5"
                tone-mapping="Reinhard"
                camera-controls
                touch-action="pan-y"
                camera-orbit="0deg 85deg 7.5m"
                field-of-view="30deg"
                style="width: 100%; height: 100%; background-color: #fafafa;">
                
                <!-- Loading indicator -->
                <div class="loading" slot="progress-bar">
                    <div class="loading-bar"></div>
                </div>
                
                <!-- Error message -->
                <div class="error" slot="error">
                    <p>Sorry, this 3D model could not be loaded.</p>
                </div>
            </model-viewer>
        `;

        // Wait for model-viewer to be defined before setting up event listeners
        const setupModelViewer = () => {
            const modelViewer = document.querySelector('#model-viewer');
            if (modelViewer && typeof modelViewer.addEventListener === 'function') {
                console.log('Model-viewer is ready, setting up event listeners');
                
                modelViewer.addEventListener('load', function() {
                    console.log('Model loaded successfully');
                    // Hide the loading bar when model loads
                    const loadingBar = modelViewer.querySelector('.loading');
                    if (loadingBar) {
                        loadingBar.style.display = 'none';
                    }
                    
                    // Center the current model in the carousel
                    centerCurrentModelInCarousel();
                });
                
                modelViewer.addEventListener('error', function(event) {
                    console.error('Model loading error:', event.detail);
                });
                
                modelViewer.addEventListener('progress', function(event) {
                    const progress = event.detail.totalProgress;
                    console.log('Loading progress:', Math.round(progress * 100) + '%');
                });
            } else {
                console.log('Model-viewer not ready yet, retrying...');
                setTimeout(setupModelViewer, 100);
            }
        };

        // Wait a bit for the DOM to update, then start checking
        setTimeout(setupModelViewer, 100);

        // Function to center the current model in the carousel
        function centerCurrentModelInCarousel() {
            console.log('Attempting to center current model in carousel...');
            
            // Get the current post ID (same as the existing carousel code)
            const currentPostId = <?php echo json_encode(get_the_ID()); ?>;
            console.log('Current post ID:', currentPostId);
            
            // Wait for Slick to be ready
            setTimeout(() => {
                if (window.jQuery && window.jQuery.fn.slick) {
                    const $slider = window.jQuery('.slider-nav');
                    
                    // Find the slide with the current post ID
                    const currentSlide = $slider.find(`[data-post-id="${currentPostId}"]`);
                    console.log('Current slide found:', currentSlide.length > 0);
                    
                    if (currentSlide.length > 0) {
                        console.log('Current slide element:', currentSlide[0]);
                        console.log('Current slide classes:', currentSlide.attr('class'));
                        
                        // Get the slick index of the current slide
                        let slideIndex = currentSlide.data('slick-index');
                        console.log('Slide index from data:', slideIndex);
                        
                        // If data-slick-index is not available, find it manually
                        if (slideIndex === undefined) {
                            const allSlides = $slider.find('.slick-slide');
                            console.log('Total slides found:', allSlides.length);
                            console.log('All slide elements:', allSlides);
                            
                            // Try different approaches to find the index
                            slideIndex = allSlides.index(currentSlide);
                            console.log('Slide index from manual search:', slideIndex);
                            
                            // Alternative: search by data-post-id in all slides
                            if (slideIndex === -1) {
                                allSlides.each(function(index) {
                                    if ($(this).find('[data-post-id]').data('post-id') == currentPostId) {
                                        slideIndex = index;
                                        console.log('Found slide by data-post-id at index:', index);
                                        return false; // break the loop
                                    }
                                });
                            }
                        }
                        
                        if (slideIndex !== undefined && slideIndex >= 0) {
                            // Center the current slide
                            $slider.slick('slickGoTo', slideIndex);
                            console.log('Centered current model in carousel at index:', slideIndex);
                            
                            // Add visual highlighting
                            $slider.find('.slick-slide').removeClass('current-model');
                            currentSlide.addClass('current-model');
                        } else {
                            console.log('Could not determine slide index, trying alternative approach...');
                            
                            // Alternative: try to find by post title or other attributes
                            const postTitle = '<?php echo get_the_title(); ?>';
                            console.log('Looking for post title:', postTitle);
                            
                            $slider.find('.slick-slide').each(function(index) {
                                const slideTitle = $(this).find('h3, .title, [data-title]').text().trim();
                                console.log('Slide', index, 'title:', slideTitle);
                                if (slideTitle === postTitle) {
                                    $slider.slick('slickGoTo', index);
                                    $(this).addClass('current-model');
                                    console.log('Found and centered by title at index:', index);
                                    return false;
                                }
                            });
                        }
                    } else {
                        console.log('Current slide not found in carousel');
                    }
                } else {
                    console.log('jQuery or Slick not available');
                }
            }, 1000); // Wait 1 second for Slick to be fully initialized
        }

        // Add loading styles for model-viewer
        const style = document.createElement('style');
        style.textContent = `
            .loading {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 200px;
                height: 4px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 2px;
                overflow: hidden;
            }
            
            .loading-bar {
                height: 100%;
                background: #df2f2f;
                border-radius: 2px;
                animation: loading 2s ease-in-out infinite;
            }
            
            @keyframes loading {
                0% { width: 0%; }
                50% { width: 70%; }
                100% { width: 100%; }
            }
            
            .error {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: rgba(220, 53, 69, 0.9);
                color: white;
                padding: 20px;
                border-radius: 8px;
                text-align: center;
            }
            
            /* Style for current model in carousel */
            .slider-nav .slick-slide.current-model {
                border: 2px solid #007bff !important;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
            }
            
            .slider-nav .slick-slide.current-model h3 {
                color: #007bff !important;
                font-weight: bold;
            }
        `;
        document.head.appendChild(style);


    });
</script>

<?php get_footer(); ?>
