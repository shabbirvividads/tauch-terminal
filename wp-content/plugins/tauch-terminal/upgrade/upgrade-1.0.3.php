<?php
    global $wpdb;
    $table = $wpdb->prefix."tt_settings";

    $old_table = $wpdb->prefix."tt_tulamben_settings";
    $wpdb->query("RENAME TABLE $old_table TO $table");

    $wpdb->query("DROP TABLE IF EXISTS $old_table");

    $table = $wpdb->prefix."tt_default_site";
    $wpdb->query("DROP TABLE IF EXISTS $table");

    update_site_option('tt_version', '1.0.3');
?>
