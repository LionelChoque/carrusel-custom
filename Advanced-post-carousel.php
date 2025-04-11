<?php
/**
 * Plugin Name: Advanced Post Carousel
 * Plugin URI: https://bairesanalitica.com/advanced-post-carousel 
 * Description: Un plugin de carrusel de posts con shortcode personalizable y dashboard para controlar estilos y funciones.
 * Version: 1.0.0
 * Author: Alan
 * License: GPL v2 or later
 * Text Domain: advanced-post-carousel
 */

// Evitar acceso directo
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Definir constantes del plugin
define( 'APC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'APC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'APC_VERSION', '1.0.0' );

class Advanced_Post_Carousel {

    public function __construct() {
        // Hooks de activación para establecer opciones por defecto
        register_activation_hook( __FILE__, array( $this, 'activate' ) );

        // Agregar menú en el área de administración
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );

        // Registrar y encolar scripts y estilos (front y admin)
        add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

        // Registrar el shortcode para el carrusel
        add_shortcode( 'post_carousel', array( $this, 'post_carousel_shortcode' ) );
    }

    /**
     * Función de activación: guarda opciones predeterminadas.
     */
    public function activate() {
        $default_options = array(
            'slides_to_show'   => 3,
            'slides_to_scroll' => 1,
            'autoplay'         => 'yes',
            'autoplay_speed'   => 3000,
            'dots'             => 'yes',
            'arrows'           => 'yes',
            'post_type'        => 'post',
            'posts_per_page'   => 9,
            'order'            => 'DESC',
            'orderby'          => 'date',
            'title_color'      => '#333333',
            'title_font_size'  => '18px',
            'excerpt_length'   => 15,
            'read_more_text'   => 'Leer más',
            'show_date'        => 'yes',
            'show_author'      => 'yes',
            'show_category'    => 'yes',
            'card_bg_color'    => '#ffffff',
            'card_border_radius'=> '5px',
            'layout'           => 'default',
        );
        add_option( 'apc_settings', $default_options );
    }

    /**
     * Agregar menú de administración.
     */
    public function add_admin_menu() {
        add_menu_page(
            __( 'Post Carousel', 'advanced-post-carousel' ),
            __( 'Post Carousel', 'advanced-post-carousel' ),
            'manage_options',
            'advanced-post-carousel',
            array( $this, 'admin_page' ),
            'dashicons-slides',
            30
        );
    }

    /**
     * Registrar settings usando la API de Settings de WordPress.
     */
    public function register_settings() {
        register_setting( 'apc_settings_group', 'apc_settings' );
    }

    /**
     * Cargar la página de administración.
     * El archivo templates/admin-page.php contendrá el HTML para el dashboard.
     */
    public function admin_page() {
        include APC_PLUGIN_DIR . 'templates/admin-page.php';
    }

    /**
     * Registrar y encolar scripts y estilos para el frontend.
     */
    public function register_scripts() {
        // Registrar estilos de Slick Carousel y los propios del plugin
        wp_register_style( 'slick-carousel', APC_PLUGIN_URL . 'assets/css/slick.css', array(), APC_VERSION );
        wp_register_style( 'slick-theme', APC_PLUGIN_URL . 'assets/css/slick-theme.css', array( 'slick-carousel' ), APC_VERSION );
        wp_register_style( 'apc-styles', APC_PLUGIN_URL . 'assets/css/apc-styles.css', array( 'slick-carousel', 'slick-theme' ), APC_VERSION );

        // Registrar scripts: Slick Carousel y los scripts propios del plugin
        wp_register_script( 'slick-carousel', APC_PLUGIN_URL . 'assets/js/slick.min.js', array( 'jquery' ), APC_VERSION, true );
        wp_register_script( 'apc-scripts', APC_PLUGIN_URL . 'assets/js/apc-scripts.js', array( 'jquery', 'slick-carousel' ), APC_VERSION, true );
    }

    /**
     * Encolar scripts y estilos en el área de administración.
     */
    public function admin_scripts( $hook ) {
        if ( $hook !== 'toplevel_page_advanced-post-carousel' ) {
            return;
        }
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script( 'apc-admin', APC_PLUGIN_URL . 'assets/js/apc-admin.js', array( 'jquery', 'wp-color-picker' ), APC_VERSION, true );
    }

    /**
     * Shortcode para generar el carrusel de posts.
     *
     * Uso:
     * [post_carousel slides_to_show="4" category="noticias" layout="default"]
     *
     * @param array $atts Atributos del shortcode.
     * @return string Contenido HTML generado.
     */
    public function post_carousel_shortcode( $atts ) {
        // Obtener opciones globales guardadas
        $options = get_option( 'apc_settings' );

        // Procesar atributos del shortcode (con valores predeterminados de opciones)
        $atts = shortcode_atts( array(
            'slides_to_show'   => $options['slides_to_show'],
            'slides_to_scroll' => $options['slides_to_scroll'],
            'autoplay'         => $options['autoplay'],
            'autoplay_speed'   => $options['autoplay_speed'],
            'dots'             => $options['dots'],
            'arrows'           => $options['arrows'],
            'post_type'        => $options['post_type'],
            'posts_per_page'   => $options['posts_per_page'],
            'order'            => $options['order'],
            'orderby'          => $options['orderby'],
            'category'         => '',
            'tag'              => '',
            'layout'           => $options['layout'],
        ), $atts, 'post_carousel' );

        // Encolar scripts y estilos necesarios para el carrusel
        wp_enqueue_style( 'slick-carousel' );
        wp_enqueue_style( 'slick-theme' );
        wp_enqueue_style( 'apc-styles' );
        wp_enqueue_script( 'slick-carousel' );
        wp_enqueue_script( 'apc-scripts' );

        // Generar un ID único para este carrusel (para manejar múltiples carruseles en una misma página)
        $carousel_id = 'apc-carousel-' . uniqid();

        // Configuración para el carrusel, que se pasará a JavaScript
        $carousel_config = array(
            'id'              => $carousel_id,
            'slidesToShow'    => intval( $atts['slides_to_show'] ),
            'slidesToScroll'  => intval( $atts['slides_to_scroll'] ),
            'autoplay'        => $atts['autoplay'] === 'yes',
            'autoplaySpeed'   => intval( $atts['autoplay_speed'] ),
            'dots'            => $atts['dots'] === 'yes',
            'arrows'          => $atts['arrows'] === 'yes',
        );

        // Pasar la configuración al script; si hay múltiples carruseles, se puede extender este método
        wp_localize_script( 'apc-scripts', 'apc_config_' . $carousel_id, $carousel_config );

        // Configurar la consulta de posts según los atributos
        $query_args = array(
            'post_type'      => $atts['post_type'],
            'posts_per_page' => intval( $atts['posts_per_page'] ),
            'order'          => $atts['order'],
            'orderby'        => $atts['orderby'],
        );
        if ( ! empty( $atts['category'] ) ) {
            $query_args['category_name'] = sanitize_text_field( $atts['category'] );
        }
        if ( ! empty( $atts['tag'] ) ) {
            $query_args['tag'] = sanitize_text_field( $atts['tag'] );
        }

        $carousel_query = new WP_Query( $query_args );

        // Iniciar buffer de salida para capturar el HTML
        ob_start();

        if ( $carousel_query->have_posts() ) {
            // Incluir el template del carrusel según el layout configurado.
            // Debés crear los archivos de plantilla (por ejemplo, templates/carousel-default.php)
            include APC_PLUGIN_DIR . 'templates/carousel-' . $atts['layout'] . '.php';
        } else {
            echo '<p>' . __( 'No se encontraron posts.', 'advanced-post-carousel' ) . '</p>';
        }

        wp_reset_postdata();

        return ob_get_clean();
    }
}

// Inicializar el plugin
$advanced_post_carousel = new Advanced_Post_Carousel();
