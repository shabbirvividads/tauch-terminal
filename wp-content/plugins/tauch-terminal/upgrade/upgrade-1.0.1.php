<?php
    global $wpdb;
    $table = $wpdb->prefix."tt_default_site";

    $structure = "CREATE TABLE $table (
      `id` int(9) NOT NULL AUTO_INCREMENT,
      `url` varchar(80) NOT NULL,
      `current` int(11) DEFAULT NULL,
      UNIQUE KEY `id` (`id`)
    );";

    $wpdb->query($structure);

    update_site_option('tt_version', '1.0.1');
?>
