<?php
/**
 * Plugin Name:       FTP File Access Control
 * Description:       Allows site owner the ability to upload files to a root folder via FTP and users can login and download those files
 * Version:           1.0.0
 * Author:            LimeCuda
 * Author URI:        http://limecuda.com
 * Text Domain:       ftp-file-access-control
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

include_once( 'includes/Main.php' );

function ftp_file_access_control() {
	new JC_FTP_File_Access_Main();
}

ftp_file_access_control();