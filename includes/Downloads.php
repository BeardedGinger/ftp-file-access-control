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

		add_shortcode( 'jc_download_files', array( $this, 'dashboard_shortcode' ) );
	}

	/**
	 * Set the active page
	 *
	 * Gets the slug from the current page and sets it as $active_page
	 *
	 * @since 1.0.0
	 */
	public function set_active_page() {

		global $post;
		if( $post ) {
			$this->active_page = $post->post_name;
		}

	}

	/**
	 * Set files associated with this page
	 *
	 * Pulls the files from the folder associated with this page
	 *
	 * @since 1.0.0
	 */
	private function set_files( $active_page ) {

		$directory_files = scandir( $_SERVER['DOCUMENT_ROOT'] . '/clients/' . $active_page );

		foreach( $directory_files as $file ) {
			if( $file != '.' && $file != '..' ) {
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

		ob_start();

		global $post;
		$cookie = 'jc_' . $post->post_name;

		if( isset($_COOKIE[$cookie]) || is_admin() ) {

			$this->set_files( $post->post_name );

			foreach( $this->files as $file ) {
				$file = urlencode($file);
				echo '<li class="file"><a href="/download-files.php?file=' . $file . '&folder=' . $post->post_name . '">' . $file . '</a></li>';
			}

		} else {

			echo '<a href="/login">Login to the appropriate account</a> to access these files';

		}

		$dashboard = ob_get_clean();
		return $dashboard;
	}
}

new JC_Downloads();