<?php

/**
 * Plugin Name: Elementor Lined Headings
 * Description: Adds a Lined Heading widget to Elementor, based on https://foreigncodes.com/how-to-easily-create-custom-elementor-widget/
 * Plugin URI: https://github.com/joffff/elementor-custom-element
 * Version: 0.0.2
 * Author: Jonathan Frascella
 * Author URI: https://gattonero.co.uk
 * Text Domain: elementor-lined-heading
 */
if ( ! defined( 'ABSPATH' ) ) exit;

// This file is pretty much a boilerplate WordPress plugin.

class ElementorCustomElement {

   private static $instance = null;

   public static function get_instance() {
      if ( ! self::$instance )
         self::$instance = new self;
      return self::$instance;
   }

   public function init(){
      add_action( 'elementor/widgets/widgets_registered', array( $this, 'widgets_registered' ) );
   }

   public function widgets_registered() {

      // We check if the Elementor plugin has been installed / activated.
      if(defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base')){

         // We look for any theme overrides for this custom Elementor element.
         // If no theme overrides are found we use the default one in this plugin.

         $widget_file = get_template_directory() .'/elementor-lined-headings/lined-heading-widget.php';
         $template_file = locate_template($widget_file);

         if ( !$template_file || !is_readable( $template_file ) ) {
            $template_file = plugin_dir_path(__FILE__).'lined-heading-widget.php' ;
         }
         if ( $template_file && is_readable( $template_file ) ) {
            require_once $template_file;
         }
      }
   }
}

ElementorCustomElement::get_instance()->init();

function elementor_lined_headings_load_styles() {
    $plugin_url = plugin_dir_url( __FILE__ );

	wp_enqueue_style( 'elementor-lined-headings', $plugin_url . 'assets/css/styles.css' );
}

add_action( 'wp_enqueue_scripts', 'elementor_lined_headings_load_styles' );
