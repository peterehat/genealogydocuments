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
            display: flex;
            flex-direction: row;
            overflow: hidden;
        }

        .slider-nav>.slick-slider {
            min-width: calc(100% / 4) !important;
            display: flex;
            align-items: center;
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
        .slider.slider-nav.desktop {
            display: block;
        }
        .slider.slider-nav.mobile {
            display: none;
        }

        @media screen and (max-width: 1024px) {

            .slider.slider-nav.desktop {
                display: none;
            }
            .slider.slider-nav.mobile {
                display: block;
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
                position: absolute;
                top: 75%;
                background-color: #fff;
                right: 0;
                left: 0;
                width: 100% !important;
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
                /* height: calc(85vh - 282px); */
                height: 85vh;
                position: relative;
                overflow: hidden;
                background-color: white;
                position: absolute;
                top: 40%;
                left: 50%;
                transform: translate(-50%, -50%);
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
        <div><a href="/three-dimensional-scans/" class="back-link"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/arrow.svg" />Back</a></div>
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
                    <div class="slider slider-nav desktop" style="visibility:hidden;">
                        <?php if ($models_query->have_posts()): ?>
                            <?php while ($models_query->have_posts()): $models_query->the_post(); ?>
                                <?php 
                                    $post_id = get_the_ID();
                                    $active_class = ($post_id == $current_post_id) ? ' current-slick' : ''; 
                                ?>
                                <div class="slick-slider<?php echo esc_attr($active_class); ?>" data-post-id="<?php echo esc_attr($post_id); ?>">
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
            <div class="slider slider-nav mobile" style="visibility:hidden;">
                <?php if ($models_query->have_posts()): ?>
                    <?php while ($models_query->have_posts()): $models_query->the_post(); ?>
                        <?php 
                            $post_id = get_the_ID();
                            $active_class = ($post_id == $current_post_id) ? ' current-slick' : ''; 
                        ?>
                        <div class="slick-slider<?php echo esc_attr($active_class); ?>" data-post-id="<?php echo esc_attr($post_id); ?>">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>

<script>
    jQuery(document).ready(function($) {
        setTimeout(function() {  
            $('.slider-nav').css('visibility', 'visible');  
        }, 500);  
        
        var $slider = $('.slider-nav');
        
        // Initialize the slick slider
        $slider.slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            dots: false,
            focusOnSelect: true,
            infinite: false,
            prevArrow: "<button class='a-left control-c prev slick-prev'></button>",
            nextArrow: "<button class='a-right control-c next slick-next'></button>",
            responsive: [
                {
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
        }).on('init', function() {
            // Show the slider after initialization
            $slider.css('display', 'block');
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const container = document.getElementById('threejs-container');

        if (!container) {
            console.error('Error: threejs-container not found!');
            return;
        }

        let camera, controls, renderer, scene, model;

        // Create Scene
        scene = new THREE.Scene();
        scene.background = new THREE.Color(0xf3f5f6); // Set white background immediately
        

        // Set Camera
        camera = new THREE.PerspectiveCamera(40, window.innerWidth / window.innerHeight, 0.1, 1000);
        camera.position.set(0, 0, 2); // Adjust camera closer

        // Create Renderer
        renderer = new THREE.WebGLRenderer({ antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setClearColor(0xeeeeee, 1);
        
        // Enhanced renderer settings for better brightness (similar to glb.ee)
        renderer.toneMapping = THREE.LinearToneMapping; // Less contrast than ACES
        renderer.toneMappingExposure = 1.8; // Increased exposure to brighten dark areas
        renderer.outputColorSpace = THREE.SRGBColorSpace;
        renderer.physicallyCorrectLights = true;        
        container.appendChild(renderer.domElement);

        // Bright three-light setup to eliminate darkness and contrast
        // 1. Very strong ambient light to eliminate all shadows
        const ambientLight = new THREE.AmbientLight(0xffffff, 3.0);
        scene.add(ambientLight);

        // 2. Strong hemisphere light for natural sky/ground illumination
        const hemisphereLight = new THREE.HemisphereLight(0xffffff, 0x888888, 2.0);
        scene.add(hemisphereLight);

        // 3. Bright directional light for form definition
        const keyLight = new THREE.DirectionalLight(0xffffff, 3.0);
        keyLight.position.set(2, 3, 2);
        keyLight.castShadow = false; // No shadows to reduce contrast
        scene.add(keyLight);
        
        // Orbit Controls (User Can Rotate & Zoom Smoothly)
        controls = new THREE.OrbitControls(camera, renderer.domElement);
        controls.enableDamping = true; // Smooth movement
        controls.dampingFactor = 0.1; // Damping effect
        controls.enableZoom = true; // Enable zoom
        controls.minDistance = 0.5; // Minimum zoom
        controls.maxDistance = 10; // Maximum zoom
        controls.rotateSpeed = 0.8; // Adjust rotation speed
        controls.zoomSpeed = 0.5; // Adjust zoom speed
        controls.update();

        // Create Loader Element
        const loaderElement = document.createElement('div');
        loaderElement.id = 'loader';
        loaderElement.innerHTML = `<img src='<?php echo get_stylesheet_directory_uri(); ?>/loader.gif' alt='Loading...'>`;
        loaderElement.style.position = 'absolute';
        loaderElement.style.top = '50%';
        loaderElement.style.left = '50%';
        loaderElement.style.transform = 'translate(-50%, -50%)';
        loaderElement.style.backgroundColor = 'rgba(255, 255, 255, 0.8)';
        loaderElement.style.padding = '20px';
        loaderElement.style.borderRadius = '10px';
        container.appendChild(loaderElement);

        // DRACO Loader for Compressed Models
        const dracoLoader = new THREE.DRACOLoader();
        dracoLoader.setDecoderPath('https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/libs/draco/');

        // GLTF Model Loader
        const loader = new THREE.GLTFLoader();
        loader.setDRACOLoader(dracoLoader);

        const modelUrl = "<?php echo esc_url(get_field('upload_three_dimensional_scans') ?: ''); ?>";

        if (!modelUrl || modelUrl === 'false') {
            console.error('Error: Model URL is empty or invalid:', modelUrl);
        } else {
            console.log('Loading Model from:', modelUrl);

            loader.load(modelUrl, function (gltf) {
                model = gltf.scene;

                // Center the model
                const box = new THREE.Box3().setFromObject(model);
                const center = new THREE.Vector3();
                box.getCenter(center);
                model.position.sub(center); // Center the model
                
                // Make materials matte while preserving original appearance
                model.traverse(function (child) {
                    if (child.isMesh && child.material) {
                        console.log('Processing mesh:', child.name, 'Material type:', child.material?.type);
                        
                        // If material is an array, handle each material
                        if (Array.isArray(child.material)) {
                            child.material.forEach(function (material, index) {
                                console.log('Array material', index, ':', material.type);
                                // Clone and modify existing material to preserve colors/textures
                                const matteMaterial = material.clone();
                                matteMaterial.roughness = 1.0; // Maximum roughness for matte
                                matteMaterial.metalness = 0.1; // Slight metalness to preserve bronze look
                                matteMaterial.envMapIntensity = 0.0; // No environment reflections
                                matteMaterial.needsUpdate = true;
                                child.material[index] = matteMaterial;
                            });
                        } else {
                            // Single material - clone and modify
                            console.log('Single material:', child.material.type);
                            const matteMaterial = child.material.clone();
                            matteMaterial.roughness = 1.0; // Maximum roughness for matte
                            matteMaterial.metalness = 0.1; // Slight metalness to preserve bronze look
                            matteMaterial.envMapIntensity = 0.0; // No environment reflections
                            matteMaterial.needsUpdate = true;
                            child.material = matteMaterial;
                        }
                    }
                });
                
                scene.add(model);

                // Get bounding box dimensions
                const size = new THREE.Vector3();
                box.getSize(size);
                const maxDimension = Math.max(size.x, size.y, size.z);

                let idealDistance = maxDimension * 3; // Default for desktop

                // 📱 Mobile: Increase zoom-out distance
                if (window.innerWidth < 768) { 
                    idealDistance = maxDimension * 4; // Just zoom out more on mobile
                }

                // Update Camera Position
                camera.position.set(0, 0, idealDistance);
                controls.minDistance = maxDimension * 0.1; // Very close zoom-in
                controls.maxDistance = idealDistance * 10; // Extremely far zoom-out
                controls.enableZoom = true;
                controls.zoomSpeed = 1.5; // Increase zoom sensitivity
                controls.update();

                console.log("Model Size:", size, "Ideal Distance:", idealDistance);

                // Hide Loader After Model Loads
                if (loaderElement) {
                    loaderElement.style.display = 'none';
                }
            }, undefined, function (error) {
                console.error('Error loading model:', error);
            });
        }

        // Resize Handler
        window.addEventListener('resize', () => {
            renderer.setSize(window.innerWidth, window.innerHeight);
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
        });

        // Animate Function (No Auto-Rotate, Only User Control)
        function animate() {
            requestAnimationFrame(animate);
            controls.update(); // Keep controls smooth
            renderer.render(scene, camera);
        }
        animate();
    });
</script>

<?php get_footer(); ?>
