<?php

class TauchTerminal_Sites {

    public static function display_sites() {
        $action = '';
        $data = '';
        $view = false;

        if (isset($_POST['action'])) {
            $action = $_POST['action'];
            $data = $_POST;
        } else if (isset($_GET['action'])) {
            $action = $_GET['action'];
            $data = $_GET;
        }

        switch ($action) {
            case 'add':
                $view = true;
                TauchTerminal::view('sites/edit', array('action' => 'save-new'));
                break;
            case 'save-new':
                TauchTerminal::addSites($data);
                break;
            case 'edit':
                $view = true;
                $sites = self::getSites($data["post"]);
                TauchTerminal::view('sites/edit', array('site' => $sites[0], 'action' => 'save-edit'));
                break;
            case 'save-edit':
                TauchTerminal::updateSites($data);
                break;
            case 'trash':
                var_dump($data);
                TauchTerminal::deleteSites($data["post"]);
            default:
                break;
        }

        if ($view == false) {
            $sites = self::getSites();
            wp_enqueue_style(
                'tauch-terminal-styles',
                plugins_url('css/edit.css', __FILE__)
            );
            TauchTerminal::view('sites/list', array( 'sites' => $sites ));
        }
    }

    public static function getSites($id = array()) {
        global $wpdb;
        $table = $wpdb->prefix."tt_sites";
        $select = "SELECT * FROM $table";
        if ($id !== array()) {
            $select .= " WHERE `id` IN (" . implode(',', array_map('intval', $id)) . ")";
        }
        $sites = $wpdb->get_results($select);
        return $sites;
    }

    public static function addSites($data) {
        global $wpdb;
        $table = $wpdb->prefix."tt_sites";
        $wpdb->insert($table,
            array(
                'tt_name' => $data['tt_name'],
                'tt_desc' => $data['tt_desc'],
                'tt_slug' => $data['tt_slug'],
                'tt_url' => $data['tt_url'],
                'tt_logo' => $data['tt_logo'],
                'tt_bg' => $data['tt_bg']
            )
        );
    }

    public static function updateSites($data) {
        global $wpdb;
        $table = $wpdb->prefix."tt_sites";
        $wpdb->update($table,
            array(
                'tt_name' => $data['tt_name'],
                'tt_desc' => $data['tt_desc'],
                'tt_slug' => $data['tt_slug'],
                'tt_url' => $data['tt_url'],
                'tt_logo' => $data['tt_logo'],
                'tt_bg' => $data['tt_bg']
            ),
            array('id' => $data['id'])
        );
    }

    public static function deleteSites($data) {
        global $wpdb;
        $table = $wpdb->prefix."tt_sites";
        foreach ($data as $key => $value) {
            $wpdb->delete($table, array('id' => $value));
        }
    }
}
