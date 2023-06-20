<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://oswaldocavalcante.com
 * @since      1.0.0
 *
 * @package    Classebiblica
 * @subpackage Classebiblica/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Classebiblica
 * @subpackage Classebiblica/admin
 * @author     Oswaldo Cavalcante <jocmail@gmail.com>
 */
class Classebiblica_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	public $email_logo;
	public $email_options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->email_options     = get_option( 'email_template_data' );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Classebiblica_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Classebiblica_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/classebiblica-admin.css', array(), $this->version, 'all' );
		// wp_enqueue_style( 'bootstrap-css', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Classebiblica_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Classebiblica_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/classebiblica-admin.js', array( 'jquery' ), $this->version, false );
		// wp_enqueue_script( 'bootstrap-js', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add the custom menu.
	 *
	 * @since    1.0.0
	 */
	public function my_admin_menu() {
		add_menu_page(
			'Classe Bíblica Configurações',
			'Classe Bíblica',
			'manage_options',
			'classebiblica',
			array( $this, 'classebiblica_admin_page'),
			'data:image/svg+xml;base64,PHN2ZwogICB2aWV3Qm94PSIwIDAgMTkuOTk5OTk4IDIwLjAwMTM4OSIKICAgd2lkdGg9IjE5Ljk5OTk5OCIKICAgaGVpZ2h0PSIyMC4wMDEzODkiCiAgIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIKPgogIDxnCiAgICAgdHJhbnNmb3JtPSJtYXRyaXgoMC4wMjAwMDIzMSwwLDAsMC4wMjAwMDIzMSwtMy40NTM5NTg5LC0xMS4xNjIyNDMpIgogICAgIGlkPSJnNDUwIj4KICAgIDxwYXRoCiAgICAgICBmaWxsPSJncmF5IgogICAgICAgZD0ibSA0MTEuMjA5MTgsNTU4LjA0NzY5IGMgLTU0LjcyMzYzLDI2LjA3NTg1IC0xMDkuNDUyNjIsNTIuMTQyMTEgLTE2NC4xNzk2OSw3OC4yMTA5MyAwLjE4Nzg1LDAuMjc5MjYgMC4zNzMxMywwLjU2MDMgMC41NjA1NSwwLjgzOTg1IC0yMC40MDg5NCwtMy45MDEzIC0zNS40NjkzLDAuNzEwOTcgLTQ4Ljc1MzkxLDEwLjE5NTMxIC0xOS45ODk1NiwxNC4yNzEyNiAtMjUuOTMzNTksMzUuMzczOTEgLTI1LjkzMzU5LDU5LjYyNjk1IC0wLjU2MjQsMTYuMzQxMjggMC4xNDA3NSwzMi43MTYxNiAtMC4xMTUyMyw0OS4wNzQyMiAwLjA1MSwxODcuMTEyMTIgLTAuMTc1NjUsMzUzLjQ3MzI1IDAuMjUxOTUsNTM5LjQ5NDE1IC0xLjQ5ODksMjMuMTk3MSAyMi41MDUwNiw0Ni43NzA5IDI2LjAyNzM0LDQ5LjIyODUgMjcuMDQwODQsMTguOTM3NyA1Ny43Mjk0MiwzMC4wNjgyIDg2Ljk3NjU2LDQ0LjEwMzUgbCAzMzAuMDQ2ODgsMTQ5LjQwMjQgYyAxOS4wMjYzNiw4LjYxMzQgMzYuODUyNzgsMTYuOTcyOCA1Ni41ODU5NCwxOS4xNjQgdiAwLjA0NSBjIDMuMTA4NzgsMC4zNDQ5IDYuMjYwOTYsMC41NTM2IDkuNDc2NTYsMC41NjgzIDIzLjYyNzE2LDAuMTAzMSA0MS4xMzAxNSwtOS4zNjI2IDYxLjY5NTMxLC0xOS4xMjY5IDEyMy42NTgzLC01OC43MDg2IDI0Ny4zNzM3NSwtMTE3LjI4NDYgMzcxLjAzMzI1LC0xNzUuOTg2NCAzMC4wMTc0LC0xNC4zMzIzIDU3LjYwMTUsLTMxLjM0NjkgNTcuNjAxNSwtNjcuMTMyOCAwLjE1MiwtMjAyLjI4NjIgMC4wNTksLTM5Ny45MDIxIC0wLjA0OSwtNjAwLjE4NzQ4IC0wLjM0LC0xNy45NDk4OCAtMTEuOTg4MiwtNDYuMTc0NjkgLTQwLjc0NDIsLTU2LjE2Nzk3IC0xMy41OTM0LC00LjcyNDAxIC0yNC40NzY5LC00LjUyOTcgLTMzLjc1LC0yLjU1ODYgMC4xMjk4LC0wLjE5MzQgMC4yNTY4LC0wLjM4ODc2IDAuMzg2OCwtMC41ODIwMyAtNTQuNzI3MiwtMjYuMDY4ODUgLTEwOS40NTU5NiwtNTIuMTM1MDUgLTE2NC4xNzk3MiwtNzguMjEwOTMgLTY5LjA4MDg1LDI5LjUwMDUyIC0xMzguMTY2ODIsNTguOTkzNjEgLTIwNy4yNDQxNCw4OC41MDE5NSAtNC43MjA5Niw0LjM0NzkzIC05LjI5MjEzLDkuMTkxMDIgLTEzLjc4NzExLDE0LjI4MTI1IC00LjQ5NDk4LDUuMDkwMjMgLTguOTEzMiwxMC40Mjc5MSAtMTMuMzMyMDMsMTUuNzY3NTggLTQuNDE4ODQsNS4zMzk2MiAtOC44Mzc1OCwxMC42ODExMyAtMTMuMzMwMDgsMTUuNzc3MzQgLTQuNDkyNSw1LjA5NjIxIC05LjA1OTQsOS45NDY2OSAtMTMuNzc1MzksMTQuMzA2NjQgLTE4Ljg2MzkzLC0xNy40Mzk4IC0zNS4zNDA4MSwtNDIuNzQxMDkgLTU0LjIyNDYxLC02MC4xMzI4MSAtNjkuMDc3MjEsLTI5LjUwNzkyIC0xMzguMTYzNCwtNTkuMDAxNDYgLTIwNy4yNDQxNCwtODguNTAxOTUgeiBtIDAuNDQxNDEsNzEuODY1MjMgYyA4Mi4zNzgzNCwzNC43MTczOCAxNjQuNzU4MjgsNjkuNDM1MzUgMjQ3LjEzNjcyLDEwNC4xNTIzNCA1LjI3MDQ1LDEuOTAyODggOC40NDgwMSw1LjU4MDAxIDEzLjg5MDYyLDUuNjc3NzQgMS4zNjA2NSwtMC4wMjQ0IDIuNTc4OTksLTAuMjcxOTUgMy43MjQ2MSwtMC42NjAxNiAxLjE0NTYxLC0wLjM4ODIxIDIuMjE4MzksLTAuOTE3MjcgMy4yODUxNiwtMS41MDE5NSAyLjEzMzUxLC0xLjE2OTM2IDQuMjQ1NjIsLTIuNTY0MTkgNi44ODA4NiwtMy41MTU2MyA4Mi4zNzg1OSwtMzQuNzE3MDMgMTY0Ljc1ODE2LC02OS40MzQ5MiAyNDcuMTM2NzEsLTEwNC4xNTIzNCAyNy4yNzA1NiwxMS44ODcxNCA1NC41NDE5NSwyMy43NzQ5NiA4MS44MTI1MywzNS42NjIxMSBsIDQuOTI3NywyLjIxODc1IGMgLTI1LjQxMTYyLDEwLjY5MzQ3IC01MC42MzI4LDIxLjI0NDc5IC03Ny45NjA5MywzMi45ODA0NyAzMC42MDUyNCwtMTIuOTQxNjggNTMuNTE3MTUsLTAuNzE5OTggNjEuMjg3MTMsNC41NzQyMiA3Ljc3LDUuMjk0MjggMjcuODMwMSwyMi4zODcxOCAyNy44MzAxLDQ5LjYxOTE0IDAsMjMuOTE0NzQgMC4wNDEsNTguODM4NDQgMC4wNDksOTAuNTE3NTggMCw0MC41NTA3IDAuMDM5LDc1Ljc4MTI1IDAuMDM5LDc1Ljc4MTI1IGwgLTAuMDg0LDAuMDQ2OSB2IDE2My4yMDY5NiBjIC0yMS42MTMyLC0yNC4wNzU5IC00My4yMjg2NywtNDguMTQ5NiAtNjQuODQxODMsLTcyLjIyNjUgLTEzLjg3ODc4LC0xMy44NTg4NCAtMTkuODcwNDIsLTE1LjU4OTE2IC0yNi43Mjg1MiwtNi4xNjQxIC0yNi41NDM5NCw0NS41MjY1IC01My4wODg0NywxMTMuODkwMiAtNzkuNjMyODEsMTU5LjQxOCBWIDgyOS42NjI5MiBjIDAsLTI4LjczMzM0IC0xMS45NTQ3NiwtNDQuNjAyNTkgLTI4LjA2ODM2LC01NS4zMjYxNyAtMTYuMTEzNjYsLTEwLjcyMzY4IC0zOC40Nzc1OSwtMTIuNDYzNDMgLTUyLjU3MjI3LC03LjAyNzM1IGwgLTcxLjU3ODEyLDI5LjQzMTY0IGMgLTE1LjAyNDI4LDUuNTI1MyAtMjIuMDY2OTUsOS4yMzcxMSAtMzUuNTA3ODEsOS4wNjY0MSAtMTMuNDQwODgsLTAuMTcwNSAtMjMuMzA3MTQsLTQuNTIzMzMgLTMyLjg4MjgyLC04LjUxOTUzIEMgNTM1LjExNTg3LDc1My45OTYwMyA0MzAuNDQwMzIsNzEwLjcwMTQ0IDMyNS43NjM4Nyw2NjcuNDA5MDEgbCA0LjA3NDIyLC0xLjgzMzk4IGMgMjcuMjcwNDksLTExLjg4NzE0IDU0LjU0MTk2LC0yMy43NzQ5OCA4MS44MTI1LC0zNS42NjIxMSB6IgogICAgICAgaWQ9InBhdGg0NDYiIC8+CiAgICA8ZwogICAgICAgdHJhbnNmb3JtPSJtYXRyaXgoMy45NTgzODU3LDAsMCwzLjkwODk2MzIsLTUwMy40ODA0NywtNjE4Mi44ODQyKSIKICAgICAgIGlkPSJnNDQ4IiAvPgogIDwvZz4KPC9zdmc+Cg==',
			250
		);
	}

	/**
	 * Return the settings page.
	 *
	 * @since    1.0.0
	 */
	public function classebiblica_admin_page() {
		//return views
		require_once 'partials/classebiblica-admin-display.php';
	}

	/**
	 * Register custom fields for settings.
	 *
	 * @since    1.0.0
	 */
	public function classebiblica_register_settings() {
		//registers all settings for settings page
		register_setting( 'classebiblica_settings', 'feedURL' );
		register_setting( 'classebiblica_settings', 'xmlTAG' );
		register_setting( 'classebiblica_settings', 'reading_starter_date' );
	}

	/**
	 * Creates custom post type for tag conter
	 *
	 * @since    1.0.0
	 */
	public function cb_course_group_meta_box () {
			
		add_meta_box(
			'cb-course-group',
			__( 'Grupo do curso', 'textdomain' ),
			array( $this, 'cb_course_group_meta_box_render' ),
			'courses',
			'advanced',
			'default'
		);

    }

	public function cb_course_group_meta_box_render ( $post ) {

        // Add an nonce field so we can check for it later.
        wp_nonce_field( 'cb_inner_custom_box', 'cb_inner_custom_box_nonce' );
 
        // Use get_post_meta to retrieve an existing value from the database.
        $value = get_post_meta( $post->ID, '_cb_course_group_field', true );
 
        // Display the form, using the current value.
		?>
			<label for="cb_course_group_field">
				<?php _e( 'Link do grupo no Telegram: ', 'textdomain' ); ?>
			</label>
			<input type="text" id="cb-course-group-field" class="form-control" name="cb_course_group_field" value="<?php echo esc_attr( $value ); ?>" size="30" />
		<?php
	}

	public function cb_course_group_meta_save ( $post_ID, $post ) {
 
        // Check if our nonce is set.
        if ( ! isset( $_POST['cb_inner_custom_box_nonce'] ) ) {
            return $post_ID;
        }
 
        $nonce = $_POST['cb_inner_custom_box_nonce'];
 
        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, 'cb_inner_custom_box' ) ) {
            return $post_ID;
        }
 
        /*
         * If this is an autosave, our form has not been submitted,
         * so we don't want to do anything.
         */
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_ID;
        }
 
        /* OK, it's safe for us to save the data now. */
 
        // Sanitize the user input.
        $mydata = sanitize_text_field( $_POST['cb_course_group_field'] );
 
        // Update the meta field.
        update_post_meta( $post_ID, '_cb_course_group_field', $mydata );
	}

	public function cb_email_student_registration ( $user_id , $userdata ) {

		$user_content = get_userdata( $user_id );
		$user_email = $user_content->user_email;
		$subject = 'Boas vindas!';

		$replacable['{testing_email_notice}']	= '';
		$replacable['{profile_url}'] 			= tutor_utils()->profile_url( $user_id, false );
		$replacable['{dashboard_url}']        	= tutor_utils()->get_tutor_dashboard_page_permalink();
		$replacable['{email_heading}']        	= 'Boas vindas à Classe Bíblica!';
		$replacable['{user_name}']           	= $user_content->user_firstname;
		$replacable['{email_message}'] 		 	= 'Sua conta foi criada na ClasseBiblica.org e a seguir estão suas credenciais de acesso:';
		$replacable['{student_username}']     	= $user_content->user_login;
		$replacable['{student_email}']       	= $user_content->user_email;
		$replacable['{footer_text}']      	    = 'Se precisar redefinir sua senha, <a href="https://classebiblica.org/painel/retrieve-password" target="_blank" rel="noopener noreferrer">clique aqui</a>.';

		ob_start();
		include tutor_get_template( 'email.to_student_signup', true );
		$email_tpl	= apply_filters( 'tutor_email_tpl/to_teacher_course_enrolled', ob_get_clean() );
		$message   = html_entity_decode( $this->get_message( $email_tpl, array_keys( $replacable ), array_values( $replacable ) ) );
		$message	= apply_filters( 'tutor_mail_content', $message );

		$this->send( $user_email, $subject, $message );
			
	}

	public function cb_email_student_course_enroll( $course_id, $student_id, $enrol_id, $status_to = 'completed' ) {
		// $enroll_notification = tutor_utils()->get_option( 'email_to_students.course_enrolled' );

		// if ( ! $enroll_notification || $status_to !== 'completed' ) {
		// 	return;
		// }

		$student = get_userdata( $student_id );
		// if student not found return.
		if ( false === $student ) {
			return;
		}

		$course             = tutor_utils()->get_course_by_enrol_id( $enrol_id );
		$enroll_time        = tutor_time();
		$enroll_time_format = date_i18n( get_option( 'date_format' ), $enroll_time ) . ' ' . date_i18n( get_option( 'time_format' ), $enroll_time );
		$course_start_url   = tutor_utils()->get_course_first_lesson( $course_id );
		$site_url           = get_bloginfo( 'url' );
		$site_name          = get_bloginfo( 'name' );
		$option_data        = $this->email_options['email_to_students']['course_enrolled'];
		// $header             = 'Content-Type: ' . $this->get_content_type() . "\r\n";
		// $header             = apply_filters( 'student_course_enrolled_email_header', $header, $enrol_id );

		// pr($student);die;

		$replacable['{testing_email_notice}'] = '';
		$replacable['{user_name}']            = tutor_utils()->get_user_name( $student );
		$replacable['{course_name}']          = $course->post_title;
		$replacable['{enroll_time}']          = $enroll_time_format;
		$replacable['{course_url}']           = get_the_permalink( $course->ID );
		$replacable['{course_start_url}']     = $course_start_url;
		$replacable['{site_url}']             = $site_url;
		$replacable['{site_name}']            = $site_name;
		$replacable['{email_heading}']        = $option_data['heading'];
		$replacable['{email_message}']        = $this->get_replaced_text( $this->prepare_message( $option_data['message'] ), array_keys( $replacable ), array_values( $replacable ) );
		$subject                              = $this->get_replaced_text( $option_data['subject'], array_keys( $replacable ), array_values( $replacable ) );

		$group_url = get_post_meta( $course->ID, '_cb_course_group_field', true );

		ob_start();
		if ( $group_url != '' ) {
			$replacable['{group_url}'] = get_post_meta( $course->ID, '_cb_course_group_field', true );
			$replacable['{footer_text}'] = 'Seu curso terá aulas ao vivo na sua turma do Telegram.';
			include tutor_get_template( 'email.to_student_course_group_enrolled', true );
		} else {
			$replacable['{footer_text}'] 			= 'Classe Bíblica.org - Sua plataforma de educação bíblica';
			include tutor_get_template( 'email.to_student_course_enrolled', true );
		}
		$email_tpl = apply_filters( 'tutor_email_tpl/student_course_enrolled', ob_get_clean() );
		$message   = html_entity_decode( $this->get_message( $email_tpl, array_keys( $replacable ), array_values( $replacable ) ) );
		$message	= apply_filters( 'tutor_mail_content', $message );

		$this->send( $student->user_email, $subject, $message );

	}

	public function get_message( $message = '', $search = array(), $replace = array() ) {
		$email_footer_text = tutor_utils()->get_option( 'email_footer_text' );
		$email_footer_text = str_replace( '{site_name}', get_bloginfo( 'name' ), $email_footer_text );
		$message = str_replace( $search, $replace, $message );
		if ( $email_footer_text ) {
			$message .= '<div class="tutor-email-footer-content">' . wp_unslash( json_decode( $email_footer_text ) ) . '</div>';
		}
		return $message;
	}

	public function send( $user_email, $subject, $message ) {
		add_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
		add_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );
		add_filter( 'wp_mail_content_type', array( $this, 'get_content_type' ) );

		wp_mail( $user_email, $subject, $message );

		remove_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
		remove_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );
		remove_filter( 'wp_mail_content_type', array( $this, 'get_content_type' ) );
		return;
	}

	public function get_replaced_text( $message = '', $search = array(), $replace = array() ) {
		return str_replace( $search, $replace, $message );
	}

	/**
	 * Ready the e-mail message
	 * unslash and trim (") from front and end of the message
	 *
	 * @param string $message
	 * @return string
	 */
	public function prepare_message( $message ) {
		return wp_unslash( json_decode( $message ) );
	}

	public function get_from_address() {
		$email_from_address = tutor_utils()->get_option( 'email_from_address' );
		$from_address       = apply_filters( 'tutor_email_from_address', $email_from_address );
		return sanitize_email( $from_address );
	}

	public function get_from_name() {
		$email_from_name = tutor_utils()->get_option( 'email_from_name' );
		$from_name       = apply_filters( 'tutor_email_from_name', $email_from_name );
		return wp_specialchars_decode( esc_html( $from_name ), ENT_QUOTES );
	}

	public function get_content_type() {
		return apply_filters( 'tutor_email_content_type', 'text/html' );
	}

    public function create_reading_plan_db(){
        global $wpdb;
		global $tablename;

        $tablename = $wpdb->prefix . 'biblia_nar';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $tablename (
			id int(10) NOT NULL AUTO_INCREMENT,
			book_id int(10) NOT NULL,
			chapter int(10) NOT NULL,
			verse int(10) NOT NULL,
			pt_nar varchar(600) NOT NULL,
			PRIMARY KEY  (id)
		) $charset_collate;";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
    }

}
