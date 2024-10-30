<?php
/**
 * Plugin Name: Image Slider Pro
 * Description: Create Image Slider.
 * Version:     1.0.2
 * Author:      Bokhtyer Abid
 * Author URI:  http://abiddev.com
 * Text Domain: image-slider-pro
 * Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Main Image Slider Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class ImageSliderProClass {

    /**
     * Constructor
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function __construct() {

        add_action( 'init', array($this,'image_slider_pro'), 0 );
        add_action( 'init', array($this,'register_script') );
        add_action('wp_enqueue_scripts', array($this,'enqueue_style'));
        add_shortcode('image_slider', array($this,'image_slider_main_pro'));

    }

    public function image_slider_main_pro(){
        ?>
        <div class="image-slider-pro-area">
            <div class="image-slider-pro owl-carousel">
                <?php 
                $ISlider = new WP_Query(array(
                    'post_type'     => '_image_slider',
                ));
                while($ISlider->have_posts()):$ISlider->the_post();
                 ?>
                    <?php the_post_thumbnail(); ?>
                <?php endwhile; ?>
            </div>
        </div>
        <script>
            (function($){
              'use script';

                /*---slider activation---*/
                var $slider = jQuery('.image-slider-pro');
                if($slider.length > 0){
                    $slider.owlCarousel({
                        loop: true,
                        nav: false,
                        autoplay: false,
                        autoplayTimeout: 10000,
                        items: 1,
                        nav:true,
                        navText:['<span class="image-slider-pro-slider-nav left"></span>','<span class="image-slider-pro-slider-nav right"></span>']
                    });
                }

            }(jQuery));
        </script>
        <?php
    }



    /*
     * Register Custom Post Type
    */
    public function image_slider_pro() {

        $labels = array(
            'name'                  => _x( 'Image Slider','image-slider-pro' ),
            'singular_name'         => _x( 'Image Slider', 'image-slider-pro' ),
            'menu_name'             => __( 'Image Slider', 'image-slider-pro' ),
            'name_admin_bar'        => __( 'Image Slider', 'image-slider-pro' ),
            'archives'              => __( 'Item Archives', 'image-slider-pro' ),
            'attributes'            => __( 'Item Attributes', 'image-slider-pro' ),
            'parent_item_colon'     => __( 'Parent Slider:', 'image-slider-pro' ),
            'all_items'             => __( 'All Sliders', 'image-slider-pro' ),
            'add_new_item'          => __( 'Add New Slider', 'image-slider-pro' ),
            'add_new'               => __( 'Add New', 'image-slider-pro' ),
            'new_item'              => __( 'New Slider', 'image-slider-pro' ),
            'edit_item'             => __( 'Edit Slider', 'image-slider-pro' ),
            'update_item'           => __( 'Update Slider', 'image-slider-pro' ),
            'view_item'             => __( 'View Slider', 'image-slider-pro' ),
            'view_items'            => __( 'View Slider', 'image-slider-pro' ),
            'search_items'          => __( 'Search Slider', 'image-slider-pro' ),
            'not_found'             => __( 'Not found', 'image-slider-pro' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'image-slider-pro' ),
            'featured_image'        => __( 'Featured Image', 'image-slider-pro' ),
            'set_featured_image'    => __( 'Set featured image', 'image-slider-pro' ),
            'remove_featured_image' => __( 'Remove featured image', 'image-slider-pro' ),
            'use_featured_image'    => __( 'Use as featured image', 'image-slider-pro' ),
            'insert_into_item'      => __( 'Insert into Slider', 'image-slider-pro' ),
            'uploaded_to_this_item' => __( 'Uploaded to this Slider', 'image-slider-pro' ),
            'items_list'            => __( 'Items list', 'image-slider-pro' ),
            'items_list_navigation' => __( 'Items list navigation', 'image-slider-pro' ),
            'filter_items_list'     => __( 'Filter items list', 'image-slider-pro' ),
        );
        $args = array(
            'label'                 => __( 'Post Type', 'image-slider-pro' ),
            'description'           => __( 'Post Type Description', 'image-slider-pro' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor','thumbnail' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'menu_icon'             => 'dashicons-cover-image'
        );
        register_post_type( '_image_slider', $args );

    }
    

    // register jquery and style on initialization
    
    public function register_script() {
       
        wp_register_style( 'new_style_carousel', plugins_url('/assets/css/owl.carousel.min.css', __FILE__), false, '1.0.0', 'all');
        wp_register_style( 'new_style_default', plugins_url('/assets/css/owl.theme.default.min.css', __FILE__), false, '1.0.0', 'all');
        wp_register_style( 'new_style_style', plugins_url('/assets/css/style.css', __FILE__), false, '1.0.0', 'all');

         wp_register_script( 'custom_carousel', plugins_url('/assets/js/owl.carousel.min.js', __FILE__), array('jquery'),false);
        wp_register_script( 'custom_script', plugins_url('/assets/js/script.js', __FILE__), array('jquery'),false);

    }
    public function enqueue_style(){
       wp_enqueue_script('custom_carousel');
       wp_enqueue_script('custom_script');

       wp_enqueue_style( 'new_style_carousel' );
       wp_enqueue_style( 'new_style_default' );
       wp_enqueue_style( 'new_style_style' );
    }

}

new ImageSliderProClass();