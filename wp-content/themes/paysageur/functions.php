<?php
/**
* Paysageur_Theme functions and definitions
*
* @link https://developer.wordpress.org/themes/basics/theme-functions/
*
* @package Paysageur_Theme
*/
/**
* @custom @comment_off @taxo
*/
require_once TEMPLATEPATH . '/inc/tb_custom.php';
require_once TEMPLATEPATH . '/inc/tb_comment_off.php';
require_once TEMPLATEPATH . '/inc/tb_taxonomy.php';

/**
* initialisation du thème
*/

if (! function_exists('paysageur_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function paysageur_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Paysageur_Theme, use a find and replace
         * to change 'paysageur' to the name of your theme in all the template files.
         */
        load_theme_textdomain('paysageur', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'menu-header' => esc_html__('Primary', 'paysageur'),
            'menu-footer' => esc_html__('Footer', 'paysageur')
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('paysageur_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support('custom-logo', array(
            'height'      => 46,
            'width'       => 45,
            'flex-width'  => true,
            'flex-height' => true,
        ));
    }
endif;
add_action('after_setup_theme', 'paysageur_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function paysageur_content_width()
{
    // This variable is intended to be overruled from themes.
    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $GLOBALS['content_width'] = apply_filters('paysageur_content_width', 640);
}
add_action('after_setup_theme', 'paysageur_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function paysageur_widgets_init()
{
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'paysageur'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'paysageur'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'paysageur_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function paysageur_scripts()
{
    wp_enqueue_style('paysageur-style', get_stylesheet_uri());

    wp_enqueue_script('paysageur-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true);

    wp_enqueue_script('paysageur-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'paysageur_scripts');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
    require get_template_directory() . '/inc/woocommerce.php';
}

/** Déclaration de clef API Google MAP **/
function my_acf_google_map_api($api)
{
    $api['key'] = 'AIzaSyBJZT3YuA1G-z2XIr4S7_SXW7G9qQ66CXE';

    return $api;
}

add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');


/*******Fonction de traduction si jamais qTranslate est désactivé, le contenu fr continura d'apparaitre. ****/
function tb_traduction($fr_en)
{
    if (function_exists('qtrans_getLanguage')) {
        if (qtrans_getLanguage()=="en"):  echo $fr_en[1];
        endif;
        if (qtrans_getLanguage()=="fr"): echo $fr_en[0];
        endif;
    } else {
        echo $fr_en[0];
    }
}

add_action('tb_auto_traduction', 'tb_traduction');
