<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://oswaldocavalcante.com
 * @since      1.0.0
 *
 * @package    Classebiblica
 * @subpackage Classebiblica/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Classebiblica
 * @subpackage Classebiblica/public
 * @author     Oswaldo Cavalcante <jocmail@gmail.com>
 */
class Classebiblica_Public
{

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

	private $readingPlan;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_shortcode( 'cb_redirect_panel', array( $this, 'cb_redirect_panel' ) );

		require_once 'partials/classebiblica-public-reading-plan.php';
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/classebiblica-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/classebiblica-public.js', array('jquery'), $this->version, false);
	}

	/**
	 * Translate the slug 'courses' to 'cursos'.
	 *
	 * @since    1.0.0
	 */
	public function cb_course_register_post_type_args ( $args, $post_type ) {

		if ( 'courses' === $post_type ) {
			$args['rewrite']['slug'] = 'curso'; //here add your new slug
		}
		return $args;
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function classebiblica_shortcode() {
		?>
			<script>
				var feedURL = '<?php echo get_option('feedURL') ?>';
				var xmlTAG = '<?php echo get_option('xmlTAG') ?>';
				var chaptersDone = 0;
				var chaptersTotal = 1189;
				var percent = 0;

				function loadXMLDoc() {
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							counters(this);
						}
					};
					xmlhttp.open("GET", feedURL, true);
					xmlhttp.send();
				}

				function counters(xml) {
					xmlDoc = xml.responseXML;
					var tags = xmlDoc.getElementsByTagName(xmlTAG);
					chaptersDone = tags.length;
					percent = Math.round(chaptersDone / chaptersTotal * 100);
					htmlRender();
				}

				function htmlRender() {
					document.getElementById('cborg-commentary-percent').innerHTML = percent + '% da Bíblia comentada';
					document.getElementById('cborg-commentary-done').innerHTML = chaptersDone + ' de ' + chaptersTotal + ' capítulos';
					document.getElementById('cborg-commentary-done').style.display = 'block';
					document.getElementById('circle').setAttribute("stroke-dasharray", percent + ', 100');
					document.getElementById('percentage').innerHTML = percent + '%';
				}
				
				window.onload = loadXMLDoc;
				
			</script>
		<?php

		return 
		('
			<div class="flex-wrapper">
				<div class="single-chart">
					<svg viewBox="0 0 36 36" class="circular-chart default">
					<path class="circle-bg"
						d="M18 2.0845
						a 15.9155 15.9155 0 0 1 0 31.831
						a 15.9155 15.9155 0 0 1 0 -31.831"
					/>
					<path id="circle" class="circle"
						d="M18 2.0845
						a 15.9155 15.9155 0 0 1 0 31.831
						a 15.9155 15.9155 0 0 1 0 -31.831"
					/>
					<text x="18" y="20.35" id="percentage" class="percentage"></text>
					</svg>
				</div>
			</div>

			<div class="cborg-commentary-stats">
				<span id="cborg-commentary-percent"></span>
				<span id="cborg-commentary-done"></span>
			</div>
		');
	}

	public function cb_group_modal($course_id, $isEnrolled) {

		$value = get_post_meta( $course_id, '_cb_course_group_field', true );
		if ( $value != '') {
			?>
				<script>
					function cbStudentGroupModal() {
						var cbModalContent = '<div id="cb-tutor-student-group" class="tutor-modal">' +
							'<span class="tutor-modal-overlay"></span>' +
							'<div class="tutor-modal-window">' +
								'<div class="tutor-modal-content tutor-modal-content-white">' +
									'<button class="tutor-iconic-btn tutor-modal-close-o" data-tutor-modal-close="">' +
										'<span class="tutor-icon-times" area-hidden="true"></span>' +
									'</button>' +
									'<div class="tutor-modal-body">' +
										'<div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-16">' +
											'Matrícula confirmada				</div>' +
										'<div class="tutor-fs-7 tutor-color-secondary tutor-mb-12">' +
											'Entrar na sua turma do Telegram:				</div>' +
										'<div class="tutor-mb-32">' +
											'<a href="<?php echo esc_attr( $value ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_attr( $value ); ?></a>' +
										'</div>' +
									'</div>' +
								'</div>' +
							'</div>' +
						'</div>';

						document.getElementById("page").insertAdjacentHTML("beforebegin",cbModalContent);
						console.log("Modal adicionada");
						cbModalVisible();
					}

					function cbModalVisible() {
						cbTutorModal = document.getElementById("cb-tutor-student-group").classList.add("tutor-is-active");
					}

					window.onload = cbStudentGroupModal;
				</script>
			<?php
		}
	}

	public function cb_group_button() {

		$post_id = get_the_ID();
		
		if($post_id) {

			if ( ! class_exists( '\TUTOR\Utils' ) ) return;

			if(!tutor_utils()->is_completed_course( $post_id , get_current_user_id() )) {
				$cbGroupURL = get_post_meta( $post_id, '_cb_course_group_field', true );
				if ($cbGroupURL != '') {
					echo ('<a class="cb-course-group tutor-btn tutor-btn-primary tutor-btn-block tutor-mb-20" href="' . esc_attr( $cbGroupURL )  . '" target="_blank" rel="noopener noreferrer">' . esc_attr( 'Turma no Telegram' ) . '</a>');
				}
			}
		}
	}

	public function cb_add_dashboard_help ($links) {
		$links['third_party_link'] = array('title' => __('Ajuda', 'tutor'), 'url' => 'https://classebiblica.org/ajuda', "icon" => "tutor-icon-quiz");

		return $links;
	}

	public function cb_redirecting_panel() {
		ob_start();

		if ( is_user_logged_in() && !is_admin() ) {
			wp_redirect( tutor_utils()->tutor_dashboard_url() );
			return ob_get_clean();
		} 

		return ob_get_clean();
	}

	public function cb_bible_reading_plan() {
		$this->readingPlan = new Reading_Plan();
		return $this->readingPlan->render();
	}
}
