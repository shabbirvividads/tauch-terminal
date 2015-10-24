<?php

class HotelsystemSoapClass
{

    function __construct(){
        // Get all the access values from Database
        $url = TauchTerminal_DB::getTTOption('soap_booking');
        $this->username = TauchTerminal_DB::getTTOption('soap_username');
        $this->password = TauchTerminal_DB::getTTOption('soap_password');
        $this->header_name = TauchTerminal_DB::getTTOption('header_name');
        $this->name_space = TauchTerminal_DB::getTTOption('soap_namespace');
        $this->soap = new SoapClient($url, array("trace" => false, "exceptions" => true));
    }

    // Build that header!
    private function build_auth_header(){
        // Build an object with parameters
        $auth = new stdClass();
        $auth->username = $this->username;
        $auth->password = $this->password;

        $authvalues = new SoapVar($auth, SOAP_ENC_OBJECT);
        $header = new SoapHeader(
            $this->name_space,
            $this->header_name,
            $authvalues,
            false
        );

        $this->soap->__setSoapHeaders(array($header));

    }

    // Wrapper so we can build auth header first
    public function AvailableRooms($params = null){

        $this->build_auth_header();
        return $this->soap->AvailableRooms($params);
    }

}
