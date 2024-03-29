<?php

class TauchTerminal_Sites {

    public static function display_sites() {
        $action = '';
        $data = '';
        $view = 'list';
        $sites = self::getSites();

        if (isset($_POST['action'])) {
            $action = $_POST['action'];
            $data = $_POST;
        } else if (isset($_GET['action'])) {
            $action = $_GET['action'];
            $data = $_GET;
        }

        switch ($action) {
            case 'add':
                TauchTerminal::view('sites/edit', array('action' => 'save-new'));
                break;
            case 'save-new':
                $id = TauchTerminal_Sites::addSites($data);
                $sites = self::getSites(array($id));
                TauchTerminal::view('sites/edit', array('site' => $sites[0], 'action' => 'save-edit'));
                break;
            case 'edit':
                $sites = self::getSites($data["post"]);
                TauchTerminal::view('sites/edit', array('site' => $sites[0], 'action' => 'save-edit'));
                break;
            case 'save-edit':
                $id = TauchTerminal_Sites::updateSites($data);
                $sites = self::getSites(array($id));
                TauchTerminal::view('sites/edit', array('site' => $sites[0], 'action' => 'save-edit'));
                break;
            case 'trash':
            default:
                if ($action == 'trash') {
                    TauchTerminal_Sites::deleteSites($data["post"]);
                }
                wp_enqueue_style(
                    'tauch-terminal-styles',
                    plugins_url('css/edit.css', __FILE__)
                );
                TauchTerminal::view('sites/list', array( 'sites' => $sites ));
                break;
        }
    }

    public static function default_website() {
        if (isset($_POST['action'])) {
            $action = $_POST['action'];
            TauchTerminal_DB::saveSettings($_POST);
        }
        $sites = self::getSites();
        $site = TauchTerminal_DB::getTTOption('default_site');
        $url = TauchTerminal_DB::getTTOption('default_prefix');
        TauchTerminal::view('sites/default', array('sites' => $sites, 'current' => $site, 'url' => $url));
    }

    public static function getSites($id = array()) {
        global $wpdb;
        $prefix = self::getPrefix();
        $table = $prefix."tt_sites"; // fixed for display on other sites
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
        if (!self::validation($data)) {
            return false;
        }
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
        return $wpdb->insert_id;
    }

    public static function updateSites($data) {
        global $wpdb;
        $table = $wpdb->prefix."tt_sites";
        if (!self::validation($data)) {
            return false;
        }
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
        return $data['id'];
    }

    public static function deleteSites($data) {
        global $wpdb;
        $table = $wpdb->prefix."tt_sites";
        foreach ($data as $key => $value) {
            $wpdb->delete($table, array('id' => $value));
        }
    }

    public static function validation($data) {
        $error = array();
        if (!isset($data['tt_name']) || $data['tt_name'] == '') {
            $error[] = __('name', 'tauch-terminal');
        }
        if (!isset($data['tt_desc']) || $data['tt_desc'] == '') {
            $error[] = __('description', 'tauch-terminal');
        }
        if (!isset($data['tt_slug']) || $data['tt_slug'] == '') {
            $error[] = __('slug', 'tauch-terminal');
        }
        if (!isset($data['tt_url']) || $data['tt_url'] == '') {
            $error[] = __('url', 'tauch-terminal');
        }
        if (!isset($data['tt_logo']) || $data['tt_logo'] == '') {
            $error[] = __('logo', 'tauch-terminal');
        }
        if (!isset($data['tt_bg']) || $data['tt_bg'] == '') {
            $error[] = __('background', 'tauch-terminal');
        }
        if (!empty($error)) {
            $text = sprintf(__('There is no %s set', 'tauch-terminal'), implode(", ", $error));
            TauchTerminal_Admin_Meta_Boxes::add_notice($text, 'error');
            return false;
        }
        TauchTerminal_Admin_Meta_Boxes::add_notice(__('Site successfully saved', 'tauch-terminal'), 'success');
        return true;
    }

    public static function getCurrentSite() {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $id = TauchTerminal_DB::getTTOption('default_site');
        $current = TauchTerminal_Sites::getSites(array($id));
        if ($current)
            return $current[0];
        return false;
    }

    private static function getPrefix() {
        global $wpdb;
        $prefix = $wpdb->prefix;

        $url = TauchTerminal_DB::getTTOption('default_prefix');
        if (get_current_blog_id() != 1 && $url) {
            $prefix = $url;
        }
        return $prefix;
    }
}
