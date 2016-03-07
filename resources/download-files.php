<?php
/**
 * THIS FILE SHOULD BE PLACED IN THE ROOT DIRECTORY OF THE WP INSTALLATION
 *
 * The downloads folder is protected and this file processes the download
 * request via the link on the user profiles and serves the files if the necessary
 * login cookies are set
 *
 * @since 1.0.0
 */

$file = $_GET['file'];
$folder = $_GET['folder'];

if( isset( $_COOKIE['jc_' . $folder] ) ) {
	$location = 'clients/' . $folder . '/' . $file;
	header_remove('X-Powered-By');
    header_remove('Transfer-Encoding');
    header_remove('Cache-Control');
    header_remove('Pragma');
    header_remove('Expires');
    //header('Expires:');

    header('Content-type: audio/wav');
    readfile($location);
}