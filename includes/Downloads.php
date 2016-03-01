<?php
/**
 * Download listing. Displays on dashboard once user logs in
 *
 * @since 1.0.0
 */

class JC_Downloads {

	/**
	 * Active page
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $active_page;

	/**
	 * Active page files
	 *
	 * The files within the folder associated with the active page
	 *
	 * @since 1.0.0
	 */
	protected $files = array();

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->set_active_page();
		$this->set_files();

		add_shortcode( 'jc_download_files', array( $this, 'dashboard_shortcode' ) );
	}

	/**
	 * Cookie check
	 *
	 * Checks to see if the cookie has been set representing a valid login
	 *
	 * @since 1.0.0
	 */
	public function is_cookie_set() {

		$cookie = 'jc_' . $this->active_page;

		if( isset($_COOKIE[$cookie] ) ) {
			return true;
		} else {
			return false;
		}

	}

	/**
	 * Set the active page
	 *
	 * Gets the slug from the current page and sets it as $active_page
	 *
	 * @since 1.0.0
	 */
	private function set_active_page() {

		global $post;
		$this->active_page = $post->post_name;

	}

	/**
	 * Set files associated with this page
	 *
	 * Pulls the files from the folder associated with this page
	 *
	 * @since 1.0.0
	 */
	private function set_files() {

		$directory_files = scandir( $this->active_page );

		foreach( $directory_files as $file ) {
			if( $files != '.' && $files != '..' ) {
				$files[] = $file;
			}
		}

		$this->files = $files;
	}

	/**
	 * Shortcode for displaying files
	 *
	 * @since 1.0.0
	 */
	public function dashboard_shortcode( $atts, $content = '' ) {

	}
}