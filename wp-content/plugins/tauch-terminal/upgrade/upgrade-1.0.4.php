<?php
    global $wpdb;
    $table = $wpdb->prefix."tt_certifications";

    $structure = "CREATE TABLE $table (
        id INT(9) NOT NULL AUTO_INCREMENT,
        name VARCHAR(80) NOT NULL,
        url VARCHAR(80) NOT NULL,
    UNIQUE KEY id (id)
    );";

    $wpdb->query($structure);

    $certifications = array(
            [1,"./wp-content/uploads/2015/07/ssi_diamond_resort.png", "ssi diamond instructor resort bali"],
            [2,"./wp-content/uploads/2015/07/diamond_diving_school.png", "ssi diamant tauchschule bali"],
            [3,"./wp-content/uploads/2015/07/unud.png", "udayana university partner"],
            [4,"./wp-content/uploads/2015/07/screwit.png", "lets dive bali campaign"],
            [5,"./wp-content/uploads/2015/07/comments_taucher.jpg", "tauch terminal bali kommentare auf taucher.net"],
            [6,"./wp-content/uploads/2015/07/unud_text_dt.png", "udayana university partner"],
            [7,"./wp-content/uploads/2015/07/tauchterminal.png", "tauch terminal dive resort tulamben"],
            [8,"./wp-content/uploads/2015/07/resort.png", "SSI dive education &amp; licenses"],
            [9,"./wp-content/uploads/2015/07/liveaboard.png", "indonedsia liveaboard tauch kreuzfahrten"]
        );

    foreach ($certifications as $certification) {
        $wpdb->insert($table,
            array(
                'name' => $certification[2],
                'url' => $certification[1]
            )
        );
    }
    update_site_option('tt_version', '1.0.4');
?>
