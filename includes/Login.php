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
	public function login_form() { ?>

		<form name="jc_login" id="jc_login" method="post">
			<label for="jc_user">
				Username:
				<br>
				<input type="text" name="jc_user" id="jc_user" />
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

	}

	/**
	 * Sets the appropriate cookie
	 *
	 * @since 1.0.0
	 */
	private function cookie_set() {

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

		$dashboard_pages = get_pags( $args );

		return $dashboard_pages;
	}

	/**
	 * Array of Dashboard page slugs
	 *
	 * @since 1.0.0
	 * @uses $this->get_dashboard_pages()
	 */
	private function dashboard_page_slugs() {

		$dashboard_pages = $this->get_dashboard_pages();

		if( $dashboard_pages ) {
			foreach( $dashboard_pages as $dashboard_slug ) {
				$dashboard_slugs[] = $dashboard_slug->post_name;
			}
		}

		return $dashboard_slugs;
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
			if( $this->password == )
		}
	}

}

new JC_Login_Form();