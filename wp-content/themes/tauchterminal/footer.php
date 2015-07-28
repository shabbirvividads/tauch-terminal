<?php
/**
 * Theme: Flat Bootstrap
 *
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package tauchterminal
 */
?>
    </div><!-- #content -->

    <?php // Page bottom (before footer) widget area
    get_sidebar( 'pagebottom' );
    ?>
    <?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); ?>
    <?php if ( is_plugin_active('tauch-terminal/tauch-terminal.php') ): ?>

    <div class="sites-plugin spacer">
        <?php $sites = TauchTerminal_Sites::getSites(); ?>
        <?php if (count($sites) > 12) {
            $sites = array_slice($sites, 0, 12);
        }
        ?>
        <?php $count = count($sites); ?>

        <div class="container">
            <?php foreach ($sites as $site): ?>
                <div class="col-sm-<?php echo floor(12/$count) ?> text-center">
                    <a href="#" data-rel="<?php echo $site->tt_slug ?>" class="sites-slider text-uppercase">
                        <p><?php esc_html_e('Tauch Terminal' , 'tauch-terminal'); ?></p>
                        <h2><?php echo $site->tt_desc ?></h2>
                    </a>
                </div>
            <?php endforeach ?>
        </div>

        <div class="slider-photo">
            <?php foreach ($sites as $site): ?>
                <div class="background-image image-<?php echo $site->tt_slug ?>" style="background-image: url('<?php echo $site->tt_bg ?>')"></div>
            <?php endforeach ?>
            <div class="container">
                <?php foreach ($sites as $site): ?>
                    <div class="col-sm-<?php echo floor(12/$count) ?> bg-orange more more-<?php echo $site->tt_slug ?>" style="visibility: hidden;">
                        <a href="http://<?php echo $site->tt_url ?>" target="_blank" class="text-uppercase">
                            <?php echo __('Read more') ?>
                            <span class="glyphicon glyphicon-menu-right pull-right" aria-hidden="true"></span>
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>

    <div class="container">
        <ul class="list-unstyled list-inline certifications">
            <?php foreach (TauchTerminal::getCertifications() as $certification): ?>
                <li class="item col-sm-4 col-md-2">
                    <img src="<?php echo $certification[0] ?>" alt="<?php echo $certification[1] ?>">
                </li>
            <?php endforeach ?>
        </ul>
    </div>

    <div class="container">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div>
                    <ul class="nav navbar-nav">
                        <?php foreach ($sites as $site): ?>
                            <li>
                                <a href="<?php echo $site->tt_url ?>"><?php echo $site->tt_name ?></a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <?php endif; ?>

    <?php // Start the footer area ?>
    <footer id="colophon" class="site-footer" role="contentinfo">

    <?php // Footer "sidebar" widget area (1 to 4 columns supported)
    get_sidebar( 'footer' );
    ?>

    <?php // Check for footer navbar (optional)
    global $xsbf_theme_options;
    $nav_menu = null;
    if ( function_exists('has_nav_menu') AND has_nav_menu( 'footer' ) ) {
        $nav_menu = wp_nav_menu(
            array( 'theme_location' => 'footer',
            'container_div'         => 'div', //'nav' or 'div'
            'container_class'         => '', //class for <nav> or <div>
            'menu_class'             => 'list-inline dividers', //class for <ul>
            'walker'                 => new wp_bootstrap_navwalker(),
            'fallback_cb'            => '',
            'echo'                    => false, // we'll output the menu later
            'depth'                    => 1,
            )
        );

    // If not, default one
    } elseif ( $xsbf_theme_options['sample_footer_menu'] ) {
            $nav_menu = '
            <div class="sample-menu-footer-container">
            <ul id="sample-menu-footer" class="list-inline dividers">
            <li id="menu-item-sample-1" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-sample-1"><a class="smoothscroll" title="'
            .__( 'Back to top of page', 'tauchterminal' )
            .'" href="#page"><span class="fa fa-angle-up"></span> '
            .__( 'Top', 'tauchterminal' )
            .'</a></li>
            <li id="menu-item-sample-2" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-sample-2"><a title="'
            .__( 'Home', 'tauchterminal' )
            .'" href="' . get_home_url() . '">'
            .__( 'Home', 'tauchterminal' )
            .'</a></li>
            </ul>
            </div>';
    } //endif has_nav_menu()
?>

    <?php // Check for site credits (can be overriden in a child theme)
    $theme = wp_get_theme();
    $site_credits = sprintf( __( '&copy; %1$s %2$s. Theme by %3$s.', 'tauchterminal' ),
        date ( 'Y' ),
        '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . get_bloginfo( 'name' ) . '</a>',
        '<a href="' . $theme->get( 'ThemeURI' ) . '" rel="profile" target="_blank">' . $theme->get( 'Author' ) . '</a>'
    );
    $site_credits = apply_filters( 'xsbf_credits', $site_credits );
     ?>

    <?php // If either footer nav or site credits, display them
    if ( $nav_menu OR $site_credits ) : ?>
    <div class="after-footer">
    <div class="container">

        <?php // Footer nav menu
        if ( $nav_menu ) : ?>
            <div class="footer-nav-menu pull-left">
            <nav id="footer-navigation" class="secondary-navigation" role="navigation">
                <h1 class="menu-toggle sr-only"><?php _e( 'Footer Menu', 'tauchterminal' ); ?></h1>
                <?php echo $nav_menu; ?>
            </nav>
            </div><!-- .footer-nav-menu -->
        <?php endif; ?>

        <?php // Footer site credits
        if ( $site_credits AND $nav_menu ) : ?>
            <div id="site-credits" class="site-credits pull-right">
            <?php echo $site_credits; ?>
            </div><!-- .site-credits -->
        <?php endif; ?>

    </div><!-- .container -->
    </div><!-- .after-footer -->
    <?php endif; ?>

    </footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
