<?php

class SevOneSOAP {
  
  function __construct() {
    $this->client = connect();
  }

  function connect() {
    ini_set( "soap.wsdl_cache_enabled", 0 );

    $soapURL = $_ENV["SEVONE_URL"];
    $user = $_ENV["SEVONE_USER"];
    $password = $_ENV["SEVONE_PASSWORD"];

    $client = new SoapClient($soapURL, array( 'trace' => 1 ) );

    if (!$client) {
      echo '!!! Could not connect to SOAP server.';
      exit( 1 );
    } else {

      try {
        $result = $client->authenticate( '$user', '$password' );
        if ( $result ) {
          return $client;
        } else {
          echo 'Authentication Failed';
          exit( 1 );
        }
      } catch ( Exception $e ) {
        print_r( $e );
        exit( 1 );
      }
    }
  }
}
?>
