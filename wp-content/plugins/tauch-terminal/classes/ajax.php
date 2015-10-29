<?php

class TauchTerminal_Ajax {

    public static function prepareAjax() {
        $action = $_POST['tttaction'];
        $data = $_POST['data'];

        switch ($action) {
            case 'hotelsystem-availableRooms':
                return self::availableRooms($data);
                break;

            case 'hotelsystem-isRoomAvailable':
                self::IsRoomAvailable($data);
                break;

            default:
                # code...
                break;
        }
    }

    private static function availableRooms($data) {
        $hotel = new HotelsystemSoapClass();

        $date1 = new DateTime($data['start']);
        $date2 = new DateTime($data['end']);
        $interval = $date1->diff($date2);
        $response = $hotel->AvailableRooms($date1->format('Y-m-d'), $interval->format('%a'));

        if (!is_array($response)) {
            // $json = json_decode($response);
            wp_send_json(['error' => 'API Problems, please contact us by email']);
        }
        wp_send_json($response);
    }
}
