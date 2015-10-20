<?php
/**
 * Theme: Tauch Terminal Bootstrap
 *
 * The "sidebar" for the bottom of the page (before the widgetized footer area). If no
 * widgets added AND preivewing the theme, then display some widgets as samples. Once the
 * theme is actually in use, it will be empty until the user adds some actual widgets.
 *
 * @package tauchterminal
 */
?>

<?php
global $xsbf_theme_options;

/* If page bottom "sidebar" has widgets, then display them */
$sidebar_pagebottom = get_dynamic_sidebar('Page Bottom');
if ($sidebar_pagebottom) :
?>
    <div id="sidebar-pagebottom" class="sidebar-pagebottom bg-orange">
        <?php echo apply_filters('xsbf_pagebottom', $sidebar_pagebottom); ?>
    </div><!-- .sidebar-pagebottom -->

<?php
/* Otherwise, if user is previewing this theme, then show an example */
elseif ($xsbf_theme_options['sample_widgets']) :
?>
    <div id="sidebar-pagebottom" class="sidebar-pagebottom">

        <aside id="sample-text" class="widget widget_text section bg-orange centered clearfix">
        <div class="container">
        <h2 class="widget-title"><?php _e('Check out our rooms', 'tauchterminal'); ?></h2>
        <div class="textwidget">
        <div class="row">
        <div class="col-lg-8">
        <p><?php _e("If you book directly over us, we grant you a <b>20%</b> discount.", 'tauchterminal'); ?></p>
        <p><a href="http://ttt-bali.de/product/deluxe-double/" class="btn btn-hollow btn-lg"><?php _e('Go to the deluxe double', 'tauchterminal'); ?></a></p>

        </div><!-- col-lg-8 -->
        </div><!-- row -->
        </div><!-- textwidget -->
        </div><!-- container -->
        </aside>

    </div><!-- .sidebar-pagebottom -->

<?php endif;?>
