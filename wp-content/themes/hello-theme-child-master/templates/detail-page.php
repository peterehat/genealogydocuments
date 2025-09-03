<?php
/*
 * Template Name: Detail Page
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
        width: calc(100% - 400px) !important;
        border-right: 0;
    }

    .object-detail-left .main {
        border-right: solid 2px #f1d9c0;
    }

    .object-detail-right {
        width: 400px !important;
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

    .slider-detail a{
        color:#000;
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
	  .button-load {
		background-color: #000;
		color: white;
		cursor: pointer;
		border-radius: 6px;
		display: inline-block;
		padding: 10px 18px 10px 18px;
		font-weight: 500;
		box-shadow: 0 0 8px rgba(0,0,0,.2), 0 0 4px rgba(0,0,0,.25);
		position: absolute;
		left: 50%;
		top: 50%;
		transform: translate3d(-50%, -50%, 0);
		z-index: 100;
	  }
/* 	#lazy-load-poster,
	#button-load {
		display: none; 
	}

	@media screen and (max-width: 768px) {
		#lazy-load-poster,
		#button-load {
			display: block; 
		}
	} */
</style>
<header class="header-box">
    <div><a href="<?php echo esc_url(home_url('/')); ?>"><img class="header-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Logo.svg" /></a></div>
    <div><a href="<?php echo esc_url(home_url('/')); ?>" class="back-link"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/arrow.svg" /> Back</a></div>
</header>

<section class="object-detail">
    <div class="object-detail-left">
        <div class="main">
            <div class="slider slider-for">
                <?php if (have_rows('three_dimensional_objects')): ?>
                    <?php while (have_rows('three_dimensional_objects')): the_row(); ?>
                        <div>
                            <model-viewer
								class="lazy-load"
                                src="<?php the_sub_field('upload_three_dimensional_scans'); ?>"
                                loading="lazy"
								reveal="manual"
                                ar ar-modes="webxr scene-viewer quick-look"
                                camera-controls
                                tone-mapping="commerce"
                                shadow-intensity="1">
								<div id="lazy-load-poster" slot="poster" style="background-image: url('<?php the_sub_field('upload_three_dimensional_thumbnail_image'); ?>');"></div>
								<div class="button-load" slot="poster">Load 3D Model</div>
                            </model-viewer>
						</div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
            <div class="slider slider-nav">
                <?php if (have_rows('three_dimensional_objects')): ?>
                    <?php while (have_rows('three_dimensional_objects')): the_row(); ?>
                        <div>
                            <div>
                                <div class="slider-bottom">
                                    <img src="<?php the_sub_field('upload_three_dimensional_thumbnail_image'); ?>" />
                                    <p><?php the_sub_field('three_dimensional_thumbnail_image_label'); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="object-detail-right">
        <div class="slider slider-for slider-detail">
            <?php if (have_rows('three_dimensional_objects')): ?>
                <?php while (have_rows('three_dimensional_objects')): the_row(); ?>
                    <div>
                        <h2><?php the_sub_field('three_dimensional_object_title'); ?></h2>
                        <div class="content-scroll">
                            <?php if (have_rows('three_dimensional_object_details_section')): ?>
                                <?php while (have_rows('three_dimensional_object_details_section')): the_row(); ?>
                                    <div>
                                        <h4><?php the_sub_field('three_dimensional_object_details_sub_title'); ?></h4>
                                        <p><?php the_sub_field('three_dimensional_object_details_sub_detail'); ?></p>
                                    </div>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/plugins/jquery.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/plugins/slick.min.js"></script>
<!-- <script type="module" src="https://cdn.jsdelivr.net/npm/@google/model-viewer/dist/model-viewer.js"></script> -->
<script type="module" src="https://cdn.jsdelivr.net/npm/@google/model-viewer/dist/model-viewer.min.js"></script>
<script>
    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        draggable: false,
        swipe: false,
        asNavFor: '.slider-nav',
        responsive: [{
                breakpoint: 1025,
                settings: {
                    draggable: false,
                    swipe: false,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    draggable: false,
                    swipe: false,
                }
            }
        ]
    });
    $('.slider-nav').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: false,
        focusOnSelect: true,
        //variableWidth: true,
        prevArrow: "<button class='a-left control-c prev slick-prev'></button>",
        nextArrow: "<button class='a-right control-c next slick-next'></button>",
        responsive: [{
                breakpoint: 1025,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

//      document.addEventListener("DOMContentLoaded", function() {
//             // Get all model-viewer elements
//             var viewers = document.querySelectorAll("model-viewer");

//             // Loop through each model-viewer
//             viewers.forEach(function(viewer, index) {
//                 if (index === 0) {
//                     // Initialize the model-viewer in the first slide
//                     viewer.activate();
//                 } else {
//                     // Pause or stop model-viewers in other slides
//                     viewer.pause();
//                 }
//             });
//         });
		
document.addEventListener("DOMContentLoaded", function () {
    // Add event listeners to all "Load 3D Model" buttons
    document.querySelectorAll('.button-load').forEach((button, index) => { // Changed to .button-load
        button.addEventListener('click', function () {
            // Find the corresponding model-viewer for this button
            const modelViewer = document.querySelectorAll('.lazy-load')[index];
            if (modelViewer) {
                modelViewer.dismissPoster(); // Dismiss poster and load 3D model
            }
        });
    });
});

</script>


<?php get_footer(); ?>