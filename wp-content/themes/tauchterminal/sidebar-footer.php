<?php
/**
 * Theme: Tauch Terminal Bootstrap
 *
 * The "sidebar" for the widgetized footer area. If no widgets added AND just preivewing
 * the theme, then display some widgets as samples. Once the theme is actually in use,
 * it will be empty until the user adds some actual widgets.
 *
 * @package tauchterminal
 */
?>

<?php
/* If footer "sidebar" has widgets, then display them */
$sidebar_footer = get_dynamic_sidebar('Footer');
if ($sidebar_footer) :
?>
    <div class="sidebar-footer clearfix">
    <div class="container">
        <div class="row">
        <?php echo apply_filters('xsbf_footer', $sidebar_footer); ?>
        </div><!-- .row -->
    </div><!-- .container -->
    </div><!-- .sidebar-footer -->

<?php
/* Otherwise, if user is previewing this theme, then show some examples */
/*
elseif (xsbf_theme_preview()) :
?>
    <div class="sidebar-footer clearfix">
    <div class="container">
        <div class="row">

            <aside id="recent-posts" class="widget widget_recent_posts col-sm-4 clearfix">
            <?php the_widget('WP_Widget_Recent_Posts', array ('number' => 3)); ?>
            </aside>

            <aside id="recent-comments" class="widget widget_recent_comments col-sm-4 clearfix">
            <?php the_widget('WP_Widget_Recent_Comments', array ('number' => 3)); ?>
            </aside>

            <aside id="sample-text" class="widget widget_text col-sm-4 clearfix">
                <h2 class="widget-title"><?php _e('About This Theme', 'tauchterminal'); ?></h2>
                <p><?php _e("You are previewing this theme, so we are showing some sample widgets here. Once you activate the theme, you can place from 1 to 4 widgets here or don't add any to remove this whole footer. Cool, huh?", 'tauchterminal'); ?></p>
            </aside>

        </div><!-- .row -->
    </div><!-- .container -->
    </div><!-- .sidebar-footer -->

<?php */ endif;?>
