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
                $sites = TauchTerminal::getSites($data["post"]);
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
            $sites = TauchTerminal::getSites();
            wp_enqueue_style(
                'tauch-terminal-styles',
                plugins_url('css/edit.css', __FILE__)
            );
            TauchTerminal::view('sites/list', array( 'sites' => $sites ));
        }
    }
}
