<?php
declare(strict_types=1);
/**
* Gumbo Millennium Theme
* Basic registration of methods
*
* @package Gumbo
* @subpackage Theme
* @since 1.0
* @license MPL-2
* @author Roelof Roos <github@roelof.io>
*/

namespace Gumbo\Theme;

/**
* Registers the theme's configuration with WordPress
*/
class Functions
{
    public function __construct()
    {
        $wp_version = $GLOBALS['wp_version'] ?? null;

        // Check version
        if (empty($wp_version) || version_compare($wp_version ?? null, '4.9') < 0) {
            wp_die(sprintf(
                'Gumbo Millennium requires WordPress 4.9 or newer. You\'ve got %s',
                $wp_version ?? 'null'
            ), 'Outdated WordPress version');
            return;
        }

        // Hook up class
        add_action('after_setup_theme', \Closure::fromCallable([$this, 'setup']));
        add_action('wp_resource_hints', \Closure::fromCallable([$this, 'resourceHints']), 10, 2);
        add_action('widgets_init', \Closure::fromCallable([$this, 'widgetsInit']));
        add_action('admin_enqueue_scripts', \Closure::fromCallable([$this, 'loadScripts']));
    }

    /**
    * Called when the theme is set up
    *
    * @return void
    */
    protected function setup() : void
    {
        // Enable post thumbnails for posts and pages, also used in covers
        add_theme_support('post-thumbnails');

        // Disable custom colours and font sizes in Gutenberg
        add_theme_support('disable-custom-colors');
        add_theme_support('disable-custom-font-sizes');

        // Default page thumbnails, shown in the following sizes:
        // xs - sm: 50% (max 288px)
        // md - lg: 33% (max 330px)
        // xl:      25% (max 300px)
        set_post_thumbnail_size(330, 200, true);

        // Page covers (behind backgrounds) are 1920 x 500 (cropped)
        add_image_size('page-cover', 1920, 500, true);

        // Large page covers (behind backgrounds) are 1920 x 900 (cropped)
        add_image_size('page-cover-large', 1920, 900, true);

        // Register the navigation menus
        register_nav_menus([
            'header' => 'Header',
            'footer' => 'Footer',
            'footer-legal' => 'Legal'
        ]);

        // Let WordPress know we want valid HTML5, not that weird HTML4 shit
        add_theme_support('html5', [
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ]);

        // Register some post formats
        add_theme_support('post-formats', [
            'image',
            'video',
            'gallery'
        ]);
    }

    /**
    * Add preconnect for Google Fonts.
    *
    * @since Twenty Seventeen 1.0
    *
    * @param array  $urls           URLs to print for resource hints.
    * @param string $relation_type  The relation type the URLs are printed.
    * @return array $urls           URLs to print for resource hints.
    */
    public function resourceHints(array $urls, string $relation_type) : array
    {
        if ($relation_type === 'preconnect') {
            array_push($urls, [
                'href' => 'https://fonts.gstatic.com',
                'crossorigin'
            ]);
        }

        return $urls;
    }

    /**
    * Register widget areas
    *
    * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
    * @return void
    */
    protected function widgetsInit() : void
    {
        $defaultWidget = [
            'before_widget' => '<section id="%1$s" class="sidebar sidebar--widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="sidebar__title">',
            'after_title' => '</h2>'
        ];

        /*
        *  Bunch of sidebars
        */

        // Blog / News sidebar
        register_sidebar(array_merge($defaultWidget, [
            'name' => 'Nieuws Sidebar',
            'id' => 'sidebar-blog',
            'description' => 'Add widgets here to appear in your sidebar on blog posts and archive pages.',
        ]));

        // Activity sidebar
        register_sidebar(array_merge($defaultWidget, [
            'name' => 'Activiteiten Sidebar',
            'id' => 'sidebar-activities',
            'description' => 'Add widgets here to appear in your sidebar on activities.',
        ]));

        // File system sitebar
        register_sidebar(array_merge($defaultWidget, [
            'name' => 'Documentensysteem Sidebar',
            'id' => 'sidebar-files',
            'description' => 'Add widgets here to appear in your sidebar on files and file search.',
        ]));
    }

    /**
     * Registers admin scripts and css
     *
     * @return void
     */
    protected function loadScripts() : void
    {
        wp_enqueue_style('gumbo-theme-admin-css', get_template_directory_uri() . '/dist/admin.css');
        wp_enqueue_script('gumbo-theme-admin-js', get_template_directory_uri() . '/dist/admin.js', ['jquery']);
    }
}

// Create class
$gumbo_functions = new Functions;
