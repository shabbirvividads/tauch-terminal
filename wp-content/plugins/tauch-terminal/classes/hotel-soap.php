<?php

class HotelsystemSoapClass
{

    function __construct() {
        // Get all the access values from Database
        $url = TauchTerminal_DB::getTTOption('soap_booking');

        $this->username = TauchTerminal_DB::getTTOption('soap_username');
        $this->password = TauchTerminal_DB::getTTOption('soap_password');
        $this->header_name = TauchTerminal_DB::getTTOption('header_name');
        $this->name_space = TauchTerminal_DB::getTTOption('soap_namespace');

        $this->soap = new SoapClient($url, array("trace" => false, "exceptions" => true));
    }

    // Build that header!
    private function build_auth_header() {
        $auth = array(
            'UserName' => $this->username,
            'Password' => $this->password
        );

        $header = new SoapHeader($this->name_space, $this->header_name, $auth);

        $this->soap->__setSoapHeaders($header);
    }

    /**
     * @param string $RoomId
     * @param dateTime $TheDate
     * @access public
     * @return boolean
     */
    public function IsRoomAvailable($RoomId, $TheDate) {
        $this->build_auth_header();
        try {
            $response = $this->soap->__soapCall('IsRoomAvailable', array($RoomId, $TheDate));
            if (is_array($response)) {
                return $response;
            }
        } catch (SoapFault $e) {
            write_TTT_log($e->faultstring);
            return $e->faultstring;
        }
    }

    /**
     * @param dateTime $TheDate
     * @param short $LengthOfStay
     * @access public
     * @return ArrayOfRooms
     */
    public function AvailableRooms($TheDate, $LengthOfStay) {
        if (!is_string($TheDate) || !(is_int($TheDate) || is_string($TheDate))) {
            return false;
        }

        $this->build_auth_header();
        try {
            $response = $this->soap->__soapCall('AvailableRooms', array($TheDate, $LengthOfStay));
            if (is_array($response)) {
                return $response;
            }
        } catch (SoapFault $e) {
            write_TTT_log($e->faultstring);
            return $e->faultstring;
        }
        return false;
    }

}
