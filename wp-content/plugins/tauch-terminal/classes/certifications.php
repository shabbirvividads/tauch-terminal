<?php

class TauchTerminal_Certifications {

    public static function display_certifications() {
        $action = '';
        $data = '';
        $view = 'list';
        $certifications = self::getCertifications();

        if (isset($_POST['action'])) {
            $action = $_POST['action'];
            $data = $_POST;
        } else if (isset($_GET['action'])) {
            $action = $_GET['action'];
            $data = $_GET;
        }

        switch ($action) {
            case 'add':
                TauchTerminal::view('certifications/edit', array('action' => 'save-new'));
                break;
            case 'save-new':
                $id = self::addCertifications($data);
                $certifications = self::getCertifications(array($id));
                TauchTerminal::view('certifications/edit', array('certification' => $certifications[0], 'action' => 'save-edit'));
                break;
            case 'edit':
                $certifications = self::getCertifications($data["post"]);
                TauchTerminal::view('certifications/edit', array('certification' => $certifications[0], 'action' => 'save-edit'));
                break;
            case 'save-edit':
                $id = self::updateCertifications($data);
                $certifications = self::getCertifications(array($id));
                TauchTerminal::view('certifications/edit', array('certification' => $certifications[0], 'action' => 'save-edit'));
                break;
            case 'trash':
            default:
                if ($action == 'trash') {
                    TauchTerminal_Certifications::deleteCertifications($data["post"]);
                }
                wp_enqueue_style(
                    'tauch-terminal-styles',
                    plugins_url('css/edit.css', __FILE__)
                );
                TauchTerminal::view('certifications/list', array( 'certifications' => $certifications ));
                break;
        }
    }

    public static function getCertifications($id = array()) {
        global $wpdb;
        $table = $wpdb->prefix."tt_certifications"; // fixed for display on other certifications
        $select = "SELECT * FROM $table";
        if ($id !== array()) {
            $select .= " WHERE `id` IN (" . implode(',', array_map('intval', $id)) . ")";
        }
        $certifications = $wpdb->get_results($select);
        return $certifications;
    }

    public static function addCertifications($data) {
        global $wpdb;
        $table = $wpdb->prefix."tt_certifications";
        $wpdb->insert($table,
            array(
                'name' => $data['name'],
                'url' => $data['url']
            )
        );
        return $wpdb->insert_id;
    }

    public static function updateCertifications($data) {
        global $wpdb;
        $table = $wpdb->prefix."tt_certifications";
        $wpdb->update($table,
            array(
                'name' => $data['name'],
                'url' => $data['url']
            ),
            array('id' => $data['id'])
        );
        return $data['id'];
    }

    public static function deleteCertifications($data) {
        global $wpdb;
        $table = $wpdb->prefix."tt_certifications";
        foreach ($data as $key => $value) {
            $wpdb->delete($table, array('id' => $value));
        }
    }
}
