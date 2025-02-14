<?php

//-----------------------------------------------------------------------
// Get UUID V4
//-----------------------------------------------------------------------

function UUID_V4()
{
  
  return (
    sprintf( 
    
      '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
      
      // 32 bits for "time_low"
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

      // 16 bits for "time_mid"
      mt_rand( 0, 0xffff ),

      // 16 bits for "time_hi_and_version",
      // four most significant bits holds version number 4
      mt_rand( 0, 0x0fff ) | 0x4000,

      // 16 bits, 8 bits for "clk_seq_hi_res",
      // 8 bits for "clk_seq_low",
      // two most significant bits holds zero and one for variant DCE1.1
      mt_rand( 0, 0x3fff ) | 0x8000,

      // 48 bits for "node"
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )   
    ) 
  );
 
}

//------------------------------------------------------------------------------
// 
//------------------------------------------------------------------------------

function UUID_V4_T1()
{

  return (
    sprintf( 
    
      '%04X%04X%04X%04X%04X%04X%04X%04X',
      
      // 32 bits for "time_low"
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

      // 16 bits for "time_mid"
      mt_rand( 0, 0xffff ),

      // 16 bits for "time_hi_and_version",
      // four most significant bits holds version number 4
      mt_rand( 0, 0x0fff ) | 0x4000,

      // 16 bits, 8 bits for "clk_seq_hi_res",
      // 8 bits for "clk_seq_low",
      // two most significant bits holds zero and one for variant DCE1.1
      mt_rand( 0, 0x3fff ) | 0x8000,

      // 48 bits for "node"
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )   
    ) 
  );
 
}

//------------------------------------------------------------------------------

function token( $length = 32 ) 
{

  // Fix length
  if (!isset($length) || intval($length) <= 8) 
  {
    $length = 32;
  }

  if (function_exists('random_bytes')) 
  {
    $token = bin2hex(random_bytes($length));
  }

  if (function_exists('mcrypt_create_iv') && version_compare(phpversion(), '7.1', '<')) 
  {
    $token = bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
  }

  if (function_exists('openssl_random_pseudo_bytes')) 
  {
    $token = bin2hex(openssl_random_pseudo_bytes($length));
  }

  return substr($token, -$length, $length);

}

//------------------------------------------------------------------------------

/**
 * Backwards support for timing safe hash string comparisons
 *
 * http://php.net/manual/en/function.hash-equals.php
 */

if (!function_exists('hash_equals')) 
{
	function hash_equals($known_string, $user_string) 
  {
		$known_string = (string)$known_string;
		$user_string = (string)$user_string;

		if (strlen($known_string) != strlen($user_string)) 
    {
			return false;
		} else {
			$res = $known_string ^ $user_string;
			$ret = 0;

			for ($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);

			return !$ret;
		}
	}
}

//------------------------------------------------------------------------------

function date_added($date) 
{
	$second = time() - strtotime($date);

	if ($second < 10) {
		$date_added = 'just now';
	} elseif ($second) {
		$date_added = $second . ' seconds ago';
	}

	$minute = floor($second / 60);

	if ($minute == 1) {
		$date_added = $minute . ' minute ago';
	} elseif ($minute) {
		$date_added = $minute . ' minutes ago';
	}

	$hour = floor($minute / 60);

	if ($hour == 1) {
		$date_added = $hour . ' hour ago';
	} elseif ($hour) {
		$date_added = $hour . ' hours ago';
	}

	$day = floor($hour / 24);

	if ($day == 1) {
		$date_added = $day . ' day ago';
	} elseif ($day) {
		$date_added = $day . ' days ago';
	}

	$week = floor($day / 7);

	if ($week == 1) {
		$date_added = $week . ' week ago';
	} elseif ($week) {
		$date_added = $week . ' weeks ago';
	}

	$month = floor($week / 4);

	if ($month == 1) {
		$date_added = $month . ' month ago';
	} elseif ($month) {
		$date_added = $month . ' months ago';
	}

	$year = floor($week / 52.1429);

	if ($year == 1) {
		$date_added = $year . ' year ago';
	} elseif ($year) {
		$date_added = $year . ' years ago';
	}

	return $date_added;
}

//------------------------------------------------------------------------------
// End Of File
//------------------------------------------------------------------------------
?>
