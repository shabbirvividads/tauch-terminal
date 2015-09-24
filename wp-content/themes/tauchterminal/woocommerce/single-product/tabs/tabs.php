<?php
/**
 * Single Product tabs
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters('woocommerce_product_tabs', array());

if (! empty($tabs)) : ?>

    <div class="container">
        <!-- Nav tabs -->
        <ul class="tabs nav nav-tabs" role="tablist">
            <?php $isFirst = true; ?>
            <?php foreach ($tabs as $key => $tab) : ?>
                <li role="presentation" class="<?php echo esc_attr($key); ?>_tab<?php if ($isFirst): ?> active<?php endif; ?>">
                    <a href="#tab-<?php echo esc_attr($key); ?>" aria-controls="<?php echo esc_attr($key); ?>" role="tab" data-toggle="tab"><?php echo apply_filters('woocommerce_product_' . $key . '_tab_title', esc_html($tab['title']), $key); ?></a>
                </li>
                <?php $isFirst = false; ?>
            <?php endforeach; ?>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <?php $isFirst = true; ?>
            <?php foreach ($tabs as $key => $tab) : ?>
                <div role="tabpanel" class="tab-pane<?php if ($isFirst): ?> active<?php endif; ?>" id="tab-<?php echo esc_attr($key); ?>">
                    <?php call_user_func($tab['callback'], $key, $tab); ?>
                </div>
                <?php $isFirst = false; ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
