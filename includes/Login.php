<?php
/**
 * Contains the login form and sets logged in cookie for appropriate page
 *
 * @since 1.0.0
 */

class JC_Login_Form {

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

		ob_start(); ?>

			<form name="jc_login" id="jc_login" action="post">
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
				<input type="submit" value="Login" />
			</form>

		<?php
		$login_form = ob_get_clean();
		return $login_form;
	}

	/**
	 * Processes the login form
	 *
	 * Verifies the password set for the requested page (Username == Page Slug)
	 * adds appropriate cookie to make available downloads visible on that page
	 *
	 * @since 1.0.0
	 */
	public function process_login() {

	}

	/**
	 * Sets the appropriate cookie
	 *
	 * @since 1.0.0
	 */
	private function cookie_set() {

	}

}

new JC_Login_Form();