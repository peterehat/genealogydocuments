<?php
/**
 * Template Name: 3D Model Viewer (Enhanced Lighting)
 * Description: Enhanced 3D model viewer with improved lighting similar to glb.ee
 */

get_header(); ?>

<style>
    body {
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
        font-family: Arial, sans-serif;
    }

    .header-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 0;
        text-align: center;
    }

    .header-section h1 {
        margin: 0;
        font-size: 2.5em;
        font-weight: 300;
    }

    .header-section p {
        margin: 10px 0 0 0;
        font-size: 1.1em;
        opacity: 0.9;
    }

    .content-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .model-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-bottom: 30px;
    }

    .model-header {
        padding: 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .model-header h2 {
        margin: 0;
        color: #333;
        font-size: 1.8em;
    }

    .back-button {
        background: #667eea;
        color: white;
        padding: 10px 20px;
        border-radius: 25px;
        text-decoration: none;
        transition: background 0.3s ease;
    }

    .back-button:hover {
        background: #5a6fd8;
    }

    .model-viewer {
        position: relative;
        width: 100%;
        height: 70vh;
        min-height: 500px;
        background: #fafafa;
    }

    #threejs-container {
        width: 100%;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    #threejs-container canvas {
        display: block;
        background-color: white;
        width: 100% !important;
        height: 100% !important;
    }

    #loader {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        z-index: 1000;
    }

    .model-info {
        padding: 30px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    .model-info h3 {
        color: #333;
        margin-bottom: 15px;
        font-size: 1.5em;
    }

    .model-info p {
        color: #666;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .provenance {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid #667eea;
    }

    .provenance h4 {
        margin: 0 0 10px 0;
        color: #333;
    }

    .provenance p {
        margin: 0;
        color: #666;
    }

    .related-models {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        padding: 20px;
    }

    .related-models h3 {
        color: #333;
        margin-bottom: 20px;
        font-size: 1.5em;
    }

    .slider-nav {
        display: none;
    }

    .slider-nav .slick-slide {
        padding: 0 10px;
    }

    .slider-nav .slick-slide img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .slider-nav .slick-slide:hover img {
        transform: scale(1.05);
    }

    .slick-prev, .slick-next {
        background: #667eea;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        z-index: 10;
    }

    .slick-prev:before, .slick-next:before {
        color: white;
        font-size: 18px;
    }

    @media (max-width: 768px) {
        .content-wrapper {
            padding: 10px;
        }
        
        .model-viewer {
            height: 50vh;
            min-height: 300px;
        }
        
        .header-section h1 {
            font-size: 2em;
        }
        
        .model-header {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
    }
</style>

<section class="header-section">
    <div class="content-wrapper">
        <h1>3D Model Viewer</h1>
        <p>Interactive three-dimensional scans of genealogy artifacts</p>
    </div>
</section>

<section class="content-wrapper">
    <div class="model-container">
        <div class="model-header">
            <h2><?php the_title(); ?></h2>
            <a href="<?php echo home_url('/three-dimensional-scans/'); ?>" class="back-button">← Back to Gallery</a>
        </div>
        
        <div class="model-viewer">
            <div id="threejs-container"></div>
        </div>
    </div>

    <div class="model-info">
        <h3><?php the_title(); ?></h3>
        <?php if (get_field('description')): ?>
            <p><?php echo get_field('description'); ?></p>
        <?php endif; ?>
        
        <?php if (get_field('provenance')): ?>
            <div class="provenance">
                <h4>Provenance</h4>
                <p><?php echo get_field('provenance'); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <?php
    // Get related 3D models
    $related_models = get_posts(array(
        'post_type' => '3d_model',
        'posts_per_page' => 8,
        'post__not_in' => array(get_the_ID()),
        'meta_query' => array(
            array(
                'key' => 'upload_three_dimensional_scans',
                'compare' => 'EXISTS'
            )
        )
    ));

    if ($related_models): ?>
        <div class="related-models">
            <h3>Related 3D Models</h3>
            <div class="slider-nav">
                <?php foreach ($related_models as $model): ?>
                    <div>
                        <a href="<?php echo get_permalink($model->ID); ?>">
                            <?php if (get_field('thumbnail_image', $model->ID)): ?>
                                <img src="<?php echo get_field('thumbnail_image', $model->ID); ?>" alt="<?php echo get_the_title($model->ID); ?>">
                            <?php else: ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder-3d.jpg" alt="<?php echo get_the_title($model->ID); ?>">
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
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
        scene.background = new THREE.Color(0xeeeeee); // Set white background immediately
        

        // Set Camera
        camera = new THREE.PerspectiveCamera(40, window.innerWidth / window.innerHeight, 0.1, 1000);
        camera.position.set(0, 0, 2); // Adjust camera closer

        // Create Renderer with Enhanced Settings
        renderer = new THREE.WebGLRenderer({ antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setClearColor(0xffffff, 1);
        
        // Enhanced renderer settings for better brightness (similar to glb.ee)
        renderer.toneMapping = THREE.ACESFilmicToneMapping;
        renderer.toneMappingExposure = 1.0;
        renderer.outputColorSpace = THREE.SRGBColorSpace;
        renderer.physicallyCorrectLights = true;        
        container.appendChild(renderer.domElement);

        // Enhanced Lighting Setup
        // Main directional light (key light)
        const directionalLight = new THREE.DirectionalLight(0xffffff, 2.0);
        directionalLight.position.set(3, 5, 4);
        directionalLight.castShadow = true;
        scene.add(directionalLight);

        // Fill light from the opposite side
        const fillLight = new THREE.DirectionalLight(0xeaf2ff, 0.5);
        fillLight.position.set(-5, 3, -5);
        scene.add(fillLight);

        // Rim light for better edge definition
        const rimLight = new THREE.DirectionalLight(0xfff1e0, 0.6);
        rimLight.position.set(0, 5, -5);
        scene.add(rimLight);

        // Ambient light for subtle fill
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.2);
        scene.add(ambientLight);

        // Hemisphere light for natural lighting
        const hemisphereLight = new THREE.HemisphereLight(0xdfe6f0, 0x2a2a2a, 0.4);
        scene.add(hemisphereLight);
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
        loaderElement.innerHTML = `<img src='http://104.248.108.38/wp-content/uploads/2025/02/loader.gif' alt='Loading...'>`;
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
