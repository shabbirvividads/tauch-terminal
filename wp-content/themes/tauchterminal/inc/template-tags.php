<?php
/**
 * Theme: Tauch Terminal Bootstrap
 *
 * Functions that relate to any tags or functions used in the WordPress templates.
 *
 * Functions for comments, multi-category blog, excerpts, etc.
 *
 * @package tauchterminal
 */

/*
 * Helper function so we can check sidebar for content before displaying it.
 * Note: This function may end up in WordPress Core, but doesn't exist as of v3.8
 */
if (! function_exists('get_dynamic_sidebar')) :
function get_dynamic_sidebar($index = 1) {
    $sidebar_contents = "";
    ob_start();
    dynamic_sidebar($index);
    $sidebar_contents = ob_get_clean();
    return $sidebar_contents;
} //endfunction
endif; // end ! function_exists

/*
 * Helper function to check if the theme is only being previewed from Admin as opposed
 * to displayed as the active theme
 *
 * NOTE: THIS FUNCTION IS DEPRECATED AS IT IS NOT RECOMMENDED FOR USE BY WORDPRESS.ORG
 */
if (! function_exists('xsbf_theme_preview')) :
function xsbf_theme_preview() {
/*
    if (isset ($_SERVER['HTTP_REFERER'])) {
        if (stripos($_SERVER['HTTP_REFERER'], 'customize.php') !== false) return true;
    }
*/
    return false;
} //endfunction
endif; // end ! function_exists

/**
 * Remove the [...] from the excerpt (will replace it next)
 */
if (! function_exists('xsbf_excerpt_more')) :
add_filter('excerpt_more', 'xsbf_excerpt_more');
function xsbf_excerpt_more($more) {
    return '';
}
endif; // end ! function_exists

/**
 * Add the read more link to excerpts, except for image attachment pages
 */
if (! function_exists('xsbf_get_the_excerpt')) :
add_filter('get_the_excerpt', 'xsbf_get_the_excerpt');
function xsbf_get_the_excerpt($excerpt) {

    if (! is_attachment()) {
        if ($excerpt) {
            $excerpt .= '&hellip; ';
        }
        $excerpt .= '<a class="read-more" href="'. get_permalink(get_the_ID()) . '">' . __('Read More', 'tauchterminal') . '</a>';
    }
    return $excerpt;
}
endif; // end ! function_exists

/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
if (! function_exists('xsbf_comment')) :
function xsbf_comment($comment, $args, $depth) {

    $GLOBALS['comment'] = $comment;

    if ('pingback' == $comment->comment_type || 'trackback' == $comment->comment_type) : ?>

    <li id="comment-<?php comment_ID(); ?>" <?php comment_class('row'); ?>>
        <div class="comment-body col-xs-12">
            <?php _e('Pingback:', 'tauchterminal'); ?> <?php comment_author_link(); ?>
            <?php edit_comment_link(__('<span class="glyphicon glyphicon-edit"></span> Edit', 'tauchterminal'), '<span class="edit-link">', '</span>'); ?>
        </div>

    <?php else : ?>

    <li id="comment-<?php comment_ID(); ?>" <?php comment_class(array('row', empty($args['has_children']) ? '' : 'parent')); ?>>
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body clearfix">
            <?php if ('0' == $comment->comment_approved) : ?>
                <div class="comment-meta col-xs-12"><p class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'tauchterminal'); ?></p></div>
            <?php endif; ?>
            <div class="comment-meta col-xs-3 col-sm-2">
                <div class="comment-author vcard">
                    <?php if (0 != $args['avatar_size']) echo get_avatar($comment, $args['avatar_size']); ?>
                </div><!-- .comment-author -->
            </div><!-- .comment-meta -->

            <div class="col-xs-9 col-sm-10">
                <div class="comment-metadata">

                    <p class="comment-author-title">
                        <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                            <?php echo  get_comment_author($comment->comment_ID)  ?>
                        </a><br/>
                        <span class="glyphicon glyphicon-calendar"></span>
                        <time datetime="<?php comment_time('c'); ?>">
                            <?php printf(_x('%1$s', '1: date', 'tauchterminal'), get_comment_date()); ?>
                        </time>
                    </p>
                    <?php edit_comment_link(__('Edit', 'tauchterminal'), '<span class="edit-link"><span class="glyphicon glyphicon-edit"></span> ', '</span>'); ?>
                </div><!-- .comment-metadata -->
            </div>

            <div class="col-xs-9 col-sm-10">
                <div class="comment-content">
                    <?php comment_text(); ?>
                </div><!-- .comment-content -->
            </div>

            <div class="col-xs-9 col-sm-10 col-xs-offset-3 col-sm-offset-2">
            <?php
                comment_reply_link(array_merge($args, array(
                    'add_below' => 'div-comment',
                    'depth'     => $depth,
                    'max_depth' => $args['max_depth'],
                    'before'    => '<div class="reply">',
                    'after'     => '</div>',
                )));
            ?>
            </div>
        </article><!-- .comment-body -->

    <?php
    endif;
}
endif; // ends check for xsbf_comment()

/**
 * Prints the attached image with a link to the next attached image.
 */
if (! function_exists('xsbf_the_attached_image')) :
function xsbf_the_attached_image() {
    $post                = get_post();
    $attachment_size     = apply_filters('xsbf_attachment_size', array(1200, 1200));
    $next_attachment_url = wp_get_attachment_url();

    /**
     * Grab the IDs of all the image attachments in a gallery so we can get the
     * URL of the next adjacent image in a gallery, or the first image (if
     * we're looking at the last image in a gallery), or, in a gallery of one,
     * just the link to that image file.
     */
    $attachment_ids = get_posts(array(
        'post_parent'    => $post->post_parent,
        'fields'         => 'ids',
        'numberposts'    => -1,
        'post_status'    => 'inherit',
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'order'          => 'ASC',
        'orderby'        => 'menu_order ID'
    ));

    // If there is more than 1 attachment in a gallery...
    if (count($attachment_ids) > 1) {
        foreach ($attachment_ids as $attachment_id) {
            if ($attachment_id == $post->ID) {
                $next_id = current($attachment_ids);
                break;
            }
        }

        // get the URL of the next image attachment...
        if ($next_id)
            $next_attachment_url = get_attachment_link($next_id);

        // or get the URL of the first image attachment.
        else
            $next_attachment_url = get_attachment_link(array_shift($attachment_ids));
    }

    printf('<a href="%1$s" rel="attachment">%2$s</a>',
        esc_url($next_attachment_url),
        wp_get_attachment_image($post->ID, $attachment_size)
    );
}
endif;

/**
 * Returns true if a blog has more than 1 category
 */
if (! function_exists('xsbf_categorized_blog')) {
function xsbf_categorized_blog() {
    if (false === ($all_the_cool_cats = get_transient('all_the_cool_cats'))) {
        // Create an array of all the categories that are attached to posts
        $all_the_cool_cats = get_categories(array(
            'hide_empty' => 1,
        ));

        // Count the number of categories that are attached to the posts
        $all_the_cool_cats = count($all_the_cool_cats);

        set_transient('all_the_cool_cats', $all_the_cool_cats);
    }

    if ('1' != $all_the_cool_cats) {
        // This blog has more than 1 category so xsbf_categorized_blog should return true
        return true;
    } else {
        // This blog has only 1 category so xsbf_categorized_blog should return false
        return false;
    }
}
} // ! function_exists

/**
 * Flush out the transients used in xsbf_categorized_blog
 */
if (! function_exists('xsbf_category_transient_flusher')) {
function xsbf_category_transient_flusher() {
    // Like, beat it. Dig?
    delete_transient('all_the_cool_cats');
}
add_action('edit_category', 'xsbf_category_transient_flusher');
add_action('save_post',     'xsbf_category_transient_flusher');
} // ! function_exists
