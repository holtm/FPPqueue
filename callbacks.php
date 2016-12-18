#!/usr/bin/php
<?
error_reporting(0);
//arg0 is  the program
//arg1 is the first argument in the registration this will be --list
//$DEBUG=true;
$logFile = "/home/pi/media/logs/fppqueue.log";
$callbackRegisters = "playlist\n";

switch ($argv[1])
	{
		case "--list":
			echo $callbackRegisters;
			logEntry("FPPD List Registration request: responded:". $callbackRegisters);
			exit(0);
		case "--type":
			//we got a register request message from the daemon
			processCallback($argv);	
			break;
		default:
			logEntry($argv[0]." called with no parameteres");
			break;	
	}
  
  function processCallback($argv) {
    global $DEBUG;
    if($DEBUG)
      print_r($argv);
    //argv0 = program

    //argv2 should equal our registration // need to process all the rgistrations we may have, array??
    //argv3 should be --data
    //argv4 should be json data
    $registrationType = $argv[2];
    $data =  $argv[4];
    logEntry($registrationType . " registration requestion from FPPD daemon");
    switch ($registrationType) 
	  {
      case "media":
      break;
      case "playlist";
      if($argv[3] == "--data"){
        $data=trim($data);
				logEntry("DATA: ".$data);
				$obj = json_decode($data);
      }
      break;
    }
 }
 function logEntry($data) {
	global $logFile;
	$data = $_SERVER['PHP_SELF']." : ".$data;
	$logWrite= fopen($logFile, "a") or die("Unable to open file!");
		fwrite($logWrite, date('Y-m-d h:i:s A',time()).": ".$data."\n");
		fclose($logWrite);
}
?>
