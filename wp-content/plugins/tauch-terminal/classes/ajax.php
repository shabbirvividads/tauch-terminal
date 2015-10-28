<?php

class TauchTerminal_Ajax {

    public static function prepareAjax() {
        $action = $_POST['tttaction'];
        $data = $_POST;

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
        // $other_data = $_POST['other_data'];
        // die('called');
        //  wp_send_json('{"works":"foobar"}');
    }

    private static function availableRooms($data) {
        $hotel = new HotelsystemSoapClass();
        $response = $hotel->AvailableRooms('2016-04-19', 9);
        wp_send_json($response);
    }
}
