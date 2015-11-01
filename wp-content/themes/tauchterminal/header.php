<?php
/**
 * Theme: Tauch Terminal Bootstrap
 *
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package tauchterminal
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title('|', true, 'right'); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
<link rel="shortcut icon" type="image/x-icon" href="<?php echo get_site_url(); ?>/img/favicon.ico">
<link rel="apple-touch-icon" href="<?php echo get_site_url(); ?>/img/logo.gif">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_site_url(); ?>/img/logo.gif">
<link rel="apple-touch-startup-image" media="(device-width: 320px)" href="<?php echo get_site_url(); ?>/img/logo.png">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<h1 class="sr-only"><?php bloginfo('name')?></h1>
<div id="page" class="hfeed site">

    <?php do_action('before'); ?>

    <header id="masthead" class="site-header" role="banner">

        <?php
        /**
          * CUSTOM HEADER IMAGE DISPLAYS HERE FOR THIS THEME, BUT CHILD THEMES MAY DISPLAY
          * IT BELOW THE NAV BAR (VIA CONTENT-HEADER.PHP)
          */
        global $xsbf_theme_options;
        $custom_header_location = isset ($xsbf_theme_options['custom_header_location']) ? $xsbf_theme_options['custom_header_location'] : 'content-header';
        if ($custom_header_location == 'header') :
        ?>
            <?php do_action('icl_language_selector'); ?>
            <div id="site-branding" class="site-branding">

            <?php include_once(ABSPATH . 'wp-admin/includes/plugin.php'); ?>
            <?php if ($post->post_name == 'contact'): ?>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3948.2660569210007!2d115.5908273143318!3d-8.276296685487742!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd1ff3fb94581ad%3A0x5c34fc071650a23d!2sTauch+Terminal+Resort+Tulamben!5e0!3m2!1sen!2sus!4v1446369121956" width="100%" height="500" frameborder="0" style="border:0; display: inherit;" allowfullscreen></iframe>
            <?php elseif (is_plugin_active('slick-carousel/slick-carousel.php')): ?>
                <div class="carousel-header">
                    <?php $langcode = (defined('ICL_LANGUAGE_CODE')) ? ICL_LANGUAGE_CODE : 'de'; ?>
                    <?php echo do_shortcode('[slick-carousel category="header-'. $langcode .'"]'); ?>
                </div>
            <?php elseif (get_header_image()): ?>
                <div class="custom-header-image" style="background-image: url('<?php echo header_image() ?>'); width: <?php echo get_custom_header()->width; ?>px; height: <?php echo get_custom_header()->height ?>px;"></div>
            <?php // If no custom header, then just display the site title and tagline ?>
            <?php else: ?>
                <div class="container">
                    <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name')?></a></h1>
                    <h2 class="site-description"><?php bloginfo('description'); ?></h2>
                </div>
            <?php endif ?>
            </div><!-- .site-branding -->

        <?php
        endif; // $custom_header_location
        ?>

        <?php
        /**
          * ALWAYS DISPLAY THE NAV BAR
          */
         ?>
        <nav id="site-navigation" class="main-navigation" role="navigation">

            <h1 class="menu-toggle sr-only screen-reader-text"><?php _e('Primary Menu', 'tauchterminal'); ?></h1>
            <div class="skip-link"><a class="screen-reader-text sr-only" href="#content"><?php _e('Skip to content', 'tauchterminal'); ?></a></div>

        <?php
        // Collapsed navbar menu toggle
        global $xsbf_theme_options;
        $navbar = '<div class="navbar ' . $xsbf_theme_options['navbar_classes'] . '">'
            .'<div class="container">'
            .'<div class="navbar-header">'
              .'<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">'
            .'<span class="icon-bar"></span>'
            .'<span class="icon-bar"></span>'
            .'<span class="icon-bar"></span>'
              .'</button>';

        // Site title (Bootstrap "brand") in navbar. Hidden by default. Customizer will
        // display it if user turns of the main site title and tagline.
        $navbar .= '<a class="navbar-brand" href="'
            .esc_url(home_url('/'))
            .'" rel="home">'
            .get_bloginfo('name')
            .'</a>';

        $navbar .= '</div><!-- navbar-header -->';
        // Display the desktop navbar
        $navbar .= wp_nav_menu(
            array(
                'theme_location'    => 'primary',
                'container_class'   => 'navbar-collapse collapse', //<nav> or <div> class
                'container_id'      => 'main-navbar-collapse',
                'menu_class'        => 'nav navbar-nav', //<ul> class
                'walker'            => new wp_bootstrap_navwalker(),
                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                'echo'              => false,
                'depth'             => 2
            )
        );
        echo apply_filters('xsbf_navbar', $navbar);
        ?>

        </div><!-- .container -->
        </div><!-- .navbar -->
        </nav><!-- #site-navigation -->

    </header><!-- #masthead -->

    <?php // Set up the content area (but don't put it in a container) ?>
    <div id="content" class="site-content">
