<?php

/**
 * Print_r with added pre tags for easy readability of variables
 * 
 * @param mixed $data What you want to 'trace'.
 * 
 * @return mixed
 */

function traceme($data)
{
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

function clean_input($string)
{
	$payload = strip_tags($string);
	$payload = stripslashes($payload);
	$payload = trim($payload);
	$payload = htmlentities($payload);
	return $payload;
}

function getUserIP() {
    if( array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')>0) {
            $addr = explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($addr[0]);
        } else {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

/*
function getUserIP() {
    if( array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')>0) {
            $addr = explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
            return preg_replace("/[^0-9.]/", "", trim($addr[0]) );
        } else {
            preg_replace("/[^0-9.]/", "", $_SERVER['HTTP_X_FORWARDED_FOR'] );
        }
    }
    else {
        return preg_replace("/[^0-9.]/", "", $_SERVER['REMOTE_ADDR'] );
    }
}
*/