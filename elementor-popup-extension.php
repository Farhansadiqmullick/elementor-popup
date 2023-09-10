<?php
/*
Plugin Name: Elementor Widget for Popup
Description: Boilerplate for creating Elementor Extensions
Version: 1.0
Author: Farhan Mullick
Author URI: https://farhanmullick.com
License: GPLv2 or later
Text Domain: elementor-popup
Domain Path: /languages/
*/

final class Elementor_Popup
{

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.3';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var Elementor_Test_Extension The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Elementor_Test_Extension An instance of the class.
	 */
	public static function instance()
	{

		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct()
	{

		add_action('init', [$this, 'i18n']);
		add_action('plugins_loaded', [$this, 'init']);
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n()
	{

		load_plugin_textdomain('elementor-popup');
	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init()
	{

		// Check if Elementor installed and activated
		if (!did_action('elementor/loaded')) {
			add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
			return;
		}

		// Check for required Elementor version
		if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
			add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
			return;
		}

		// Check for required PHP version
		if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
			add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
			return;
		}

		// Add Plugin actions
		add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets']);
		add_action("elementor/frontend/after_enqueue_styles", [$this, 'frontend_popup_styles']);
		add_action("elementor/frontend/after_enqueue_scripts", [$this, 'frontend_popup_scripts']);
		add_action('wp_ajax_send_phone_number', [$this, 'send_phone_number']);
		add_action('wp_ajax_nopriv_send_phone_number', [$this, 'send_phone_number']);
	}


	public function frontend_popup_styles()
	{
		wp_enqueue_style("intlTelInput-css", plugins_url("/assets/css/intlTelInput.css", __FILE__), '', rand(111, 999), 'all');
		wp_enqueue_style("popup-css", plugins_url("/assets/css/popup.css", __FILE__), '', rand(111, 999), 'all');
	}

	public function frontend_popup_scripts()
	{
		wp_enqueue_script('intlTelInput-js', plugins_url('/assets/js/intlTelInput.js', __FILE__), array('jquery'), '', true);
		wp_enqueue_script('utils-js', plugins_url('/assets/js/utils.js', __FILE__), array('jquery'), '', true);
		wp_enqueue_script("popup-js", plugins_url("/assets/js/popup.js", __FILE__), array('jquery'), rand(111, 999), true);
		wp_localize_script("popup-js", 'phoneurl', ['ajaxurl' => admin_url("admin-ajax.php")]);
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin()
	{

		if (isset($_GET['activate'])) unset($_GET['activate']);

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'elementor-popup'),
			'<strong>' . esc_html__('Elementor Popup', 'elementor-popup') . '</strong>',
			'<strong>' . esc_html__('Elementor', 'elementor-popup') . '</strong>'
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version()
	{

		if (isset($_GET['activate'])) unset($_GET['activate']);

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-popup'),
			'<strong>' . esc_html__('Elementor Popup', 'elementor-popup') . '</strong>',
			'<strong>' . esc_html__('Elementor', 'elementor-popup') . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version()
	{

		if (isset($_GET['activate'])) unset($_GET['activate']);

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-popup'),
			'<strong>' . esc_html__('Elementor Popup', 'elementor-popup') . '</strong>',
			'<strong>' . esc_html__('PHP', 'elementor-popup') . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}

	// Define the AJAX function to handle the request
	public function send_phone_number()
	{
		if (isset($_POST['phone'])) {
			$phone_number = sanitize_text_field($_POST['phone']);
			$recipient_email = sanitize_email($_POST['recipient_email']);

			// Here, you can send the email using your preferred method, e.g., wp_mail
			$subject = 'Contact Request';
			$message = 'Phone Number: ' . $phone_number;

			$sent = wp_mail($recipient_email, $subject, $message);

			if ($sent) {
				echo json_encode(array('success' => true, 'message' => 'Email has been sent successfully.'));
			} else {
				echo json_encode(array('success' => false, 'message' => 'Email could not be sent.'));
			}
		} else {
			echo json_encode(array('success' => false, 'message' => 'Phone number not provided.'));
		}

		// Always exit to avoid further processing
		wp_die();
	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_widgets()
	{

		// Include Widget files
		require_once(__DIR__ . '/widgets/elementor-popup-widget.php');

		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \ELEMENTOR_POPUP_WIDGET());
	}
}

Elementor_Popup::instance();
