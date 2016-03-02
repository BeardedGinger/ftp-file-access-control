<?php
/**
 * Main plugin file for FTP File Access Control
 *
 * @since 1.0.0
 */

class JC_FTP_File_Access_Main {

	/**
	 * the make it work worker
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$this->load_files();
	}

	/**
	 * Get the needed Files
	 *
	 * @since 1.0.0
	 */
	private function load_files() {

		require plugin_dir_path( __FILE__) . 'Downloads.php';
		require plugin_dir_path( __FILE__) . 'Login.php';

	}
}