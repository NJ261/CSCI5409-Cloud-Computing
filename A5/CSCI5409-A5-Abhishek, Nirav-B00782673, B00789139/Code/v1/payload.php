<?php
    ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 300); //300 seconds = 5 minutes

    // Ref - https://www.whileifblog.com/2010/07/19/php-calculate-script-execution-time/
    //Create a variable for start time
    $time_start = microtime(true);

    // get the HTTP method, path and body of the request
    $method = $_SERVER['REQUEST_METHOD'];
    // URL path to handle the request
    $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));

    //echo "Method=>".$method."<BR>Request=>";print_r($request);

    // PATH_INFO should have two parameter all the time i.e. ID and Size of text to be return
    if ( $method !== "GET" || !is_numeric($request[0])|| count($request) < 2 || $request[1] < 10 || $request[1] > 100000 ) {
        $retrunData = array (array("Message"=>" Please use 'GET' method with following parameters ID and PayloadSize e.g. payload.php/5/10 !! "));
        header('Content-type: application/json');
        header('HTTP/1.0 400 Bad Request');
        exit(json_encode($retrunData));
    }

    //payload.php/5/10
    $retrunData = array();
    $id = $request[0];
    $payloadSize = $request[1];
    $timestamp = date('m-d- h:i:s a', time());
    //Ref - W3CSchool
    $handle = fopen("./inputfile.txt", "r");   // Test File from https://speed.hetzner.de/
    if ($handle) {
        while (($buffer = fgets($handle, $payloadSize)) !== false) {
            $data = $buffer;
        }
        fclose($handle);
    }
    //Subtract the two times to get seconds
    $executionTime = (microtime(true) - $time_start)*1000;
    $retrunData[] = array("Request ID"=>$id, "Timestamp"=>$timestamp, "Actual Payload"=>$data, "Total web service execution delay"=>"$executionTime" );
    header('Content-type: application/json');
    header('HTTP/1.0 200 OK');
    exit(json_encode($retrunData));


    $retrunData = array (array("Message"=>" Something went wrong, please try again !! "));
    header('Content-type: application/json');
    header('HTTP/1.0 500 Internal Server Error');
    exit(json_encode($retrunData));

?>