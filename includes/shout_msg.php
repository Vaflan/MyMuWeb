<?php
////////////////////////////////////////////////////////////////////////////
// PHP Script to Send a public message inside the game from the website.  //
// It will appear just like the Golden Invasion text                      //
// Made by: Sandbird                                                      //
////////////////////////////////////////////////////////////////////////////

function ascii2hex($ascii) {
	$hex = '';
	for ($i = 0; $i < strlen($ascii); $i++) {
		$byte = strtoupper(dechex(ord($ascii{$i})));
		$byte = str_repeat('0', 2 - strlen($byte)).$byte;
		$hex.=$byte." ";
		}
		$hex=str_replace(" ", "", $hex);
		return $hex;
}

function hex2ascii($hex){
	$ascii='';
	$hex=str_replace(" ", "", $hex);
	for($i=0; $i<strlen($hex); $i=$i+2) {
		$ascii.=chr(hexdec(substr($hex, $i, 2)));
		}
		return($ascii);
}
function int_int_divide($x, $y) {
//Returns the integer division of $x/$y. 
    if ($x == 0) return 0;
    if ($y == 0) return FALSE;
    return ($x % $y >= $y / 2) ?
        (($x - ($x % $y)) / $y) + 1 : ($x - ($x % $y)) / $y;
}

function send_gm_msg($host, $port, $msg)
{  
    $header = "C144A10024000000";   // Starting header of the message
    $msglength = strlen($msg);	// Length of message

if ($msglength < 34 && $msglength != 0){	// Starting calculations to divide the message box so the message looks centerd
    $divisor = (34 - $msglength);
    $start_space = int_int_divide($divisor , 2);
    
    for ($i=0;$i<=$start_space;$i++){
    	$header .= "20";
    	}
    	$header .= ascii2hex($msg);   // Insert the message in the packet
    		
	   for ($j=0;$j<=($divisor-$start_space);$j++){
	   $header .= "20";
	   }
}else{						// If the message is longer that 64 chars no need for spaces
		$header .= ascii2hex($msg);   // Insert the message in the packet if msg > 34
		}

    $header .= "00BED3410000F8BBB90400000000FCBBB904A4FF1A06F8F04100FFFFFFFF"; // Remainding header
    $packet = hex2ascii($header);   							 // Convert the whole string to ascii 
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    
		if (!$x = @socket_connect($socket, $host, $port)) 			// attempt to connect
        {
            echo "No access to the Joinserver or Server is down.";
        }
        else
       {
        	socket_write($socket, $packet , strlen($packet)); 			// Send the packet to the Joinserver
        	socket_close($socket); 				// Close connection (i dont know if this is needed or not).
      }
return "yes";
}
// If you want to post the message from another page then remove the // from the line below
// and add them on the other line. If you dont know how to do that then if your page is 
// located for example at http://website.com/shout.php 
// just write this at the header: http://website.com/shout.php?msg=And put your msg here.

// send_msg("127.0.0.1", "55970", $msg);
?>