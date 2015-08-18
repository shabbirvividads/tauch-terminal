<?php
/**
 * Theme: Tauch Terminal Bootstrap
 *
 * The template used for displaying single post footer meta (categories, tags, etc.)
 *
 * @package tauchterminal
 */
?>

<?php if ( ! is_search() ) : ?>

    <footer class="entry-meta">

        <?php if ( ! function_exists( 'xsbf_categorized_blog' ) OR xsbf_categorized_blog() ) : ?>
            <?php $categories = get_the_category_list( ', ' ); ?>
            <?php if ( $categories ) : ?>
                <span class="cat-links"><span class="glyphicon glyphicon-tag"></span>&nbsp;
                <?php echo $categories; ?>
                </span>
            <?php endif; ?>
        <?php endif; ?>

        <?php the_tags( '<span class="tags-links"><span class="glyphicon glyphicon-tags"></span> &nbsp;', ', ', '</span>' ); ?>

        <?php edit_post_link( __( '<span class="glyphicon glyphicon-edit"></span> Edit', 'tauchterminal' ), '<span class="edit-link">', '</span>' ); ?>

    </footer><!-- .entry-meta -->

<?php endif; ?>

