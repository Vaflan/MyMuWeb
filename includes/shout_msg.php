<?php
////////////////////////////////////////////////////////////////////////////
// PHP Script to Send a public message inside the game from the website.  //
// It will appear just like the Golden Invasion text                      //
// Made by: Sandbird                                                      //
////////////////////////////////////////////////////////////////////////////

function ascii2hex($ascii)
{
	$hex = '';
	for ($i = 0; $i < strlen($ascii); $i++) {
		$byte = strtoupper(dechex(ord($ascii{$i})));
		$byte = str_repeat('0', 2 - strlen($byte)) . $byte;
		$hex .= $byte; // . ' ';
	}
	return $hex;
}

function hex2ascii($hex)
{
	$ascii = '';
	$hex = str_replace(' ', '', $hex);
	for ($i = 0; $i < strlen($hex); $i = $i + 2) {
		$ascii .= chr(hexdec(substr($hex, $i, 2)));
	}
	return ($ascii);
}

function int_int_divide($x, $y)
{
//Returns the integer division of $x/$y. 
	if ($x == 0) return 0;
	if ($y == 0) {
		error_log('int_int_divide: ' . $x . ', ' . $y);
		return false;
	}
	return ($x % $y >= $y / 2)
		? (($x - ($x % $y)) / $y) + 1
		: ($x - ($x % $y)) / $y;
}

function send_gm_msg($host, $port, $msg)
{
	$header = 'C144A10024000000';   // Starting header of the message
	$msgLength = strlen($msg);    // Length of message

	if ($msgLength < 34 && $msgLength != 0) {    // Starting calculations to divide the message box so the message looks centerd
		$divisor = (34 - $msgLength);
		$start_space = int_int_divide($divisor, 2);

		$header .= str_repeat('20', $start_space + 1);
		$header .= ascii2hex($msg);   // Insert the message in the packet
		$header .= str_repeat('20', ($divisor - $start_space) + 1);
	} else {                          // If the message is longer than 64 chars no need for spaces
		$header .= ascii2hex($msg);   // Insert the message in the packet if msg > 34
	}

	$header .= '00BED3410000F8BBB90400000000FCBBB904A4FF1A06F8F04100FFFFFFFF'; // Remainding header
	$packet = hex2ascii($header);                             // Convert the whole string to ascii
	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

	if (!@socket_connect($socket, $host, $port))            // attempt to connect
	{
		echo 'No access to the JoinServer or service is down.';
	} else {
		socket_write($socket, $packet, strlen($packet));            // Send the packet to the JoinServer
		socket_close($socket);                // Close connection (I don't know if this is needed or not).
	}
	return true;
}

// send_msg('127.0.0.1', '55970', $msg);
