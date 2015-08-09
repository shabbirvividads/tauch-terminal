<?php
    global $wpdb;
    $table = $wpdb->prefix."tt_tulamben_settings";

    $structure = "CREATE TABLE $table (
        id INT(9) NOT NULL AUTO_INCREMENT,
        option_name VARCHAR(80) NOT NULL,
        option_value VARCHAR(200) NOT NULL,
    UNIQUE KEY id (id)
    );";

    $wpdb->query($structure);

    update_site_option('tt_version', '1.0.2');
?>
