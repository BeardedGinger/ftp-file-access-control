<?php
/**
 * Contains the login form and sets logged in cookie for appropriate page
 *
 * @since 1.0.0
 */

class JC_Login_Form {

	/**
	 * Page slug
	 *
	 * Username from login form
	 *
	 * @since 1.0.0
	 */
	protected $slug;

	/**
	 * Page password
	 *
	 * Username from login form
	 *
	 * @since 1.0.0
	 */
	protected $password;

	/**
	 * Constructor (Bob the Builder)
	 */
	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'set_cookie' ) );
		add_shortcode( 'jc_login_form', array( $this, 'login_shortcode' ) );
	}

	/**
	 * Login form shortcode
	 *
	 * @since 1.0.0
	 */
	public function login_shortcode( $atts, $content = '' ) {

		ob_start();

			if( isset( $_POST['jc_login'] ) ) {

				$this->slug = esc_attr( $_POST['jc_user'] );
				$this->password = esc_attr( $_POST['jc_pass'] );

				$this->process_login();

			} else {

				$this->login_form();

			}

		$login_form = ob_get_clean();
		return $login_form;
	}

	/**
	 * Login Form
	 *
	 * @since 1.0.0
	 */
	public function login_form( $username = '' ) { ?>

		<form name="jc_login" id="jc_login" method="post">
			<label for="jc_user">
				Username:
				<br>
				<input type="text" name="jc_user" id="jc_user" placeholder="<?php echo $username; ?>" />
			</label>
			<label for="jc_pass">
				Password:
				<br>
				<input type="text" name="jc_pass" id="jc_pass" />
			</label>
			<input type="submit" value="Login" name="jc_login" />
		</form>

	<?php
	}

	/**
	 * Processes the login form
	 *
	 * Verifies the password set for the requested page (Username == Page Slug)
	 * adds appropriate cookie to make available downloads visible on that page
	 *
	 * @since 1.0.0
	 */
	private function process_login() {

		if( $this->is_username_legit() ) {

			if( $this->is_password_legit() ) {

				$this->set_cookie();

				wp_safe_redirect( site_url() . '/' . $this->slug );
				exit;

			} else {

				echo '<p class="login-error">Incorrect password. Please try logging in again</p>';
				$this->login_form( $this->slug );

			}

		} else {

			echo '<p class="login-error">Incorrect username. Please try logging in again</p>';
			$this->login_form();

		}
	}

	/**
	 * Sets the appropriate cookie
	 *
	 * @since 1.0.0
	 */
	private function set_cookie() {

		if( !isset( $_COOKIE[ 'jc_' . $this->slug ] ) ) {
			setcookie( 'jc_' . $this->slug, 1, time()+3600, '', site_url(), false );
		}

		wp_enqueue_script( 'ftp-file-access', plugin_dir_path(__FILE__) . '../resources/scripts.js', array() );
		wp_localize_script( 'ftp-file-access', FTP_FILE_ACCESS_CONTROL, array(
			'slug' 	=> $this->slug;
		) );


	}

	/**
	 * The dashboard pages
	 *
	 * All dashboard pages are assigned to the "template-dashboard.php" template
	 * added via the theme. We're grabbing those pages here to compare slug
	 * against "username" on login form
	 *
	 * @since 1.0.0
	 */
	private function get_dashboard_pages() {

		$args = array(
			'meta_key' 		=> '_wp_page_template',
			'meta_value' 	=> 'template-dashboard.php'
		);

		$dashboard_pages = get_pages( $args );

		return $dashboard_pages;
	}

	/**
	 * Array of Dashboard page slugs
	 *
	 * @since 1.0.0
	 * @uses $this->get_dashboard_pages()
	 */
	private function dashboard_page_slugs() {

		$dashboard_slugs = array();
		$dashboard_pages = $this->get_dashboard_pages();

		if( $dashboard_pages ) {
			foreach( $dashboard_pages as $dashboard_slug ) {
				$dashboard_slugs[] = $dashboard_slug->post_name;
			}
		}

		return $dashboard_slugs;
	}

	/**
	 * Array key => value of slug and ID
	 *
	 * Used once slug/username verified to get the associated
	 * password for the page using the page ID
	 *
	 * @since 1.0.0
	 * @uses $this->get_dashboard_pages()
	 */
	private function dashboard_page_slug_ids() {

		$dashboard_slug_ids = array();
		$dashboard_pages = $this->get_dashboard_pages();

		if( $dashboard_pages ) {
			foreach( $dashboard_pages as $page ) {
				$dashboard_slug_ids[] = array(
					$page->post_name => $page->ID
				);
			}
		}

		return $dashboard_slug_ids;
	}

	/**
	 * Ensure login is a currect "username"
	 *
	 * Compares the username from login to the post_name from
	 * the dashboard pages
	 *
	 * @since 1.0.0
	 */
	private function is_username_legit() {

		// Too legit to quit
		if( in_array( $this->slug, $this->dashboard_page_slugs() ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Ensure the password given matches the password field
	 * associated with the page given as the username
	 *
	 * @since 1.0.0
	 */
	private function is_password_legit() {

		$get_associated_id = $this->dashboard_page_slug_ids();

		foreach( $get_associated_id as $ids ) {
			foreach( $ids as $key => $value ) {
				if( $key == $this->slug ) {
					$id = $value;
				}
			}
		}

		$page_password = get_field( 'password', $id );

		if( $page_password == $this->password ) {
			return true;
		} else {
			return false;
		}
	}

}

new JC_Login_Form();