<?php
/**
 * Meta Boxes
 *
 * Sets up the write panels used by products and orders (custom post types)
 *
 * @category    Admin
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * WC_Admin_Meta_Boxes
 */
class TauchTerminal_Admin_Meta_Boxes {

    private static $saved_meta_boxes = false;
    private static $meta_box_errors  = array();
    private static $meta_box_success  = array();
    private static $meta_box_warning  = array();

    /**
     * Constructor
     */
    public function __construct() {
        // add_action('add_meta_boxes', array($this, 'remove_meta_boxes'), 10);
        // add_action('add_meta_boxes', array($this, 'rename_meta_boxes'), 20);
        // add_action('add_meta_boxes', array($this, 'add_meta_boxes'), 30);
        // add_action('save_post', array($this, 'save_meta_boxes'), 1, 2);

        // Error handling (for showing errors from meta boxes on next page load)
        add_action('admin_notices', array($this, 'output_notices'));
        add_action('shutdown', array($this, 'save_notices'));
    }

    /**
     * Add an messages
     * @param string $text
     * @param string $type, default warning
     */
    public static function add_notice($text, $type = '') {
        switch ($type) {
            case 'error':
                self::$meta_box_errors[] = $text;
                break;
            case 'success':
                self::$meta_box_success[] = $text;
                break;
            default:
                self::$meta_box_warning[] = $text;
                break;
        }
    }

    /**
     * Save errors to an option
     */
    public function save_notices() {
        update_option('tauchterminal_meta_box_errors', self::$meta_box_errors);
        update_option('tauchterminal_meta_box_success', self::$meta_box_success);
        update_option('tauchterminal_meta_box_warning', self::$meta_box_warning);
    }

    /**
     * Show any stored error messages.
     */
    public function output_notices_html($notices, $type) {
        echo '<div id="tauchterminal_errors" class="'. $type .' fade">';
        foreach ($notices as $notice) {
            echo '<p>' . wp_kses_post($notice) . '</p>';
        }
        echo '</div>';
    }

    public function output_notices() {
        $errors = maybe_unserialize(get_option('tauchterminal_meta_box_errors'));
        if (!empty($errors)) {
            self::output_notices_html($errors, 'error');
            // Clear
            delete_option('tauchterminal_meta_box_errors');
        }
        $success = maybe_unserialize(get_option('tauchterminal_meta_box_success'));
        if (!empty($success)) {
            self::output_notices_html($success, 'updated');
            // Clear
            delete_option('tauchterminal_meta_box_success');
        }
        $warning = maybe_unserialize(get_option('tauchterminal_meta_box_warning'));
        if (!empty($warning)) {
            self::output_notices_html($warning, 'warning');
            // Clear
            delete_option('tauchterminal_meta_box_warning');
        }
    }
}

new TauchTerminal_Admin_Meta_Boxes();
