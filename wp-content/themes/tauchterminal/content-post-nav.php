<?php
/**
 * Theme: Flat Bootstrap
 *
 * The template used for displaying links to the next and previous post
 *
 * @package tauchterminal
 */
?>

<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="post-navigation">

    <h1 class="screen-reader-text sr-only"><?php _e( 'Post navigation', 'tauchterminal' ); ?></h1>

    <ul class="pager">
        <?php next_post_link( '<li class="nav-next">%link</li>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'tauchterminal' ) . '</span> %title' ); ?>
        <?php previous_post_link( '<li class="nav-previous">%link</li>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'tauchterminal' ) . '</span>' ); ?>
    </ul>

</nav>
