<?php
    global $wpdb;

    $table = $wpdb->prefix."tt_sites";
    $structure = "CREATE TABLE $table (
        id INT(9) NOT NULL AUTO_INCREMENT,
        tt_name VARCHAR(80) NOT NULL,
        tt_desc VARCHAR(80) NOT NULL,
        tt_slug VARCHAR(80) NOT NULL,
        tt_url VARCHAR(80) NOT NULL,
        tt_logo VARCHAR(200) NOT NULL,
        tt_bg VARCHAR(200) NOT NULL,
    UNIQUE KEY id (id)
    );";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    $wpdb->query($structure);
?>
