<?php
/**
 * Iconize WordPress Plugin.
 *
 * @package   Iconize_WP
 * @author    Mladen Ivančević <ivancevic.mladen@gmail.com>
 * @license   http://codecanyon.net/licenses
 * @link      http://codecanyon.net/user/mladen16/
 * @copyright 2014 Mladen Ivančević
 */

/**
 * Iconize_WP class.
 *
 * @package Iconize_WP
 * @author  Mladen Ivančević <ivancevic.mladen@gmail.com>
 */
class Iconize_WP {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	protected $version = '1.1.4';

	/**
	 * Unique identifier for this plugin.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'iconize';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;


	/**
	 * Check if TinyMCE Bootstrap Modal plugin is enabled.
	 *
	 * @since    1.0.0
	 *
	 * @var      boolean
	 */
	private $enqueue_wpbs = false;

	/**
	 * Check if Iconize plugin is enabled on visual editor mode.
	 *
	 * @since    1.0.0
	 *
	 * @var      boolean
	 */
	private $tinymce_iconize_plugin_enabled = false;

	/**
	 * Check if Iconize plugin is enabled on HTML editor mode.
	 *
	 * @since    1.0.0
	 *
	 * @var      boolean
	 */
	private $quicktags_iconize_plugin_enabled = false;

	/**
	 * Initialize the plugin.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain.
		add_action( 'init', array( $this, 'load_iconize_plugin_textdomain' ) );

		// Load the main functionality on 'init' action so that the plugin can be easily customized via custom filters from themes "functions.php" file.
		add_action( 'init', array( $this, 'iconize_wp_systems' ) );

		// Add taxonomy systems support if nedded ( priority 99, must be called after registration of custom taxonomies )
		add_action( 'init', ( array( $this, 'iconize_taxonomies' ) ), 99 );
		add_action( 'widgets_init', array( $this, 'iconize_widgets' ) );

		// Plugin options.
		add_action( 'admin_init', array( $this, 'init_iconize_plugin_options' ) );

		// Load stylesheets with fonts and icons defined on admin screens and front end.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_iconize_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_iconize_styles' ) );

		// Load styles to TinyMCE editor content ( priority 11 to prevent overrides ).
		add_filter( 'mce_css', ( array( $this, 'iconize_mce_css' ) ), 11 );

		// Load needed styles & scripts and add iconize dialog to footer on admin screens.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_iconize_admin_scripts_and_styles' ) );
		add_action( 'admin_footer', array( $this, 'iconize_admin_dialog' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {

			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since 1.0.0
	 */
	public function load_iconize_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	}

	/**
	 * Add iconize plugin components to WordPress systems.
	 *
	 * @since 1.0.0
	 *
	 * @uses Iconize_WP::show_iconize_options()
	 * @uses Iconize_WP::get_iconize_support_for()
	 */
	public function iconize_wp_systems() {
		in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
		// Check if options page is enabled.
		$options_enabled      = $this->show_iconize_options();

		// Check if plugin is enabled on editor/widgets/nav menus.
		$mce_plugin_support   = $this->get_iconize_support_for( 'editor' );
		$widget_icons_support = $this->get_iconize_support_for( 'widgets' );
		$menu_icons_support   = $this->get_iconize_support_for( 'nav_menus' );

		$mce_plugin_enabled   = $mce_plugin_support['enabled'];
		$widget_icons_enabled = $widget_icons_support['enabled'];
		$menu_icons_enabled   = $menu_icons_support['enabled'];

		// Options page.
		if ( $options_enabled ) {

			// Add the options page and dashboard menu item.
			add_action( 'admin_menu', array( $this, 'iconize_plugin_admin_menu' ) );
			// Add an action link pointing to the options page.
			$plugin_basename = plugin_basename( plugin_dir_path( __FILE__ ) . 'iconize.php' );
			add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_iconize_plugin_action_links' ) );
		}

		// TinyMCE editor integration if enabled.
		if ( $mce_plugin_enabled ) {

			global $wp_version;
			
			// Enable contenteditable attr in visual editor.
			add_filter( 'tiny_mce_before_init', array( $this, 'iconize_mce_allow_contenteditable_attr' ) );
			// Add editor plugins.
			add_filter( 'mce_external_plugins', array( $this, 'iconize_mce_plugins' ) );
			// TinyMCE plugin localization.
			add_filter( 'mce_external_languages', ( array( $this, 'iconize_mce_lang' ) ), 10, 1 );
			// Add four buttons to TinyMCE editor.
			add_filter( 'mce_buttons_3', array( $this, 'iconize_mce_buttons' ) );
			// Add buttons to fullscreen editor too.
			add_filter( 'wp_fullscreen_buttons', array( $this, 'iconize_mce_fullscreen_buttons' ) );

			// Check if our TinyMCE plugins are included on wp_editor instance.
			if ( $wp_version >= 3.9 ) {
				add_action( 'wp_tiny_mce_init', array( $this, 'new_tinymce_iconize_plugin_check' ) );
			} else {
				add_filter( 'tiny_mce_plugins', ( array( $this, 'tinymce_iconize_plugin_check' ) ), 1 );
			}
			// Check if our quicktag plugin is included on editor instance.
			add_filter( 'quicktags_settings', ( array( $this, 'quicktags_iconize_plugin_check' ) ), 10, 2 );

			// Add dialog to footer and enqueue scripts and styles for it if needed.
			add_action( 'admin_footer', ( array( $this, 'iconize_editor_dialog_scripts' ) ), 999999999 );
			add_action( 'wp_footer', ( array( $this, 'iconize_editor_dialog_scripts' ) ), 999999999 );
		}
		
		// Widget system integration if enabled.
		if ( $widget_icons_enabled ) {

			// Add icon button and input fields to widget form.
			add_action( 'in_widget_form', ( array( $this, 'iconize_in_widget_form' ) ), 5, 3 );
			// Handle widget form update.
			add_filter( 'widget_update_callback', ( array( $this, 'iconize_in_widget_form_update' ) ), 5, 3 );
			// Add icon to output, before widget title.
			add_filter( 'dynamic_sidebar_params', array( $this, 'iconize_dynamic_sidebar_params' ) );

			// Compatibility with Widget Customizer Plugin ( before WP 3.9 ) or core customize widgets functionality ( from WP 3.9 )
			if ( class_exists( 'Widget_Customizer' ) || class_exists( 'WP_Customize_Widgets' ) ) {
				
				add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_iconize_styles' ) );
				add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_iconize_admin_scripts_and_styles' ) );
				add_action( 'customize_controls_print_footer_scripts', array( $this, 'iconize_admin_dialog' ) );
			}
		}

		// Custom Menus system integration if enabled.
		if ( $menu_icons_enabled ) {

			// Add icon button and input fields to nav menu item form.
			add_action( 'wp_nav_menu_item_custom_fields', ( array( $this, 'iconize_nav_menu_item_custom_fields' ) ), 10, 4 );
			// Handle nav menu item form form update.
			add_action( 'wp_update_nav_menu_item', ( array( $this, 'iconize_update_nav_menu_item' ) ), 10, 3 );
			// Add icon properties to nav menu item object.
			add_filter( 'wp_setup_nav_menu_item', array( $this, 'iconize_setup_nav_menu_item' ) );
			// Call our custom edit walker on edit nav menu screen.
			add_filter( 'wp_edit_nav_menu_walker', array( $this, 'iconize_edit_nav_menu_walker' ) );
			
			/**
			 * Allow users to choose how the plugin will attach itself to menus on front end and easaly fix conflicts with other menu walkers.
			 *
			 * Possible returned strings - title_link, title, walker
			 */
			$menu_hook = (string) apply_filters( 'iconize_menu_items_with', 'walker' );

			if ( 'title_link' == $menu_hook ) {

				// The best one, but most of custom walkers out there are omitting "nav_menu_link_attributes" filter...
				add_filter( 'nav_menu_link_attributes', ( array( $this, 'iconize_nav_menu_link_attributes' ) ), 10, 3 );
				add_filter( 'the_title', ( array( $this, 'iconize_menu_item_title' ) ), 10, 2 );

			} else if ( 'title' == $menu_hook ) {

				// The best chance to work - most of custom walkers out there have "the_title" filter
				add_filter( 'the_title', ( array( $this, 'iconize_menu_item_title_all' ) ), 10, 2 );

			} else if ( 'walker' == $menu_hook ) {

				// Call our custom output walker on all nav menus ( default because of the previous versions of Iconize ).
				add_filter( 'wp_nav_menu_args', array( $this, 'iconize_nav_menu_args' ) );
			}
			// else - find another way :)
		}
	}

	/**
	 * Function to apply Iconize plugin support to taxonomies
	 *
	 * @since    1.1.0
	 */
	public function iconize_taxonomies() {

		// Taxonomies
		$supported_taxonomies = array();

		$args = array(
			'public'   => true,
			'show_ui' => true
		); 
		$output = 'names';
		$operator = 'and';

		$taxonomies = get_taxonomies( $args, $output, $operator );

		if ( $taxonomies ) {

			foreach ( $taxonomies  as $taxonomy ) {

				$tax_support = $this->get_iconize_support_for( 'taxonomy_'.$taxonomy );
				$tax_icons_enabled  = $tax_support['enabled'];

				if ( taxonomy_exists( $taxonomy ) && $tax_icons_enabled ) {

					$supported_taxonomies[] = $taxonomy;
				}
			}
		}

		if ( ! empty( $supported_taxonomies ) ) {

			foreach ( $supported_taxonomies as $taxonomy ) {

				// Add icon option to taxonomy terms settings
				add_action( $taxonomy.'_add_form_fields', array( $this, 'iconize_taxonomy_add_form_fields' ) );
				add_action( $taxonomy.'_edit_form_fields', ( array( $this, 'iconize_taxonomy_edit_form_fields' ) ), 10, 2 );
				// Add icon column to taxonomy terms tables
				add_filter('manage_edit-'.$taxonomy.'_columns', array( $this, 'iconize_term_columns_head' ) );
				add_filter('manage_'.$taxonomy.'_custom_column', ( array( $this, 'iconize_term_column_content' ) ), 10, 3 );
			}

			// Handle creating/editing/deleting of term icons
			add_action( 'created_term', ( array( $this, 'iconize_create_update_taxonomy_icon' ) ), 10, 3 );
			add_action( 'edited_term', ( array( $this, 'iconize_create_update_taxonomy_icon' ) ), 10, 3 );
			add_action( 'delete_term', ( array( $this, 'iconize_delete_taxonomy_icon' ) ), 10, 3 );
			// Iconize wp_list_categories() and wp_generate_tag_cloud()
			add_filter( 'wp_list_categories', ( array( $this, 'iconize_list_taxonomies' ) ), 99, 2 );
			add_filter( 'wp_generate_tag_cloud', ( array( $this, 'iconize_wp_generate_tag_cloud' ) ), 99, 3 );

			// Check if there is dialog on widgets screen, because we need it there
			$wid_support           = $this->get_iconize_support_for('widgets');
			$widget_icons_enabled  = $wid_support['enabled'];

			if ( ! $widget_icons_enabled ) {
				
				// Add dialog with scripts and styles for it
				add_filter('add_iconize_dialog_to_screens', array( $this, 'return_widgets_screen' ) );
			}
		}
	}

	/**
	 * Function to register our widgets ( only one widget for now ).
	 *
	 * @since    1.1.0
	 */
	public function iconize_widgets() {

		// Taxonomies
		$supported_taxonomies = array();

		$args = array(
			'public'   => true,
			'show_ui' => true
		); 
		$output = 'names';
		$operator = 'and';

		$taxonomies = get_taxonomies( $args, $output, $operator );

		if ( $taxonomies ) {

			foreach ( $taxonomies  as $taxonomy ) {

				$tax_support = $this->get_iconize_support_for( 'taxonomy_'.$taxonomy );
				$tax_icons_enabled  = $tax_support['enabled'];

				if ( taxonomy_exists( $taxonomy ) && $tax_icons_enabled ) {

					$supported_taxonomies[] = $taxonomy;
				}
			}
		}

		if ( ! empty( $supported_taxonomies ) ) {

			register_widget( 'IconizeWidgetTaxonomies' );
		}
	}


	//////////////////////
	////// Settings //////
	//////////////////////

	/**
	 * Register options.
	 *
	 * @since 1.0.0
	 *
	 * @uses Iconize_WP::get_iconize_support_for()
	 * @uses Iconize_WP::iconize_options_general_section_callback()
	 * @uses Iconize_WP::iconize_options_checkbox_callback()
	 */
	public function init_iconize_plugin_options() {

		// Register settings.
		register_setting(
			'general_settings_section',
			'icons_to_nav_menus'
		);

		register_setting(
			'general_settings_section',
			'icons_to_widgets'
		);

		register_setting(
			'general_settings_section',
			'icons_to_editor'
		);

		// Add options.
		$mce_plugin_support   = $this->get_iconize_support_for( 'editor' );
		$widget_icons_support = $this->get_iconize_support_for( 'widgets' );
		$menu_icons_support   = $this->get_iconize_support_for( 'nav_menus' );

		$mce_plugin_enabled   = $mce_plugin_support['enabled'];
		$widget_icons_enabled = $widget_icons_support['enabled'];
		$menu_icons_enabled   = $menu_icons_support['enabled'];

		$show_mce_plugin_option = $mce_plugin_support['show_in_options'];
		$show_widget_option     = $widget_icons_support['show_in_options'];
		$show_menu_option       = $menu_icons_support['show_in_options'];
		
		if ( $show_mce_plugin_option || $show_widget_option || $show_menu_option ) {

			add_settings_section(
				'general_settings_section',
				__( 'Choose plugin components', $this->plugin_slug ),
				array( $this, 'iconize_options_general_section_callback' ),
				$this->plugin_slug
			);
		
			if ( $show_menu_option ) {

				add_settings_field(
					'icons_to_nav_menus',
					__( 'Menus', $this->plugin_slug ),
					array( $this, 'iconize_options_checkbox_callback' ),
					$this->plugin_slug,
					'general_settings_section',
					array(
						'id' => 'icons_to_nav_menus',
						'label' =>  __( 'Enable custom menus system integration?', $this->plugin_slug ),
						'default'=> $menu_icons_enabled
					)
				);
			}

			if ( $show_widget_option ) {

				add_settings_field(
					'icons_to_widgets',
					__( 'Widgets', $this->plugin_slug ),
					array( $this, 'iconize_options_checkbox_callback' ),
					$this->plugin_slug, 'general_settings_section',
					array(
						'id' => 'icons_to_widgets',
						'label' =>  __( 'Enable widget system integration?', $this->plugin_slug ),
						'default'=> $widget_icons_enabled
					)
				);
			}
			
			if ( $show_mce_plugin_option ) {

				add_settings_field(
					'icons_to_editor',
					__( 'Editors', $this->plugin_slug ),
					array( $this, 'iconize_options_checkbox_callback' ),
					$this->plugin_slug,
					'general_settings_section',
					array( 
						'id' => 'icons_to_editor',
						'label' =>  __( 'Enable plugin integration on editors?', $this->plugin_slug ),
						'default'=> $mce_plugin_enabled
					)
				);
			}
		}

		// Taxonomies
		$args = array(
			'public'   => true,
			'show_ui' => true
		); 
		$output = 'objects';
		$operator = 'and';

		$taxonomies = get_taxonomies( $args, $output, $operator );

		if ( $taxonomies ) {

			foreach ( $taxonomies  as $taxonomy ) {

				register_setting(
					'general_settings_section',
					'icons_to_taxonomy_'.$taxonomy->name
				);

				$tax_support = $this->get_iconize_support_for( 'taxonomy_'.$taxonomy->name );

				$tax_icons_enabled  = $tax_support['enabled'];
				$show_tax_option    = $tax_support['show_in_options'];

				if ( $show_tax_option ) {

					add_settings_field(
						'icons_to_taxonomy_'.$taxonomy->name,
						$taxonomy->labels->name,
						array( $this, 'iconize_options_checkbox_callback' ),
						$this->plugin_slug,
						'general_settings_section',
						array(
							'id' => 'icons_to_taxonomy_'.$taxonomy->name,
							'label' =>  sprintf( __( 'Enable plugin integration on %1$s ( post type: %2$s )?', $this->plugin_slug ), $taxonomy->label, $taxonomy->object_type[0] ),
							'default'=> $tax_icons_enabled
						)
					);
				}
			}
		}
	}
	
	/**
	 * General section callback function.
	 *
	 * @since 1.0.0
	 */
	public function iconize_options_general_section_callback() {

		_e( 'Here you can enable/disable Iconize WordPress plugin integration on specific WordPress system.', $this->plugin_slug );
	}
	
	/**
	 * Checkbox option callback function.
	 *
	 * @since 1.0.0
	 */
	public function iconize_options_checkbox_callback( $args ) {

		$html = '<input type="checkbox" id="' . $args['id'] . '" name="' . $args['id'] . '" value="1" ' . checked( 1, get_option( $args['id'], $args['default'] ), false ) . '/>';
		$html .= '<label for="' . $args['id'] . '"> ' . $args['label'] . '</label>';
		
		echo $html;
	}

	/**
	 * Register the administration menu for Iconize plugin.
	 *
	 * @since 1.0.0
	 *
	 * @uses Iconize_WP::display_iconize_plugin_admin_page()
	 */
	public function iconize_plugin_admin_menu() {

		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Iconize Plugin Settings', $this->plugin_slug ),
			__( 'Iconize Settings', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_iconize_plugin_admin_page' )
		);
	}

	/**
	 * Render the settings page for Iconize plugin.
	 *
	 * @since 1.0.0
	 */
	public function display_iconize_plugin_admin_page() {
	?>
		<div class="wrap">
			<?php screen_icon(); ?>
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<form method="post" action="options.php">
				<?php settings_fields( 'general_settings_section' ); ?>
				<?php do_settings_sections( $this->plugin_slug ); ?>
				<?php submit_button(); ?>
			</form>
		</div>
	<?php
	}

	/**
	 * Add settings action link to plugin on plugins screen.
	 *
	 * @since 1.0.0
	 */
	public function add_iconize_plugin_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
			),
			$links
		);
	}

	///////////////////////////////
	////// Basic integration //////
	///////////////////////////////

	/**
	 * Enqueue main iconize plugin styles and styles with fonts and icons defined.
	 *
	 * @since 1.0.0
	 *
	 * @uses Iconize_WP::get_iconize_fonts_styles()
	 */
	public function enqueue_iconize_styles() {

		// Use the .min suffix if SCRIPT_DEBUG is turned off.
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		// Main styles.
		wp_enqueue_style(
			'iconize-styles',
			plugins_url( "css/iconize$suffix.css", __FILE__ ),
			array(),
			$this->version
		);

		// Styles with fonts and icons defined.
		$iconize_fonts_stylesheets = $this->get_iconize_fonts_styles();
		
		foreach ( $iconize_fonts_stylesheets as $handle => $array ) {

			$handle = 'iconize-'. $handle .'-font-styles';

			if ( is_array( $array ) && array_key_exists( 'url', $array ) && ! empty( $array['url'] ) ) {

				// if dashicons are enabled set 'dashicons' as dependency for our custom dashicons CSS.
				$deps = ( 'iconize-dashicons-font-styles' === $handle ) ? array('dashicons') : array();

				wp_enqueue_style( $handle, $array['url'], $deps, $this->version );
			}
		}
	}

	/**
	 * Add styles to visual editor.
	 *
	 * @since 1.0.0
	 *
	 * @uses Iconize_WP::get_iconize_fonts_styles()
	 *
	 * @param array   $mce_css
	 * @return array  $mce_css
	 */
	public function iconize_mce_css( $mce_css ) {

		if ( ! empty( $mce_css ) ) {

			$mce_css .= ',';
		}

		// Use the .min suffix if SCRIPT_DEBUG is turned off.
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		// Main styles.
		$mce_css .= plugins_url( "css/iconize$suffix.css", __FILE__ );

		// Styles with fonts and icons defined.
		$iconize_fonts_stylesheets = $this->get_iconize_fonts_styles();
		
		foreach ( $iconize_fonts_stylesheets as $handle => $array ) {

			// if Dashicons are enabled we must add default dashicons styles too.
			if ( 'dashicons' === $handle ) {

				$mce_css .= ',';
				$mce_css .= includes_url() . 'css/dashicons.min.css';
			}

			$mce_css .= ',';
			$mce_css .= $array['url'];
		}

		return $mce_css;
	}

	/**
	 * Enqueue css and js for admin dialog.
	 *
	 * @since 1.0.0
	 *
	 * @uses Iconize_WP::get_iconize_support_for()
	 * @uses Iconize_WP::get_extra_iconize_dialog_support()
	 * @uses Iconize_WP::get_iconize_dialog_strings()
	 * @uses Iconize_WP::get_icons_array()
	 * @uses Iconize_WP::get_iconize_dialog_inline_styles()
	 */
	public function enqueue_iconize_admin_scripts_and_styles() {

		// Check if plugin is enabled on widgets/nav menus.
		$widget_icons_support = $this->get_iconize_support_for( 'widgets' );
		$menu_icons_support   = $this->get_iconize_support_for( 'nav_menus' );

		$widget_icons_enabled = $widget_icons_support['enabled'];
		$menu_icons_enabled   = $menu_icons_support['enabled'];

		// Get screens ids of supported taxonomies
		$supported_taxonomy_screens = $this->iconize_get_supported_taxonomy_screens_ids();

		// Check if user enabled dialog on other admin pages.
		$extra_admin_screens_array = $this->get_extra_iconize_dialog_support();

		// Get current screen id 
		$screen = get_current_screen();
		$screen_id = $screen->id;

		$add_to_nav_menus = ( 'nav-menus' === $screen_id && $menu_icons_enabled );
		$add_to_widgets   = ( 'widgets' === $screen_id && $widget_icons_enabled );
		$add_to_tax       = ( in_array( $screen_id, $supported_taxonomy_screens ) );
		$add_to_other     = ( in_array( $screen_id, $extra_admin_screens_array ) );

		$current_filter = current_filter();
	
		if ( $add_to_nav_menus || $add_to_widgets || $add_to_tax || $add_to_other || 'customize_controls_enqueue_scripts' === $current_filter ) {

			// Use the .min suffix if SCRIPT_DEBUG is turned off.
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			// Styles.
			wp_enqueue_style(
				'iconize-bootstrap-modal',
				plugins_url( "css/bootstrap-modal$suffix.css", __FILE__ ),
				array(),
				$this->version
			);

			wp_enqueue_style(
				'iconize-dialog',
				plugins_url( "css/iconize-dialog$suffix.css", __FILE__ ),
				array(),
				$this->version
			);

			$dialog_inline_styles = $this->get_iconize_dialog_inline_styles();
			if ( $dialog_inline_styles ) {

				wp_add_inline_style( 'iconize-dialog', $dialog_inline_styles );
			}

			wp_enqueue_style( 'wp-color-picker' );

			// Scripts.
			wp_enqueue_script(
				'iconize-bootstrap-modal',
				plugins_url( "js/bootstrap-modal$suffix.js", __FILE__ ),
				array( 'jquery' ),
				$this->version,
				true
			);

			wp_enqueue_script(
				'iconize-helpers',
				plugins_url( "js/iconize-helpers$suffix.js", __FILE__ ),
				array( 'jquery-ui-autocomplete', 'jquery-effects-blind',
					'jquery-effects-highlight' ),
				$this->version,
				true
			);

			$iconize_dialog_l10n = $this->get_iconize_dialog_strings();
			$icons_arr = $this->get_icons_array();

			$iconize_dialog_params = array( 'l10n' => $iconize_dialog_l10n );
			$iconize_dialog_params['icons'] = empty( $icons_arr ) ? false : $icons_arr;

			wp_localize_script( 'iconize-helpers', 'iconizeDialogParams', $iconize_dialog_params );

			wp_enqueue_script(
				'iconize-admin-dialog',
				plugins_url( "js/iconize-admin-dialog$suffix.js", __FILE__ ),
				array(
					'iconize-bootstrap-modal',
					'iconize-helpers',
					'wp-color-picker'
				),
				$this->version,
				true
			);
		}
	}

	/**
	 * Render the dialog for admin screens.
	 *
	 * @since 1.0.0
	 *
	 * @uses Iconize_WP::get_iconize_support_for()
	 * @uses Iconize_WP::get_extra_iconize_dialog_support()
	 * @uses Iconize_WP::iconize_dialog()
	 */
	public function iconize_admin_dialog() {
		
		// Check if plugin is enabled on widgets or nav menus.
		$widget_icons_support = $this->get_iconize_support_for( 'widgets' );
		$menu_icons_support   = $this->get_iconize_support_for( 'nav_menus' );

		$widget_icons_enabled = $widget_icons_support['enabled'];
		$menu_icons_enabled   = $menu_icons_support['enabled'];

		// Get screens ids of supported taxonomies
		$supported_taxonomy_screens = $this->iconize_get_supported_taxonomy_screens_ids();

		// Check if dialog is enabled on other admin pages by user.
		$extra_admin_screens_array = $this->get_extra_iconize_dialog_support();

		// Get current screen id 
		$screen = get_current_screen();
		$screen_id = $screen->id;

		$add_to_nav_menus = ( 'nav-menus' === $screen_id && $menu_icons_enabled );
		$add_to_widgets   = ( 'widgets' === $screen_id && $widget_icons_enabled );
		$add_to_tax       = ( in_array( $screen_id, $supported_taxonomy_screens ) );
		$add_to_other     = ( in_array( $screen_id, $extra_admin_screens_array ) );


		$current_filter = current_filter();
		if ( $add_to_nav_menus || $add_to_widgets || $add_to_tax || $add_to_other ||  'customize_controls_print_footer_scripts' === $current_filter ) {

			/**
			 * Allow users to customize dialog options for specific admin screen.
			 *
			 * Example case:
			 * array( 'transform', 'color' ) is an array returned by users function attached to "iconize_dialog_options_for_nav-menu" filter,
			 * the plugin will display only icon transform dropdown option and icon color option on nav-menu screen.
			 * To disable all options function must return boolean false or empty array ( empty string wont work, it is reserved for default options ).
			 *
			 * Possible array values - transform, animate, hover, color, size, align, custom_classes
			 */
			$dialog_opts = apply_filters( "iconize_dialog_options_for_{$screen_id}", array( 'transform', 'animate', 'hover', 'color', 'custom_classes' ) );
			$dialog_btns = array( 'remove' );
			
			$this->iconize_dialog( 'admin', $dialog_opts, $dialog_btns );
		}
	}

	/////////////////////////////////
	////// Editors integration //////
	/////////////////////////////////

	/**
	 * Allow contenteditable attribute on <i> and <span> tags.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $settings_array
	 * @return array $settings_array
	 */
	public function iconize_mce_allow_contenteditable_attr ( $settings_array ) {
		
		$ext = 'i[*|contenteditable],span[*|contenteditable]';
	
		if ( isset( $settings_array['extended_valid_elements'] ) ) {

			$settings_array['extended_valid_elements'] .= ',' . $ext;

		} else {

			$settings_array['extended_valid_elements'] = $ext;
		}
	
		return $settings_array;
	}

	/**
	 * Add plugins to TinyMCE editor.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $plugins
	 * @return array $plugins
	 */
	public function iconize_mce_plugins( $plugins ) {

		global $tinymce_version;
		$editor_version = (int) $tinymce_version[0];

		// Use the .min suffix if SCRIPT_DEBUG is turned off.
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		if ( $editor_version > 3 ) {

			$plugins['iconize_mce'] = plugins_url( "/tinymce/editor_plugin$suffix.js", __FILE__ );

		} else {

			// Backward compatibility - inline bootstrap modal popup plugin + iconize plugin
			$plugins['bootstrapmodal'] = plugins_url( "/tinymce/modal_bc$suffix.js", __FILE__ );
			$plugins['iconize_mce'] = plugins_url( "/tinymce/editor_plugin_bc$suffix.js", __FILE__ );
		}

		return $plugins;
	}

	/**
	 * TinyMCE Plugin Localization file.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $array
	 * @return array $array
	 */
	public function iconize_mce_lang( $array ) {

		$array['iconize_mce'] = plugin_dir_path( __FILE__ ) . '/tinymce/langs/iconize-langs.php';

		return $array;
	}

	/**
	 * Register TinyMCE editor buttons.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $buttons
	 * @return array $buttons
	 */
	
	function iconize_mce_buttons( $buttons ) {

		array_push( $buttons, 'insert_icon', 'swap_icon_positions', 'swap_icon_sizes', 'remove_icon' );

		return $buttons;
	}
	
	/**
	 * Enable tinyMCE IconizePlugin buttons on fullscreen mode.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $buttons
	 * @return array $buttons
	 */
	public function iconize_mce_fullscreen_buttons( $buttons ) {

		global $tinymce_version;
		$editor_version = (int) $tinymce_version[0];

		if ( $editor_version > 3 ) {

			$fs_func = "wp.editor.fullscreen.insertIcon();";

		} else {

			$fs_func = "fullscreen.insertIcon();";
		}

		$buttons['insert_icon'] = array(
			'title'   => __( 'Insert/Edit icon', $this->plugin_slug ),
			'onclick' => $fs_func,
			'both'    => true
		);

		$buttons['swap_icon_positions'] = array(
			'title'   => __( 'Swap positions of stacked icons', $this->plugin_slug ),
			'onclick' => "tinymce.execCommand('swapIconsPositions');",
			'both'    => false
		);

		$buttons['swap_icon_sizes'] = array(
			'title'   => __( 'Swap sizes of stacked icons', $this->plugin_slug ),
			'onclick' => "tinymce.execCommand('swapIconsSizes');",
			'both'    => false
		);

		$buttons['remove_icon'] = array(
			'title'   => __( 'Delete icon', $this->plugin_slug ),
			'onclick' => "tinymce.execCommand('removeIcon');",
			'both'    => false
		);

		return $buttons;
	}

	/**
	 * Check if our TinyMCE plugin is included on wp_editor instance ( WP 3.9+ ).
	 *
	 * Function is attached to 'wp_tiny_mce_init' filter.
	 *
	 * @since 1.1.4
	 *
	 * @param array   $settings
	 * @return array  $settings
	 */
	public function new_tinymce_iconize_plugin_check( $settings ) {

		$arr = $settings;
	    reset($arr);
	    $first_arr = current($arr);
	    $external_plugins = $first_arr['external_plugins'];

	    if( strpos( $external_plugins, 'iconize_mce' ) !== false ) {
	        $this->enqueue_wpbs = true;
			$this->tinymce_iconize_plugin_enabled = true;
	    } else {
	    	$this->enqueue_wpbs = false;
			$this->tinymce_iconize_plugin_enabled = false;
	    }
	    return $settings;
	}
	
	/**
	 * Check if our TinyMCE plugins are included on wp_editor instance.
	 *
	 * Function is attached to 'tiny_mce_plugins' filter.
	 *
	 * @since 1.0.0
	 *
	 * @param array   $plugins
	 * @return array  $plugins
	 */
	public function tinymce_iconize_plugin_check( $plugins ) {

		global $tinymce_version;
		$editor_version = (int) $tinymce_version[0];

		if ( $editor_version > 3 ) {

			$this->enqueue_wpbs = in_array( '-iconize_mce', $plugins );
			$this->tinymce_iconize_plugin_enabled = in_array( '-iconize_mce', $plugins );

		} else {

			$this->enqueue_wpbs = in_array( '-bootstrapmodal', $plugins );
			$this->tinymce_iconize_plugin_enabled = in_array( '-bootstrapmodal', $plugins ) && in_array( '-iconize_mce', $plugins );
		}
		
		return $plugins;
	}

	/**
	 * Add "iconize_quicktags" parameter to "quicktags" options in settings of wp_editor(),
	 * and check if our quicktags plugin is enabled on wp_editor instance.
	 *
	 * Function is attached to 'quicktags_settings' filter.
	 *
	 * @since 1.0.0
	 *
	 * @param array   $qtInit
	 * @param string  $editor_id
	 * @return array  $qtInit
	 */
	public function quicktags_iconize_plugin_check( $qtInit, $editor_id ) {

		if ( ! isset( $qtInit['iconize_quicktags'] ) ) {

			$screen_id = '';

			if ( is_admin() ) {

				// Get current screen id 
				$screen = get_current_screen();
				if ( $screen) {

					$screen_id = $screen->id;
				}
			}

			/**
			 * Apply "iconize_quicktags" filter to allow users to change default value of "iconize_quicktags" parameter
			 * on specific editor instance ( passed editor id and current admin screen id to target the editor instance ).
			 */
			$qtInit['iconize_quicktags'] = (bool) apply_filters( 'iconize_quicktags', true , $editor_id, $screen_id );
		}

		$this->enqueue_wpbs = $qtInit['iconize_quicktags'];
		$this->quicktags_iconize_plugin_enabled = $qtInit['iconize_quicktags'];

		return $qtInit;
	}

	/**
	 * Enqueue scripts and styles for editor dialog and render the dialog only on pages where editor with our plugins included exists.
	 *
	 * @since 1.0.0
	 *
	 * @uses Iconize_WP::enqueue_wpbs
	 * @uses Iconize_WP::tinymce_iconize_plugin_enabled
	 * @uses Iconize_WP::quicktags_iconize_plugin_enabled
	 * @uses Iconize_WP::get_iconize_dialog_inline_styles()
	 * @uses Iconize_WP::get_iconize_dialog_strings()
	 * @uses Iconize_WP::get_icons_array()
	 */
	public function iconize_editor_dialog_scripts() {

		global $tinymce_version;
		$editor_version = (int) $tinymce_version[0];

		// Check which plugins are active to know what to enqueue.
		$enqueue_wpbs = $this->enqueue_wpbs;
		$tinymce_iconize_plugin_enabled = $this->tinymce_iconize_plugin_enabled;
		$quicktags_iconize_plugin_enabled = $this->quicktags_iconize_plugin_enabled;

		// Use the .min suffix if SCRIPT_DEBUG is turned off.
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		// Compatibility with Black Studio TinyMCE Widget Plugin ( only on widgets screen )
		$bs_widget_active = false;
		if ( is_admin() ) {
			$screen = get_current_screen();
			$screen_id = $screen->id;
			if ( in_array( 'black-studio-tinymce-widget/black-studio-tinymce-widget.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && 'widgets' === $screen_id ) {
				$bs_widget_active = true;
			}
		}

		// Allow bootstrapmodal plugin usage for other TinyMCE plugins.
		if ( $enqueue_wpbs ) {

			// Check if styles and scripts for bootstrap modal are already enqueued before adding them.
			if ( ! wp_style_is( 'iconize-bootstrap-modal', 'enqueued' ) ) {

				wp_enqueue_style(
					'iconize-bootstrap-modal',
					plugins_url( "css/bootstrap-modal$suffix.css", __FILE__ ),
					array(),
					$this->version
				);
			}

			if ( ! wp_script_is( 'iconize-bootstrap-modal', 'enqueued' ) ) {

				wp_enqueue_script(
					'iconize-bootstrap-modal',
					plugins_url( "js/bootstrap-modal$suffix.js", __FILE__ ),
					array( 'jquery' ),
					$this->version,
					true
				);
			}
		}

		// Enqueue iconize dialog scripts and styles only if both of our editor plugins are called or quicktags plugin is called.
		if ( $tinymce_iconize_plugin_enabled || $quicktags_iconize_plugin_enabled || $bs_widget_active ) {

			// Check if specific styles and scripts are already enqueued before adding them.
			if ( ! wp_style_is( 'iconize-dialog', 'enqueued' ) ) {

				wp_enqueue_style(
					'iconize-dialog',
					plugins_url( "css/iconize-dialog$suffix.css", __FILE__ ),
					array(),
					$this->version
				);

				$dialog_inline_styles = $this->get_iconize_dialog_inline_styles();
				if ( $dialog_inline_styles ) {

					wp_add_inline_style( 'iconize-dialog', $dialog_inline_styles );
				}
			}

			if ( ! wp_style_is( 'wp-color-picker', 'enqueued' ) ) {

				wp_enqueue_style( 'wp-color-picker' );
			}

			if ( ! wp_script_is( 'iconize-helpers', 'enqueued' ) ) {

				wp_enqueue_script(
					'iconize-helpers',
					plugins_url( "js/iconize-helpers$suffix.js", __FILE__ ),
					array(
						'jquery-ui-autocomplete',
						'jquery-effects-blind' ,
						'jquery-effects-highlight'
					),
					$this->version,
					true
				);

				$iconize_dialog_l10n = $this->get_iconize_dialog_strings();
				$icons_arr = $this->get_icons_array();

				$iconize_dialog_params = array( 'l10n' => $iconize_dialog_l10n );
				$iconize_dialog_params['icons'] = empty( $icons_arr ) ? false : $icons_arr;

				wp_localize_script( 'iconize-helpers', 'iconizeDialogParams', $iconize_dialog_params );
			}
			
			if ( is_admin() ) {

				if ( ! wp_script_is( 'wp-color-picker', 'enqueued' ) ) {

					wp_enqueue_script( 'wp-color-picker' );
				}

			} else {

				/**
				 * If tinymce editor with iconize mce plugins is called on the front end, simple wp_enqueue_script( 'wp-color-picker' ) won't work.
				 * NOTE: if you call iconize editor plugins on front end editor instance you'll need to style the dialog.
				 */
				wp_enqueue_script(
					'iris',
					admin_url( 'js/iris.min.js' ),
					array(
						'jquery-ui-draggable',
						'jquery-ui-slider',
						'jquery-touch-punch'
					),
					false,
					true
				);

				wp_enqueue_script(
					'wp-color-picker',
					admin_url( 'js/color-picker.min.js' ),
					array( 'iris' ),
					false,
					true
				);

				$colorpicker_l10n = array(
					'clear'         => __( 'Clear' ),
					'defaultString' => __( 'Default' ),
					'pick'          => __( 'Select Color' )
				);
				wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', $colorpicker_l10n );
			}

			$bc_suffix = ( $editor_version >  3 ) ? '' : '_bc';
			// Enqueue editor dialog script.
			wp_enqueue_script(
				'iconize-mce-dialog',
				plugins_url( "tinymce/dialog$bc_suffix$suffix.js", __FILE__ ),
				array('iconize-helpers'),
				$this->version,
				true
			);

			/**
			 * Pass Iconize_WP::quicktags_iconize_plugin_enabled variable value to dialog script
			 * so that we can add "icon" button to quicktags from there if enabled.
			 */
			$iconize_dialog_settings = array( 'iconizeQuicktags' => $quicktags_iconize_plugin_enabled );
			
			wp_localize_script( 'iconize-mce-dialog', 'iconizeSettings',  $iconize_dialog_settings );

			// Render the dialog.
			$this->iconize_dialog( 'mce' );
		}
	}
	
	///////////////////////////////////////
	////// Widget system integration //////
	///////////////////////////////////////
	
	/**
	 * Add Icon option to widgets settings.
	 *
	 * @since 1.0.0
	 *
	 * @param object  $t
	 * @param $return
	 * @param array   $instance
	 * @return array
	 */
	public function iconize_in_widget_form( $t, $return, $instance ) {
		
		$instance = wp_parse_args( (array) $instance, array( 'icon_name' => '', 'icon_set' => '', 'icon_transform' => '', 'icon_color' => '', 'icon_size' => '', 'icon_align' => '', 'icon_custom_classes' => '') );
		
		if ( ! isset( $instance['icon_name'] ) ) {

			$instance['icon_name'] = null;
		}
		
		if ( ! isset( $instance['icon_set'] ) ) {

			$instance['icon_set'] = null;
		}

		if ( ! isset( $instance['icon_transform'] ) ) {

			$instance['icon_transform'] = null;
		}

		if ( ! isset( $instance['icon_color'] ) ) {

			$instance['icon_color'] = null;
		}

		if ( ! isset( $instance['icon_size'] ) ) {

			$instance['icon_size'] = null;
		}

		if ( ! isset( $instance['icon_align'] ) ) {

			$instance['icon_align'] = null;
		}

		if ( ! isset( $instance['icon_custom_classes'] ) ) {

			$instance['icon_custom_classes'] = null;
		}
	?>
		<p>
			<label class="preview-icon-label">
				<?php _e('Title Icon:', $this->plugin_slug) ?>
				<button type="button" class="preview-icon button iconized-hover-trigger"><span class="iconized <?php echo $instance['icon_name']; ?> <?php echo $instance['icon_set']; ?> <?php echo $instance['icon_transform']; ?>"></span></button>
			</label>
			<span>
				<input type="hidden" id="<?php echo $t->get_field_id('icon_name'); ?>" class="iconize-input-name" name="<?php echo $t->get_field_name('icon_name'); ?>" value="<?php echo $instance['icon_name']; ?>">
				<input type="hidden" id="<?php echo $t->get_field_id('icon_set'); ?>" class="iconize-input-set" name="<?php echo $t->get_field_name('icon_set'); ?>" value="<?php echo $instance['icon_set']; ?>">
				<input type="hidden" id="<?php echo $t->get_field_id('icon_transform'); ?>" class="iconize-input-transform" name="<?php echo $t->get_field_name('icon_transform'); ?>" value="<?php echo $instance['icon_transform']; ?>">
				<input type="hidden" id="<?php echo $t->get_field_id('icon_color'); ?>" class="iconize-input-color" name="<?php echo $t->get_field_name('icon_color'); ?>" value="<?php echo $instance['icon_color']; ?>">
				<input type="hidden" id="<?php echo $t->get_field_id('icon_size'); ?>" class="iconize-input-size" name="<?php echo $t->get_field_name('icon_size'); ?>" value="<?php echo $instance['icon_size']; ?>">
				<input type="hidden" id="<?php echo $t->get_field_id('icon_align'); ?>" class="iconize-input-align" name="<?php echo $t->get_field_name('icon_align'); ?>" value="<?php echo $instance['icon_align']; ?>">
				<input type="hidden" id="<?php echo $t->get_field_id('icon_custom_classes'); ?>" class="iconize-input-custom-classes" name="<?php echo $t->get_field_name('icon_custom_classes'); ?>" value="<?php echo $instance['icon_custom_classes']; ?>">
			</span>
		</p>
		<p>
			<input id="<?php echo $t->get_field_id('icon_position'); ?>" name="<?php echo $t->get_field_name('icon_position'); ?>" type="checkbox" <?php checked( isset( $instance['icon_position'] ) ? $instance['icon_position'] : 0 ); ?> />&nbsp;<label for="<?php echo $t->get_field_id('icon_position'); ?>"><?php _e('Insert icon after the title', $this->plugin_slug); ?></label>
		</p>
	<?php
	
		$retrun = null;
		
		return array( $t, $return, $instance );
	}
	
	/**
	 * Handle widget settings update.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $instance
	 * @param array  $new_instance
	 * @param array  $old_instance
	 * @return array $instance
	 */
	public function iconize_in_widget_form_update( $instance, $new_instance, $old_instance ) {
		
		$instance['icon_name']           = $new_instance['icon_name'];
		$instance['icon_set']            = $new_instance['icon_set'];
		$instance['icon_transform']      = $new_instance['icon_transform'];
		$instance['icon_color']          = $new_instance['icon_color'];
		$instance['icon_size']           = $new_instance['icon_size'];
		$instance['icon_align']          = $new_instance['icon_align'];
		$instance['icon_custom_classes'] = $new_instance['icon_custom_classes'];
		$instance['icon_position']       = isset( $new_instance['icon_position'] );

		return $instance;
	}
	
	/**
	 * Add icon to widget title.
	 *
	 * @since 1.0.0
	 *
	 * @uses iconize_get_icon()
	 * @uses Iconize_WP::get_iconize_dialog_dropdown_options_for()
	 *
	 * @param array  $params
	 * @return array $params
	 */
	public function iconize_dynamic_sidebar_params( $params ) {
		
		global $wp_registered_widgets;
		$widget_id  = $params[0]['widget_id'];
		$widget_obj = $wp_registered_widgets[ $widget_id ];
		$widget_opt = get_option( $widget_obj['callback'][0]->option_name );
		$widget_num = $widget_obj['params'][0]['number'];
		
		$icon_args = array();

		$icon_args['icon_name']           = ( isset( $widget_opt[ $widget_num ]['icon_name'] ) ) ? $widget_opt[ $widget_num ]['icon_name'] : '';
		$icon_args['icon_set']            = ( isset( $widget_opt[ $widget_num ]['icon_set'] ) ) ? $widget_opt[ $widget_num ]['icon_set'] : '';
		$icon_args['icon_transform']      = ( isset( $widget_opt[ $widget_num ]['icon_transform'] ) ) ? $widget_opt[ $widget_num ]['icon_transform'] : '';
		$icon_args['icon_size']           = ( isset( $widget_opt[ $widget_num ]['icon_size'] ) ) ? $widget_opt[ $widget_num ]['icon_size'] : '';
		$icon_args['icon_align']          = ( isset( $widget_opt[ $widget_num ]['icon_align'] ) ) ? $widget_opt[ $widget_num ]['icon_align'] : '';
		$icon_args['icon_custom_classes'] = ( isset( $widget_opt[ $widget_num ]['icon_custom_classes'] ) ) ? $widget_opt[ $widget_num ]['icon_custom_classes'] : '';
		$icon_args['icon_color']          = ( isset( $widget_opt[ $widget_num ]['icon_color'] ) ) ? $widget_opt[ $widget_num ]['icon_color'] : '';

		$icon_args['icon_position']       = ( isset( $widget_opt[ $widget_num ]['icon_position'] ) ) ? $widget_opt[ $widget_num ]['icon_position'] : false;
		$icon_args['icon_position']       = $icon_args['icon_position'] ? 'after' : '';
		
		// Generate icon html.
		$icon_html = iconize_get_icon( $icon_args , 'widget_title' );

		// Take all hover effects
		$hovers = $this->get_iconize_dialog_dropdown_options_for( 'hover' );
		$hovers = array_keys( $hovers );

		// Check for "hover-color-change" class in custom classes list
		$hover_color_change = strpos( $icon_args['icon_custom_classes'], 'hover-color-change' );

		// If hover effect is included, wrap icon and title with span.iconized-hover-trigger
		if ( ( ! empty( $icon_args['icon_transform'] ) && in_array( $icon_args['icon_transform'], $hovers ) ) || false !== $hover_color_change ) {

			$params[0]['before_title'] .= '<span class="iconized-hover-trigger">';

			if ( 'after' === $icon_args['icon_position'] ) {

				$after_title = $params[0]['after_title'];
				$params[0]['after_title'] = $icon_html . '</span>' . $after_title;

			} else {

				$params[0]['before_title'] .= $icon_html;
				$after_title = '</span>' . $params[0]['after_title'];
			}

		} else {

			// Just insert icon before or after the title
			if ( 'after' === $icon_args['icon_position'] ) {

				$after_title = $params[0]['after_title'];
				$params[0]['after_title'] = $icon_html . $after_title;

			} else {

				$params[0]['before_title'] .= $icon_html;
			}
		}

		return $params;
	}
	
	/////////////////////////////////////////////
	////// Custom Menus system integration //////
	/////////////////////////////////////////////
	
	/**
	 * Add icon option to custom menus system.
	 *
	 * @since 1.0.0
	 *
	 * @uses Iconize_WP::get_iconize_support_for()
	 * @uses Iconize_WP::iconize_get_term_icon_by()
	 *
	 * @param string $item_id
	 * @param object $item
	 * @param string $depth
	 * @param array  $args
	 */
	public function iconize_nav_menu_item_custom_fields( $item_id, $item, $depth, $args ) {

		// Icon params.
		$icon_name           = $item->icon_name;
		$icon_set            = $item->icon_set;
		$icon_transform      = $item->icon_transform;
		$icon_color          = $item->icon_color;
		$icon_size           = $item->icon_size;
		$icon_align          = $item->icon_align;
		$icon_custom_classes = $item->icon_custom_classes;
		$icon_position       = $item->icon_position;

		// Display taxonomy term icon when item is added to menu if available.
		$status = $item->post_status;
		$type   = $item->type;

		if ( 'draft' ===  $status && 'taxonomy' === $type ) {

			$taxonomy = $item->object;
			$term_id  = $item->object_id;

			$tax_support = $this->get_iconize_support_for( 'taxonomy_'.$taxonomy );
			$tax_icons_enabled  = $tax_support['enabled'];

			if ( $tax_icons_enabled ) {

				$term_icon_args = iconize_get_term_icon_by( 'id', $term_id, $taxonomy, 'array' );

				if ( ! empty( $term_icon_args ) ) {

					$icon_name           = $term_icon_args['icon_name'];
					$icon_set            = $term_icon_args['icon_set'];
					$icon_transform      = $term_icon_args['icon_transform'];
					$icon_color          = $term_icon_args['icon_color'];
					$icon_size           = $term_icon_args['icon_size'];
					$icon_align          = $term_icon_args['icon_align'];
					$icon_custom_classes = $term_icon_args['icon_custom_classes'];
				}
			}
		}
	?>
		<p class="field-menu-item-icon description description-thin">
			<label class="preview-icon-label">
				<?php _e( 'Menu Item Icon: ', $this->plugin_slug ); ?><button type="button" class="preview-icon button iconized-hover-trigger"><span class="iconized <?php echo $icon_name; ?> <?php echo $icon_set; ?> <?php echo $icon_transform; ?>"></span></button>
			</label>
			<span>
				<input type="hidden" id="edit-menu-item-icon-name-<?php echo $item_id; ?>" class="edit-menu-item-icon-name iconize-input-name" name="menu-item-icon-name[<?php echo $item_id; ?>]" value="<?php echo $icon_name; ?>">
				<input type="hidden" id="edit-menu-item-icon-set-<?php echo $item_id; ?>" class="edit-menu-item-icon-set iconize-input-set" name="menu-item-icon-set[<?php echo $item_id; ?>]" value="<?php echo $icon_set; ?>">
				<input type="hidden" id="edit-menu-item-icon-transform-<?php echo $item_id; ?>" class="edit-menu-item-icon-transform iconize-input-transform" name="menu-item-icon-transform[<?php echo $item_id; ?>]" value="<?php echo $icon_transform; ?>">
				<input type="hidden" id="edit-menu-item-icon-color-<?php echo $item_id; ?>" class="edit-menu-item-icon-color iconize-input-color" name="menu-item-icon-color[<?php echo $item_id; ?>]" value="<?php echo $icon_color; ?>">
				<input type="hidden" id="edit-menu-item-icon-size-<?php echo $item_id; ?>" class="edit-menu-item-icon-size iconize-input-size" name="menu-item-icon-size[<?php echo $item_id; ?>]" value="<?php echo $icon_size; ?>">
				<input type="hidden" id="edit-menu-item-icon-align-<?php echo $item_id; ?>" class="edit-menu-item-icon-align iconize-input-align" name="menu-item-icon-align[<?php echo $item_id; ?>]" value="<?php echo $icon_align; ?>">
				<input type="hidden" id="edit-menu-item-icon-custom-classes-<?php echo $item_id; ?>" class="edit-menu-item-icon-color iconize-input-custom-classes" name="menu-item-icon-custom-classes[<?php echo $item_id; ?>]" value="<?php echo $icon_custom_classes; ?>">
			</span>
		</p>
		<p class="field-menu-item-icon-position description">
			<label for="edit-menu-item-icon-position-<?php echo $item_id; ?>">
				<input type="checkbox" id="edit-menu-item-icon-position-<?php echo $item_id; ?>" value="after" name="menu-item-icon-position[<?php echo $item_id; ?>]"<?php checked( $item->icon_position, 'after' ); ?> />
				<?php _e( 'Insert icon after menu item title', $this->plugin_slug ); ?>
			</label>
		</p>
		
	<?php
	}
	
	/**
	 * Save menu item icon option.
	 *
	 * @since 1.0.0
	 *
	 * @param string $menu_id
	 * @param string $menu_item_db_id
	 * @param array  $args
	 */
	public function iconize_update_nav_menu_item( $menu_id, $menu_item_db_id, $args ) {
		
		$args['menu-item-icon-name']           = isset( $_POST['menu-item-icon-name'][ $menu_item_db_id ] ) ? $_POST['menu-item-icon-name'][ $menu_item_db_id ] : '';
		$args['menu-item-icon-set']            = isset( $_POST['menu-item-icon-set'][ $menu_item_db_id ] ) ? $_POST['menu-item-icon-set'][ $menu_item_db_id ] : '';
		$args['menu-item-icon-transform']      = isset( $_POST['menu-item-icon-transform'][ $menu_item_db_id ] ) ? $_POST['menu-item-icon-transform'][ $menu_item_db_id ] : '';
		$args['menu-item-icon-color']          = isset( $_POST['menu-item-icon-color'][ $menu_item_db_id ] ) ? $_POST['menu-item-icon-color'][ $menu_item_db_id ] : '';
		$args['menu-item-icon-size']           = isset( $_POST['menu-item-icon-size'][ $menu_item_db_id ] ) ? $_POST['menu-item-icon-size'][ $menu_item_db_id ] : '';
		$args['menu-item-icon-align']          = isset( $_POST['menu-item-icon-align'][ $menu_item_db_id ] ) ? $_POST['menu-item-icon-align'][ $menu_item_db_id ] : '';
		$args['menu-item-icon-custom-classes'] = isset( $_POST['menu-item-icon-custom-classes'][ $menu_item_db_id ] ) ? $_POST['menu-item-icon-custom-classes'][ $menu_item_db_id ] : '';
		$args['menu-item-icon-position']       = isset( $_POST['menu-item-icon-position'][ $menu_item_db_id ] ) ? $_POST['menu-item-icon-position'][ $menu_item_db_id ] : '';

		update_post_meta( $menu_item_db_id, '_menu_item_icon_name', $args['menu-item-icon-name'] );
		update_post_meta( $menu_item_db_id, '_menu_item_icon_set', $args['menu-item-icon-set'] );
		update_post_meta( $menu_item_db_id, '_menu_item_icon_transform', $args['menu-item-icon-transform'] );
		update_post_meta( $menu_item_db_id, '_menu_item_icon_color', $args['menu-item-icon-color'] );
		update_post_meta( $menu_item_db_id, '_menu_item_icon_size', $args['menu-item-icon-size'] );
		update_post_meta( $menu_item_db_id, '_menu_item_icon_align', $args['menu-item-icon-align'] );
		update_post_meta( $menu_item_db_id, '_menu_item_icon_custom_classes', $args['menu-item-icon-custom-classes'] );
		update_post_meta( $menu_item_db_id, '_menu_item_icon_position', sanitize_key($args['menu-item-icon-position']) );
	}
	
	/**
	 * Setup the nav menu object to have the additionnal properties.
	 *
	 * @since 1.0.0
	 *
	 * @param object  $menu_item
	 * @return object $menu_item
	 */
	public function iconize_setup_nav_menu_item( $menu_item ) {
		
		$menu_item->icon_name           = empty( $menu_item->icon_name ) ? get_post_meta( $menu_item->ID, '_menu_item_icon_name', true ) : $menu_item->icon_name;
		$menu_item->icon_set            = empty( $menu_item->icon_set ) ? get_post_meta( $menu_item->ID, '_menu_item_icon_set', true ) : $menu_item->icon_set;
		$menu_item->icon_transform      = empty( $menu_item->icon_transform ) ? get_post_meta( $menu_item->ID, '_menu_item_icon_transform', true ) : $menu_item->icon_transform;
		$menu_item->icon_color          = empty( $menu_item->icon_color ) ? get_post_meta( $menu_item->ID, '_menu_item_icon_color', true ) : $menu_item->icon_color;
		$menu_item->icon_size           = empty( $menu_item->icon_size ) ? get_post_meta( $menu_item->ID, '_menu_item_icon_size', true ) : $menu_item->icon_size;
		$menu_item->icon_align          = empty( $menu_item->icon_align ) ? get_post_meta( $menu_item->ID, '_menu_item_icon_align', true ) : $menu_item->icon_align;
		$menu_item->icon_custom_classes = empty( $menu_item->icon_custom_classes ) ? get_post_meta( $menu_item->ID, '_menu_item_icon_custom_classes', true ) : $menu_item->icon_custom_classes;
		$menu_item->icon_position       = empty( $menu_item->icon_position ) ? get_post_meta( $menu_item->ID, '_menu_item_icon_position', true ) : $menu_item->icon_position;
		
		return $menu_item;
	}

	/**
	 * Custom Walker for menu edit.
	 *
	 * WordPress does not provide any hook to modify the result of menu edit screen.
	 * This function calls our custom edit walker.
	 *
	 * @since 1.0.0
	 *
	 * @return string custom walker
	 */
	public function iconize_edit_nav_menu_walker( $a ) {
		
		return 'Iconize_Walker_Nav_Menu_Edit';
	}

	/**
	 * Add icon before menu item title ( if function attached to "iconize_menu_items_with" filter is returning "title_link" string ).
	 *
	 * @since 1.1.2
	 *
	 * @param string  $title
	 * @param string  $id
	 * @return string $title
	 */
	public function iconize_menu_item_title( $title, $id ) {

		if ( is_nav_menu_item( $id ) ) {

			$icon_args['icon_name']           = get_post_meta( $id, '_menu_item_icon_name', true );
			$icon_args['icon_set']            = get_post_meta( $id, '_menu_item_icon_set', true );
			$icon_args['icon_transform']      = get_post_meta( $id, '_menu_item_icon_transform', true );
			$icon_args['icon_color']          = get_post_meta( $id, '_menu_item_icon_color', true );
			$icon_args['icon_size']           = get_post_meta( $id, '_menu_item_icon_size', true );
			$icon_args['icon_align']          = get_post_meta( $id, '_menu_item_icon_align', true );
			$icon_args['icon_custom_classes'] = get_post_meta( $id, '_menu_item_icon_custom_classes', true );
			$icon_args['icon_position']       = get_post_meta( $id, '_menu_item_icon_position', true );

			$icon = iconize_get_icon( $icon_args , 'menu_item' );

			if ( 'after' === $icon_args['icon_position'] ) {

				$title = $title . $icon;

			} else {

				$title = $icon . $title;
			}
		}

		return $title;
	}

	/**
	 * Add iconized-hover-trigger CSS class to menu item link classes if needed ( if function attached to "iconize_menu_items_with" filter is returning "title_link" string ).
	 *
	 * @since 1.1.2
	 *
	 * @param array  $atts
	 * @param object  $item
	 * @param array  $args
	 * @return array $atts
	 */
	public function iconize_nav_menu_link_attributes( $atts, $item, $args ) {

		$hovers = $this->get_iconize_dialog_dropdown_options_for( 'hover' );
		$hovers = array_keys( $hovers );

		if ( ! empty( $item->icon_transform ) && in_array( $item->icon_transform, $hovers ) ) {

			if ( isset( $atts['class'] ) ) {

				$atts['class'] .= ' iconized-hover-trigger';

			} else {

				$atts['class'] = 'iconized-hover-trigger';
			}
		}

		return $atts;
	}

	/**
	 * Add icon before menu item title and wrap them with <span class="iconized-hover-trigger"> tag if needed ( if function attached to "iconize_menu_items_with" filter is returning "title" string ).
	 *
	 * @since 1.1.2
	 *
	 * @param string  $title
	 * @param string  $id
	 * @return string $title
	 */
	public function iconize_menu_item_title_all( $title, $id ) {

		if( is_nav_menu_item( $id ) ) {

			$icon_args['icon_name']           = get_post_meta( $id, '_menu_item_icon_name', true );
			$icon_args['icon_set']            = get_post_meta( $id, '_menu_item_icon_set', true );
			$icon_args['icon_transform']      = get_post_meta( $id, '_menu_item_icon_transform', true );
			$icon_args['icon_color']          = get_post_meta( $id, '_menu_item_icon_color', true );
			$icon_args['icon_size']           = get_post_meta( $id, '_menu_item_icon_size', true );
			$icon_args['icon_align']          = get_post_meta( $id, '_menu_item_icon_align', true );
			$icon_args['icon_custom_classes'] = get_post_meta( $id, '_menu_item_icon_custom_classes', true );
			$icon_args['icon_position']       = get_post_meta( $id, '_menu_item_icon_position', true );

			$icon = iconize_get_icon( $icon_args , 'menu_item' );

			$hovers = $this->get_iconize_dialog_dropdown_options_for( 'hover' );
			$hovers = array_keys( $hovers );

			if ( ! empty( $icon_args['icon_transform'] ) && in_array( $icon_args['icon_transform'], $hovers ) ) {

				$title = '<span class="iconized-hover-trigger">' . $icon . $title . '</span>';

			} else {

				if ( 'after' === $icon_args['icon_position'] ) {

				$title = $title . $icon;

				} else {

					$title = $icon . $title;
				}
			}
		}

		return $title;
	}
	
	/**
	 * Filter wp_nav_menu_args to display icons on all menus.
	 *
	 * We will call our walker class only if there is configured menu, because of the known bug where
	 * custom nav menu walkers and wp_nav_menu's 'fallback_cb' argument ( wp_page_menu by default ) are not compatible.
	 * - http://core.trac.wordpress.org/ticket/18232
	 * - http://core.trac.wordpress.org/ticket/24587
	 * 
	 * @since 1.0.0
	 *
	 * @param array  $args
	 * @return array $args
	 */
	public function iconize_nav_menu_args( $args = array() ) {
		
		// We will use the same logic found in wp_nav_menu() function.
		
		// Get the nav menu based on the requested menu.
		$menu = wp_get_nav_menu_object( $args['menu'] );
	
		// Get the nav menu based on the theme_location.
		if ( ! $menu && $args['theme_location'] && ( $locations = get_nav_menu_locations() ) && isset( $locations[ $args['theme_location'] ] ) ) {
			
			$menu = wp_get_nav_menu_object( $locations[ $args['theme_location'] ] );
		}
	
		// Get the first menu that has items if we still can't find a menu.
		if ( ! $menu && ! $args['theme_location'] ) {
			
			$menus = wp_get_nav_menus();
			
			foreach ( $menus as $menu_maybe ) {
				
				if ( $menu_items = wp_get_nav_menu_items( $menu_maybe->term_id, array( 'update_post_term_cache' => false ) ) ) {
					
					$menu = $menu_maybe;
					
					break;
				}
			}
		}
		
		if ( $menu && empty( $args['walker'] ) ) {
			
			$args['walker'] = new Iconize_Walker_Nav_Menu;
		}
		
		return $args;
	}

	//////////////////////////////////////////
	////// Taxonomy system integration ///////
	//////////////////////////////////////////

	/**
	 * Add field to "add taxonomy term" form
	 *
	 * @since    1.1.0
	 */
	public function iconize_taxonomy_add_form_fields() {
		?>
		<div class="form-field">
			<label class="preview-icon-label">
				<?php _e( 'Icon: ', $this->plugin_slug ); ?><br /><button type="button" class="preview-icon button iconized-hover-trigger"><span class="iconized"></span></button>
			</label>
			<span>
				<input type="hidden" id="icon_name" name="icon_name" class="iconize-input-name" value="">
				<input type="hidden" id="icon_set" name="icon_set" class="iconize-input-set" value="">
				<input type="hidden" id="icon_transform" name="icon_transform" class="iconize-input-transform" value="">
				<input type="hidden" id="icon_color" name="icon_color" class="iconize-input-color" value="">
				<input type="hidden" id="icon_size" name="icon_size" class="iconize-input-size" value="">
				<input type="hidden" id="icon_align" name="icon_align" class="iconize-input-align" value="">
				<input type="hidden" id="icon_custom_classes" name="icon_custom_classes" class="iconize-input-custom-classes" value="">
			</span>
		</div>

		<?php
	}
	
	/**
	 * Add field to "edit taxonomy term" form
	 *
	 * @since    1.1.0
	 *
	 * @param object   $tag
	 * @param string   $taxonomy
	 */
	public function iconize_taxonomy_edit_form_fields( $tag, $taxonomy ) {

		// clear values.
		$name = $set = $transform = $color = $size = $align = $custom = '';

		// tag id
		$id = $tag->term_id;

		$opt_array = get_option('iconize_taxonomy_icons');
		
		if ( $opt_array && array_key_exists( $taxonomy, $opt_array ) ) {

			if ( array_key_exists( $id, $opt_array[ $taxonomy ] ) ) {

				$name 			= $opt_array[ $taxonomy ][ $id ]['icon_name'];
				$set			= $opt_array[ $taxonomy ][ $id ]['icon_set'];
				$transform 		= $opt_array[ $taxonomy ][ $id ]['icon_transform'];
				$color			= $opt_array[ $taxonomy ][ $id ]['icon_color'];
				$size			= $opt_array[ $taxonomy ][ $id ]['icon_size'];
				$align 			= $opt_array[ $taxonomy ][ $id ]['icon_align'];
				$custom			= $opt_array[ $taxonomy ][ $id ]['icon_custom_classes'];
			}
		}
		?>

		<tr class="form-field">
			<th scope="row" valign="top"><label for="taxonomy-icon-button"><?php _e( 'Icon: ', $this->plugin_slug ); ?></label></th>
			<td>
				<label class="preview-icon-label">
					<button type="button" id="taxonomy-icon-button" name="taxonomy-icon-button" class="preview-icon button iconized-hover-trigger"><span class="iconized <?php echo $name; ?> <?php echo $set; ?> <?php echo $transform; ?>"></span></button>
				</label>
				<span>
					<input type="hidden" id="icon_name" name="icon_name" class="iconize-input-name" value="<?php echo $name; ?>">
					<input type="hidden" id="icon_set" name="icon_set" class="iconize-input-set" value="<?php echo $set; ?>">
					<input type="hidden" id="icon_transform" name="icon_transform" class="iconize-input-transform" value="<?php echo $transform; ?>">
					<input type="hidden" id="icon_color" name="icon_color" class="iconize-input-color" value="<?php echo $color; ?>">
					<input type="hidden" id="icon_size" name="icon_size" class="iconize-input-size" value="<?php echo $size; ?>">
					<input type="hidden" id="icon_align" name="icon_align" class="iconize-input-align" value="<?php echo $align; ?>">
					<input type="hidden" id="icon_custom_classes" name="icon_custom_classes" class="iconize-input-custom-classes" value="<?php echo $custom; ?>">
				<span>
			</td>
		</tr>

		<?php
	}

	/**
	 * Insert or update taxonomy term
	 *
	 * @since    1.1.0
	 *
	 * @param string   $term_id
	 * @param string   $tt_id
	 * @param string   $taxonomy
	 */
	public function iconize_create_update_taxonomy_icon( $term_id, $tt_id, $taxonomy ) {

		$opt_array = get_option('iconize_taxonomy_icons');

		if ( isset( $_POST['icon_name'] ) ) {

			$opt_array[ $taxonomy ][ $term_id ]['icon_name'] = $_POST['icon_name'];
		}

		if ( isset( $_POST['icon_set'] ) ) {

			$opt_array[ $taxonomy ][ $term_id ]['icon_set'] = $_POST['icon_set'];
		}

		if ( isset( $_POST['icon_transform'] ) ) {

			$opt_array[ $taxonomy ][ $term_id ]['icon_transform'] = $_POST['icon_transform'];
		}

		if ( isset( $_POST['icon_color'] ) ) {

			$opt_array[ $taxonomy ][ $term_id ]['icon_color'] = $_POST['icon_color'];
		}

		if ( isset( $_POST['icon_size'] ) ) {

			$opt_array[ $taxonomy ][ $term_id ]['icon_size'] = $_POST['icon_size'];
		}

		if ( isset( $_POST['icon_align'] ) ) {

			$opt_array[ $taxonomy ][ $term_id ]['icon_align'] = $_POST['icon_align'];
		}

		if ( isset( $_POST['icon_custom_classes'] ) ) {

			$opt_array[ $taxonomy ][ $term_id ]['icon_custom_classes'] = $_POST['icon_custom_classes'];
		}

		if ( isset( $opt_array ) ) {

			update_option( 'iconize_taxonomy_icons' , $opt_array );
		}
	}
	 
	/**
	 * Delete taxonomy term
	 *
	 * @since    1.1.0
	 *
	 * @param string   $term_id
	 * @param string   $tt_id
	 * @param string   $taxonomy
	 */
	public function iconize_delete_taxonomy_icon( $term_id, $tt_id, $taxonomy ) {
		
		$opt_array = get_option('iconize_taxonomy_icons');
		if ( $opt_array && isset( $opt_array[ $taxonomy ][ $term_id ] ) ) {

			unset( $opt_array[ $taxonomy ][ $term_id ] );
			update_option('iconize_taxonomy_icons', $opt_array);
		}
	}

	/**
	 * Add "Icon" column to term table
	 *
	 * @since    1.1.1
	 *
	 * @param array   $columns
	 * @return array   $columns
	 */
	public function iconize_term_columns_head( $columns ) {

		$columns['term_icon'] = 'Icon';

 		return $columns;
	}

	/**
	 * Add term icon to our column content
	 *
	 * @since    1.1.1
	 *
	 * @param string   $deprecated
	 * @param string   $column_name
	 * @param string   $term_id
	 * @return string   $icon
	 */
	public function iconize_term_column_content( $deprecated, $column_name, $term_id ) {

		if ( $column_name == 'term_icon') {

			if ( isset( $_POST['icon_name'] ) ) {

				$icon_args['icon_name']           = $_POST['icon_name'];
				$icon_args['icon_set']            = $_POST['icon_set'];
				$icon_args['icon_transform']      = $_POST['icon_transform'];
				$icon_args['icon_color']          = $_POST['icon_color'];
				$icon_args['icon_size']           = $_POST['icon_size'];
				$icon_args['icon_align']          = $_POST['icon_align'];
				$icon_args['icon_custom_classes'] = $_POST['icon_custom_classes'];

				$icon = iconize_get_icon( $icon_args, 'term_column_icon', '' );

			} else {

				$screen = get_current_screen();
				$taxonomy = $screen->taxonomy;

				$icon = iconize_get_term_icon_by( 'id', $term_id, $taxonomy, 'html', '' );
			}

			return $icon;
		}
	}

	/**
	 * List categories/taxonomy terms with icons
	 *
	 * Attached to "wp_list_categories" filter, extends default wp_list_categories() function.
	 *
	 * @since    1.1.0
	 *
	 * @uses Iconize_WP::walk_iconize_category_tree()
	 * @uses Iconize_WP::get_iconize_support_for()
	 *
	 * @param array   $output
	 * @param array   $args
	 * @return array  $output
	 */
	public function iconize_list_taxonomies( $output, $args ) {
		
		$defaults = array(
			'show_option_all' => '', 'show_option_none' => __('No categories'),
			'orderby' => 'name', 'order' => 'ASC',
			'style' => 'list',
			'show_count' => 0, 'hide_empty' => 1,
			'use_desc_for_title' => 1, 'child_of' => 0,
			'feed' => '', 'feed_type' => '',
			'feed_image' => '', 'exclude' => '',
			'exclude_tree' => '', 'current_category' => 0,
			'hierarchical' => true, 'title_li' => __( 'Categories' ),
			'echo' => 1, 'depth' => 0,
			'taxonomy' => 'category'
		);

		// Insert "iconized" arg to defaults
		if ( ! isset( $defaults['iconized'] ) ) {

			/**
			 * Let users decide wheather to display iconized cat list or default one on each wp_list_categories() usage.
			 * Iconized cat list is disabled by default.
			 */
			$iconized_defaults = array();

			/**
			 * Apply "iconize_tag_cloud_defaults" filter to allow users to change default value of "iconized" parameter.
			 */
			$defaults['iconized'] = apply_filters( 'iconized_list_categories_defaults', $iconized_defaults , $args );
		}

		$r = wp_parse_args( $args, $defaults );

		// Check if iconize is enabled on this taxonomy
		$tax_support = $this->get_iconize_support_for( 'taxonomy_'.$r['taxonomy'] );
		$tax_icons_enabled  = $tax_support['enabled'];

		// Return output if no iconized arg or iconize is disabled
		if ( false === (bool) $r['iconized'] || ! $tax_icons_enabled ) {

			return $output;
		}

		if ( ! isset( $r['pad_counts'] ) && $r['show_count'] && $r['hierarchical'] ) {

			$r['pad_counts'] = true;
		}

		if ( true == $r['hierarchical'] ) {

			$r['exclude_tree'] = $r['exclude'];
			$r['exclude'] = '';
		}

		if ( ! isset( $r['class'] ) ) {

			$r['class'] = ( 'category' == $r['taxonomy'] ) ? 'categories' : $r['taxonomy'];
		}

		extract( $r );

		if ( ! taxonomy_exists( $taxonomy ) ) {

			return false;
		}

		$categories = get_categories( $r );

		$output = '';

		if ( $title_li && 'list' == $style ) {

			$output = '<li class="' . esc_attr( $class ) . '">' . $title_li . '<ul>';
		}

		if ( empty( $categories ) ) {

			if ( ! empty( $show_option_none ) ) {

				if ( 'list' == $style ) {

					$output .= '<li>' . $show_option_none . '</li>';

				} else {

					$output .= $show_option_none;
				}
			}

		} else {

			if ( ! empty( $show_option_all ) ) {

				$posts_page = ( 'page' == get_option( 'show_on_front' ) && get_option( 'page_for_posts' ) ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' );
				$posts_page = esc_url( $posts_page );

				if ( 'list' == $style ) {

					$output .= "<li><a href='$posts_page'>$show_option_all</a></li>";

				} else {

					$output .= "<a href='$posts_page'>$show_option_all</a>";
				}
			}

			if ( empty( $r['current_category'] ) && ( is_category() || is_tax() || is_tag() ) ) {

				$current_term_object = get_queried_object();

				if ( $current_term_object && $r['taxonomy'] === $current_term_object->taxonomy ) {

					$r['current_category'] = get_queried_object_id();
				}
			}

			if ( $hierarchical ) {

				$depth = $r['depth'];

			} else {

				$depth = -1; // Flat.
			}

			// Call our helper function instead of "walk_category_tree"
			$output .= $this->walk_iconize_category_tree( $categories, $depth, $r );
		}

		if ( $title_li && 'list' == $style ) {

			$output .= '</ul></li>';
		}

		// Apply "iconize_list_categories" filter
		$output = apply_filters( 'iconize_list_categories', $output, $args );

		if ( $echo ) {

			echo $output;

		} else {

			return $output;
		}
	}

	/**
	 * Helper function to call our custom "Iconize_Walker_Category" walker class
	 *
	 * Modified default "walk_category_tree" function...
	 *
	 * @since    1.1.0
	 */
	public function walk_iconize_category_tree() {

		$args = func_get_args();

		// the user's options are the third parameter
		if ( empty( $args[2]['walker'] ) || ! is_a( $args[2]['walker'], 'Walker' ) ) {

			$walker = new Iconize_Walker_Category;

		} else {

			$walker = $args[2]['walker'];
		}

		return call_user_func_array( array( &$walker, 'walk' ), $args );
	}

	/**
	 * Generate iconized tag cloud
	 *
	 * Attached to "wp_generate_tag_cloud" filter, extends default wp_generate_tag_cloud() function.
	 *
	 * @since    1.1.0
	 *
	 * @uses Iconize_WP::get_iconize_support_for()
	 * @uses Iconize_WP::iconize_get_term_icon_by()
	 * @uses Iconize_WP::iconize_get_icon()
	 */
	public function iconize_wp_generate_tag_cloud( $return, $tags, $args ) {

		// Modify default functionality
		$defaults = array(
			'smallest' => 8, 'largest' => 22, 'unit' => 'pt', 'number' => 0,
			'format' => 'flat', 'separator' => "\n", 'orderby' => 'name', 'order' => 'ASC',
			'topic_count_text' => null, 'topic_count_text_callback' => null,
			'topic_count_scale_callback' => 'default_topic_count_scale', 'filter' => 1,
		);

		// Insert "iconized" arg to defaults
		if ( ! isset( $defaults['iconized'] ) ) {

			/**
			 * Let users decide wheather to display iconized tag cloud or default one on each wp_tag_cloud() usage.
			 * Iconized tag cloud disabled by default
			 */
			$iconized_defaults = array();

			// If in admin area, display icons - better for end user
			if ( is_admin() ) {

				$iconized_defaults = array(
					'hover_effect'         => 'default',
					'color'                => 'default',
					'hover_effect_trigger' => 'link',
					'hover_color_change'   => false,
					'fallback_icon'        => array(),
					'override_icons'       => false,
					'style'                => 'default',
					'after_icon'           => '&nbsp;',
				);
			}

			/**
			 * Apply "iconize_tag_cloud_defaults" filter to allow users to change default value of "iconized" parameter.
			 */
			$defaults['iconized'] = apply_filters( 'iconized_tag_cloud_defaults', $iconized_defaults , $args );
		}

		$args = wp_parse_args( $args, $defaults );

		// Check if iconize is enabled on this taxonomy
		if ( isset( $args['taxonomy'] ) ) {

			$tax_support = $this->get_iconize_support_for( 'taxonomy_'.$args['taxonomy'] );
			$tax_icons_enabled  = $tax_support['enabled'];

		} else {

			$tax_icons_enabled  = false;
		}
		

		// Return output if no iconized arg or iconize is disabled
		if ( false === (bool) $args['iconized'] || ! $tax_icons_enabled ) {

			return $return;
		}

		// Continue with default logic
		extract( $args, EXTR_SKIP );

		$return = ( 'array' === $format ) ? array() : '';

		if ( empty( $tags ) ) {
			return $return;
		}

		// Juggle topic count tooltips:
		if ( isset( $args['topic_count_text'] ) ) {
			// First look for nooped plural support via topic_count_text.
			$translate_nooped_plural = $args['topic_count_text'];
		} elseif ( ! empty( $args['topic_count_text_callback'] ) ) {
			// Look for the alternative callback style. Ignore the previous default.
			if ( $args['topic_count_text_callback'] === 'default_topic_count_text' ) {
				$translate_nooped_plural = _n_noop( '%s topic', '%s topics' );
			} else {
				$translate_nooped_plural = false;
			}
		} elseif ( isset( $args['single_text'] ) && isset( $args['multiple_text'] ) ) {
			// If no callback exists, look for the old-style single_text and multiple_text arguments.
			$translate_nooped_plural = _n_noop( $args['single_text'], $args['multiple_text'] );
		} else {
			// This is the default for when no callback, plural, or argument is passed in.
			$translate_nooped_plural = _n_noop( '%s topic', '%s topics' );
		}

		$tags_sorted = apply_filters( 'tag_cloud_sort', $tags, $args );

		if ( empty( $tags_sorted ) ) {
			return $return;
		}

		if ( $tags_sorted !== $tags ) {
			$tags = $tags_sorted;
			unset( $tags_sorted );
		} else {
			if ( 'RAND' === $order ) {
				shuffle( $tags );
			} else {
				// SQL cannot save you; this is a second (potentially different) sort on a subset of data.
				if ( 'name' === $orderby ) {
					uasort( $tags, '_wp_object_name_sort_cb' );
				} else {
					uasort( $tags, '_wp_object_count_sort_cb' );
				}

				if ( 'DESC' === $order ) {
					$tags = array_reverse( $tags, true );
				}
			}
		}

		if ( $number > 0 )
			$tags = array_slice($tags, 0, $number);

		$counts = array();
		$real_counts = array(); // For the alt tag
		foreach ( (array) $tags as $key => $tag ) {
			$real_counts[ $key ] = $tag->count;
			$counts[ $key ] = $topic_count_scale_callback($tag->count);
		}

		$min_count = min( $counts );
		$spread = max( $counts ) - $min_count;
		if ( $spread <= 0 )
			$spread = 1;
		$font_spread = $largest - $smallest;
		if ( $font_spread < 0 )
			$font_spread = 1;
		$font_step = $font_spread / $spread;

		// Validate custom settings passed with 'iconize' arg to wp_tag_cloud().
		$hover_effect         = ( isset( $iconized['hover_effect'] ) ) ? (string) $iconized['hover_effect'] : 'default';
		$color                = ( isset( $iconized['color'] ) ) ? (string) $iconized['color'] : 'default';
		$hover_effect_trigger = ( isset( $iconized['hover_effect_trigger'] ) ) ? (string) $iconized['hover_effect_trigger'] : 'link';
		$hover_color_change   = ( isset( $iconized['hover_color_change'] ) ) ? (bool) $iconized['hover_color_change'] : false;
		$fallback_icon_args   = ( isset( $iconized['fallback_icon'] ) ) ? (array) $iconized['fallback_icon'] : array();
		$override_icons       = ( isset( $iconized['override_icons'] ) ) ? (bool) $iconized['override_icons'] : false;
		$style                = ( isset( $iconized['style'] ) ) ? (string) $iconized['style'] : 'default';
		$after_icon           = ( isset( $iconized['after_icon'] ) ) ? (string) $iconized['after_icon'] : '&nbsp;';

		$a = array();

		foreach ( $tags as $key => $tag ) {

			$count = $counts[ $key ];
			$real_count = $real_counts[ $key ];
			$tag_link = '#' != $tag->link ? esc_url( $tag->link ) : '#';
			$tag_id = isset($tags[ $key ]->id) ? $tags[ $key ]->id : $key;
			$tag_name = $tags[ $key ]->name;

			if ( $translate_nooped_plural ) {
				$title_attribute = sprintf( translate_nooped_plural( $translate_nooped_plural, $real_count ), number_format_i18n( $real_count ) );
			} else {
				$title_attribute = call_user_func( $topic_count_text_callback, $real_count, $tag, $args );
			}

			// Retrive an array of settings for term icon configured in term edit screen if there is an icon.
			$icon = iconize_get_term_icon_by( 'name', $tag_name, $taxonomy );

			$term_icon_args = array();
			if ( ! empty( $icon ) ) {

				$term_icon_args = iconize_get_term_icon_by( 'name', $tag_name, $taxonomy, 'array' );
			}

			// Determine which icon to display.
			if ( true === $override_icons ) {

				$icon_args = $fallback_icon_args;

			} else {

				$icon_args = $term_icon_args;

				if ( empty( $icon_args ) && ! empty( $fallback_icon_args ) ) {

					$icon_args = $fallback_icon_args;
				}
			}

			// Modify icon args if needed.
			if ( ! empty( $icon_args ) ) {

				if ( true === $hover_color_change && false === strpos( $icon_args['icon_custom_classes'], 'hover-color-change' ) ) {
				
					$icon_args['icon_custom_classes'] .= ( ! empty( $icon_args['icon_custom_classes'] ) ) ? ',hover-color-change' : 'hover-color-change';
				}

				// Override effect and color if needed
				if ( 'default' !== $hover_effect ) {

					$icon_args['icon_transform'] = $hover_effect;
				}

				if ( 'default' !== $color ) {

					$icon_args['icon_color'] = $color;
				}
			}

			// Generate icon html.
			$icon_html = iconize_get_icon( $icon_args, $taxonomy, $after_icon );

			// Add hover effect class to link if needed.
			$het_link = '';

			if ( 'link' === $hover_effect_trigger && ! empty( $icon_html ) && ! empty( $icon_args['icon_transform'] ) && ! empty( $hover_effect ) ) {

				$het_link = ' iconized-hover-trigger';
			}

			// Generate link.
			$a[] = "<a href='$tag_link' class='$style-style iconized-tag-link$het_link tag-link-$tag_id' title='" . esc_attr( $title_attribute ) . "' style='font-size: " .
				str_replace( ',', '.', ( $smallest + ( ( $count - $min_count ) * $font_step ) ) )
				. "$unit;'>$icon_html$tag_name</a>";
		}

		switch ( $format ) :
		case 'array' :
			$return =& $a;
			break;
		case 'list' :
			$return = "<ul class='wp-tag-cloud'>\n\t<li>";
			$return .= join( "</li>\n\t<li>", $a );
			$return .= "</li>\n</ul>\n";
			break;
		default :
			$return = join( $separator, $a );
			break;
		endswitch;

		return $return;
		
	}


	//////////////////////////////
	////// Helper functions //////
	//////////////////////////////

	/**
	 * Function to check if options page is enabled.
	 *
	 * @since 1.0.0
	 *
	 * @return boolean $show_options_screen
	 */
	public function show_iconize_options() {

		/**
		 * Filter to enable/disable options screen.
		 * Function attached to the 'show_iconize_options_screen' filter must return boolean value true/false.
		 */
		return  (bool) apply_filters( 'show_iconize_options_screen', true );
	}

	/**
	 * Function to check if iconize plugin is enabled on specific WP system and whether to show settings for that sistem on plugins options page or not.
	 *
	 * @since 1.0.0
	 *
	 * @uses Iconize_WP::show_iconize_options()
	 *
	 * @param string $system - widgets, nav_menus, editor, taxonomy_(taxonomy name)
	 * @return array $support
	 */
	public function get_iconize_support_for( $system ) {

		$allowed_values = array( 'widgets', 'nav_menus', 'editor' );

		$args = array(
			'public'   => true,
			'show_ui' => true
		);
		$output = 'names'; // or objects
		$operator = 'and'; // 'and' or 'or'
		$taxonomies = get_taxonomies( $args, $output, $operator ); 
		if ( $taxonomies ) {

			foreach ( $taxonomies  as $taxonomy ) {

				$allowed_values[] = 'taxonomy_'.$taxonomy;
			}
		}
		
		if ( empty( $system ) || ! is_string( $system ) || ! in_array( $system, $allowed_values ) ) {

			return;
		}

		$options_enabled = $this->show_iconize_options();
		
		$default_array = array( 'enabled' => true, 'show_in_options' => true );

		/**
		 * Filter to enable/disable iconize support for widgets system/nav menus system/visual editor
		 * and to show/hide options for widgets system/nav menus system/visual editor on settings screen.
		 * 
		 * Function attached to the 'iconize_widgets'/'iconize_nav_menus'/'iconize_editor' filter must return an array in format:
		 *	array(
		 *		'enabled' => true/false,
		 *		'show_in_options' => true/false
		 *	)
		 */
		$iconize_system = apply_filters( "iconize_{$system}", $default_array );

		$enabled_for_system = ( is_array( $iconize_system ) && isset( $iconize_system['enabled'] ) && is_bool( $iconize_system['enabled'] ) ) ? $iconize_system['enabled'] : $default_array['enabled'];
		$show_system_options = ( is_array( $iconize_system ) && isset( $iconize_system['show_in_options'] ) && is_bool( $iconize_system['show_in_options'] ) ) ? $iconize_system['show_in_options'] : $default_array['show_in_options'];
		
		$support['enabled'] = ( $options_enabled && $show_system_options ) ? get_option( 'icons_to_'. $system, $enabled_for_system ) : $enabled_for_system;
		$support['show_in_options'] = $show_system_options;

		return $support;
	}


	/**
	 * Function to retrive an array of additional ids of screens where iconize dialog is enabled.
	 *
	 * @since 1.0.0
	 *
	 * @return array $extra_screen_ids, empty array by default
	 */
	public function get_extra_iconize_dialog_support() {

		/**
		 * Since iconize dialog is added only on widgets and nav-menus admin screens ( if enabled ),
		 * 'add_iconize_dialog_to_screens' filter allows users to call the dialog on other admin pages if they need to.
		 *
		 * Note that the dialog is useless if you don't have the preview button and inputs to store settings on this pages.
		 * @see Iconize_WP::iconize_in_widget_form()
		 * @see Iconize_WP::iconize_nav_menu_item_custom_fields()
		 *
		 * Function attached to this filter must return an array of screen ids.
		 */
		$screen_ids = apply_filters( 'add_iconize_dialog_to_screens', array() );
		$extra_screen_ids = is_array( $screen_ids ) ? $screen_ids : array();

		return $extra_screen_ids;
	}

	/**
	 * Function to get stylesheet file/s with icons defined.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_iconize_fonts_styles() {

		global $wp_version;

		// Use the .min suffix if SCRIPT_DEBUG is turned off.
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		$styles = array(
			'default' => array(
				'path' => plugin_dir_path( __FILE__ ) . "css/iconize-fonts$suffix.css",
				'url'  => plugins_url( "css/iconize-fonts$suffix.css", __FILE__ ),
				)
		);

		// Include dashicons if WP 3.8
		if ( $wp_version >= 3.8 ) {

			$styles['dashicons'] = array(
				'path' => plugin_dir_path( __FILE__ ) . "css/dashicons$suffix.css",
				'url'  => plugins_url( "css/dashicons$suffix.css", __FILE__ ),
			);
		}

		/**
		 * Filter for adding custom icons stylesheets, overriding default, etc.
		 * Note: Path and url to css file MUST be provided.
		 * Example array returned:
		 *	array(
		 *		'default' => array ( 'path'=> 'path to file', 'url' => 'url of file'),
		 *		'custom' => array ( 'path'=> 'path to file', 'url' => 'url of file'),
		 *	)
		 */
		return apply_filters( 'iconize_fonts_styles', $styles );
	}

	/**
	 * Function to read stylesheet file/s and return an array of icon sets.
	 *
	 * @since 1.0.0
	 *
	 * @uses Iconize_WP::get_iconize_fonts_styles()
	 *
	 * @return array $icons_array
	 */
	public function get_icons_array() {

		// Get stylesheet file/s.
		$styles_array = $this->get_iconize_fonts_styles();

		// Regex pattern ( see iconize.css ).
		$pattern = '/\.(.+)\.glyph-((?:\w+(?:-)?)+):+before\s*{\s*content:\s*.+;\s*}/';

		$icons_array = array();

		foreach ( $styles_array as $key => $value ) {
			
			$subject = ( is_array( $value ) && array_key_exists( 'path', $value ) && ! empty( $value['path'] ) ) ? file_get_contents( $value['path'] ) : false;

			if ( false !== $subject ) {

				// Find matches.
				preg_match_all( $pattern, $subject, $matches, PREG_SET_ORDER );

				/**
				 * Generated array will be in format:
				 * array(
				 *	'font-1' => array( 'name-1', 'name-2', 'name-3',..., 'name-n' ),
				 *	'font-2' => array( 'name-1', 'name-2', 'name-3',..., 'name-n' ),
				 *	...
				 *	'font-n' => array( 'name-1', 'name-2', 'name-3',..., 'name-n' )
				 * )
				 */
				if ( $matches ) {

					foreach( $matches as $match ) {

						$icons_array[ $match[1] ][] = $match[2];
					}
				}
			}
		}
		
		return $icons_array;
	}

	/**
	 * Generate inline styles for iconize dialog to style it based on selected admin color scheme.
	 *
	 * @since 1.0.0
	 *
	 * @return string $inline_styles
	 */
	public function get_iconize_dialog_inline_styles() {

		if ( ! is_admin() ) {

			return '';
		}

		global $wp_version, $_wp_admin_css_colors;
		
		$user_admin_color = get_user_option( 'admin_color' );

		if ( empty( $user_admin_color ) ||  ! isset( $_wp_admin_css_colors[ $user_admin_color ] ) || empty( $_wp_admin_css_colors[ $user_admin_color ] ) ) {

			$user_admin_color = 'fresh';
		}

		/**
		 * No need for inline styles if admin colors are set to defaults since default dialog colors are the same.
		 * If WordPress version is lesser than 3.8, also use default dialog colors.
		 */
		if ( 'fresh' === $user_admin_color || $wp_version < 3.8 ) {

			return '';
		}

		$inline_styles = $header_background = $icon_select_border = $header_color = '';

		// Take colors for dialog.
		if ( ! empty( $_wp_admin_css_colors[ $user_admin_color ]->colors ) ) {

			$colors = $_wp_admin_css_colors[ $user_admin_color ]->colors;

			$header_background  = isset( $colors[0] ) ? $colors[0] : '';
			$icon_select_border = isset( $colors[2] ) ? $colors[2] : '';
		}

		if ( ! empty( $_wp_admin_css_colors[ $user_admin_color ]->icon_colors ) ) {

			$icon_colors = $_wp_admin_css_colors[ $user_admin_color ]->icon_colors;

			$header_color = isset( $icon_colors['base'] ) ? $icon_colors['base'] : '';
		}
		
		// Generate styles for dialog.
		if ( ! empty( $header_color ) ) {

			$inline_styles .= '
					.iconize-modal .wpbs-modal-header,
					.iconize-modal .wpbs-modal-close,
					.iconize-modal .wpbs-modal-close:hover,
					.iconize-modal .wpbs-modal-close:focus {
						color: ' . $header_color . ';
					}';
		}

		if ( ! empty( $header_background ) ) {

			$inline_styles .= '
					.iconize-modal .wpbs-modal-header {
						background: ' . $header_background . ';
					}';
		}

		if ( ! empty( $icon_select_border ) ) {

			$inline_styles .= '
					.iconize-modal .icons-list-icon.selected-icon {
						border-color: ' . $icon_select_border . ';
					}';
		}
		
		return $inline_styles;
	}

	/**
	 * Return array of strings for the dialog input labels, button texts, notifications, etc.
	 * Used for dialog rendering and for javascript localization.
	 *
	 * @since 1.0.0
	 *
	 * @return array $strings
	 */
	public function get_iconize_dialog_strings() {

		$strings = array();

		// Buttons
		$strings['add']                       = __( 'Add icon', $this->plugin_slug );
		$strings['insert']                    = __( 'Insert icon', $this->plugin_slug );
		$strings['edit']                      = __( 'Edit icon', $this->plugin_slug );
		$strings['update']                    = __( 'Update icon', $this->plugin_slug );
		$strings['remove']                    = __( 'Remove icon', $this->plugin_slug );
		$strings['cancel']                    = __( 'Cancel', $this->plugin_slug );
		$strings['stack']                     = __( 'Create icon stack with selected and existing icons', $this->plugin_slug );

		// Labels
		$strings['icon_set_label']            = __( 'Change set:', $this->plugin_slug );
		$strings['icon_name_label']           = __( 'Search by name:', $this->plugin_slug );
		$strings['icon_effect_label']         = __( 'Icon effect:', $this->plugin_slug );
		$strings['icon_color_label']          = __( 'Icon color:', $this->plugin_slug );
		$strings['icon_size_label']           = __( 'Icon size:', $this->plugin_slug );
		$strings['icon_align_label']          = __( 'Icon align:', $this->plugin_slug );
		$strings['icon_custom_classes_label'] = __( 'Icon custom classes ( type CSS class names without dots, separate them by hitting enter/space/comma key ):', $this->plugin_slug );
		$strings['stack_size_label']          = __( 'Stack size:', $this->plugin_slug );
		$strings['stack_align_label']         = __( 'Stack align:', $this->plugin_slug );

		// Effect Options
		$strings['option_transform_label']    = __( 'Transformation', $this->plugin_slug );
		$strings['option_animate_label']      = __( 'Animation', $this->plugin_slug );
		$strings['option_hover_label']        = __( 'Hover Effect', $this->plugin_slug );

		// Notifications
		$strings['no_icons_defined']          = __( "No icons defined.\n\nIf you are trying to define your own icons, you're doing it wrong and you should read the documentation for Iconize plugin.\n\nIf that's not the case you should contact the author.", $this->plugin_slug );
		$strings['no_icon_selected']          = __( "No icon selected.\n\nTo select icon simply click on one from the list or search for it by name using field on upper right corner of the dialog.", $this->plugin_slug );
		$strings['no_icon_found']             = __( "Something is wrong.\n\nIcon is missing font or name CSS class ( or both ). If you want to edit this icon, replace it with another one or add missing classes manually using HTML view.", $this->plugin_slug );
		$strings['no_icon_found_admin']       = __( "The icon font and/or icon name found here is no longer available.\n\nYou can insert new icon here, remove icon, or revert changes you have made to Iconize plugin.", $this->plugin_slug );
		$strings['reserved_class']            = __( "Reserved CSS class name.\n\nYou cannot use this class as custom, please type another class name.", $this->plugin_slug );

		return $strings;
	}

	/**
	 * Function to return an array of options for specified select dropdown available in dialog.
	 *
	 * @since 1.0.0
	 *
	 * @param string $dropdown -  effets/transform/hover/size/align
	 * @return array $options_array
	 */
	public function get_iconize_dialog_dropdown_options_for( $dropdown = '' ) {

		$dropdowns = array( 'transform', 'animate', 'hover', 'size', 'align' );

		if ( empty( $dropdown ) || ! in_array( $dropdown, $dropdowns ) ) {

			return array();
		}

		/**
		 * Default options per dropdown
		 */

		$default_transform_options = array(
			'grow'                                  => __( 'Grow', $this->plugin_slug ),
			'shrink'                                => __( 'Shrink', $this->plugin_slug ),
			'rotate'                                => __( 'Rotate', $this->plugin_slug ),
			'rotate-90'                             => __( 'Rotate 90 deg', $this->plugin_slug ),
			'rotate-180'                            => __( 'Rotate 180 deg', $this->plugin_slug ),
			'rotate-270'                            => __( 'Rotate 270 deg', $this->plugin_slug ),
			'flip-horizontal'                       => __( 'Flip Horizontal', $this->plugin_slug ),
			'flip-vertical'                         => __( 'Flip Vertical', $this->plugin_slug ),
			'grow-rotate'                           => __( 'Grow Rotate', $this->plugin_slug ),
			'grow-rotate-90'                        => __( 'Grow Rotate 90 deg', $this->plugin_slug ),
			'grow-rotate-180'                       => __( 'Grow Rotate 180 deg', $this->plugin_slug ),
			'grow-rotate-270'                       => __( 'Grow Rotate 270 deg', $this->plugin_slug ),
			'grow-flip-horizontal'                  => __( 'Grow Flip Horizontal', $this->plugin_slug ),
			'grow-flip-vertical'                    => __( 'Grow Flip Hertical', $this->plugin_slug ),
			'shrink-rotate'                         => __( 'Shrink Rotate', $this->plugin_slug ),
			'shrink-rotate-90'                      => __( 'Shrink Rotate 90 deg', $this->plugin_slug ),
			'shrink-rotate-180'                     => __( 'Shrink Rotate 180 deg', $this->plugin_slug ),
			'shrink-rotate-270'                     => __( 'Shrink Rotate 270 deg', $this->plugin_slug ),
			'shrink-flip-horizontal'                => __( 'Shrink Flip Horizontal', $this->plugin_slug ),
			'shrink-flip-vertical'                  => __( 'Shrink Flip Hertical', $this->plugin_slug ),
			'skew'                                  => __( 'Skew', $this->plugin_slug ),
			'skew-forward'                          => __( 'Skew Forward', $this->plugin_slug ),
			'skew-backward'                         => __( 'Skew Backward', $this->plugin_slug ),
			'float'                                 => __( 'Float', $this->plugin_slug ),
			'sink'                                  => __( 'Sink', $this->plugin_slug ),
			'float-shadow'                          => __( 'Float Shadow', $this->plugin_slug )
		);

		$default_animate_options = array(
			'animate-pulse'                         => __( 'Pulse', $this->plugin_slug ),
			'animate-pulse-grow'                    => __( 'Pulse Grow', $this->plugin_slug ),
			'animate-pulse-shrink'                  => __( 'Pulse Shrink', $this->plugin_slug ),
			'animate-spin'                          => __( 'Spin', $this->plugin_slug ),
			'animate-spin-slow'                     => __( 'Spin Slower', $this->plugin_slug ),
			'animate-spin-fast'                     => __( 'Spin Faster', $this->plugin_slug ),
			'animate-spin-ccw'                      => __( 'Spin CCW', $this->plugin_slug ),
			'animate-spin-slow-ccw'                 => __( 'Spin Slower CCW', $this->plugin_slug ),
			'animate-spin-fast-ccw'                 => __( 'Spin Faster CCW', $this->plugin_slug ),
			'animate-buzz'                          => __( 'Buzz', $this->plugin_slug ),
			'animate-hover'                         => __( 'Hover', $this->plugin_slug ),
			'animate-hang'                          => __( 'Hang', $this->plugin_slug ),
			'animate-hover-shadow'                  => __( 'Hover Shadow', $this->plugin_slug )
		);

		$default_hover_options = array(
			'hover-animate-fade-in'                 => __( 'Fade In', $this->plugin_slug ),
			'hover-animate-fade-out'                => __( 'Fade Out', $this->plugin_slug ),
			'hover-animate-grow'                    => __( 'Grow', $this->plugin_slug ),
			'hover-animate-shrink'                  => __( 'Shrink', $this->plugin_slug ),
			'hover-animate-pop'                     => __( 'Pop', $this->plugin_slug ),
			'hover-animate-push'                    => __( 'Push', $this->plugin_slug ),
			'hover-animate-pulse'                   => __( 'Pulse', $this->plugin_slug ),
			'hover-animate-pulse-grow'              => __( 'Pulse Grow', $this->plugin_slug ),
			'hover-animate-pulse-shrink'            => __( 'Pulse Shrink', $this->plugin_slug ),
			'hover-animate-rotate'                  => __( 'Rotate', $this->plugin_slug ),
			'hover-animate-rotate-90'               => __( 'Rotate 90', $this->plugin_slug ),
			'hover-animate-rotate-180'              => __( 'Rotate 180', $this->plugin_slug ),
			'hover-animate-rotate-270'              => __( 'Rotate 270', $this->plugin_slug ),
			'hover-animate-rotate-360'              => __( 'Rotate 360', $this->plugin_slug ),
			'hover-animate-flip-horizontal'         => __( 'Flip Horizontally', $this->plugin_slug ),
			'hover-animate-flip-vertical'           => __( 'Flip Vertically', $this->plugin_slug ),
			'hover-animate-grow-rotate'             => __( 'Grow Rotate', $this->plugin_slug ),
			'hover-animate-grow-rotate-90'          => __( 'Grow Rotate 90', $this->plugin_slug ),
			'hover-animate-grow-rotate-180'         => __( 'Grow Rotate 180', $this->plugin_slug ),
			'hover-animate-grow-rotate-270'         => __( 'Grow Rotate 270', $this->plugin_slug ),
			'hover-animate-grow-rotate-360'         => __( 'Grow Rotate 360', $this->plugin_slug ),
			'hover-animate-grow-flip-horizontal'    => __( 'Grow Flip Horizontally', $this->plugin_slug ),
			'hover-animate-grow-flip-vertical'      => __( 'Grow Flip Vertically', $this->plugin_slug ),
			'hover-animate-shrink-rotate'           => __( 'Shrink Rotate', $this->plugin_slug ),
			'hover-animate-shrink-rotate-90'        => __( 'Shrink Rotate 90', $this->plugin_slug ),
			'hover-animate-shrink-rotate-180'       => __( 'Shrink Rotate 180', $this->plugin_slug ),
			'hover-animate-shrink-rotate-270'       => __( 'Shrink Rotate 270', $this->plugin_slug ),
			'hover-animate-shrink-rotate-360'       => __( 'Shrink Rotate 360', $this->plugin_slug ),
			'hover-animate-shrink-flip-horizontal'  => __( 'Shrink Flip Horizontally', $this->plugin_slug ),
			'hover-animate-shrink-flip-vertical'    => __( 'Shrink Flip Vertically', $this->plugin_slug ),
			'hover-animate-spin'                    => __( 'Spin', $this->plugin_slug ),
			'hover-animate-spin-slow'               => __( 'Spin Slower', $this->plugin_slug ),
			'hover-animate-spin-fast'               => __( 'Spin Faster', $this->plugin_slug ),
			'hover-animate-spin-ccw'                => __( 'Spin CCW', $this->plugin_slug ),
			'hover-animate-spin-slow-ccw'           => __( 'Spin Slower CCW', $this->plugin_slug ),
			'hover-animate-spin-fast-ccw'           => __( 'Spin Faster CCW', $this->plugin_slug ),
			'hover-animate-buzz'                    => __( 'Buzz', $this->plugin_slug ),
			'hover-animate-buzz-out'                => __( 'Buzz Out', $this->plugin_slug ),
			'hover-animate-wobble-vertical'         => __( 'Wobble Vertical', $this->plugin_slug ),
			'hover-animate-wobble-horizontal'       => __( 'Wobble Horizontal', $this->plugin_slug ),
			'hover-animate-wobble-to-top-right'     => __( 'Wobble To Top Right', $this->plugin_slug ),
			'hover-animate-wobble-to-bottom-right'  => __( 'Wobble To Bottom Right', $this->plugin_slug ),
			'hover-animate-wobble-to-bottom-left'   => __( 'Wobble To Bottom Left', $this->plugin_slug ),
			'hover-animate-wobble-to-top-left'      => __( 'Wobble To Top Left', $this->plugin_slug ),
			'hover-animate-wobble-top'              => __( 'Wobble Top', $this->plugin_slug ),
			'hover-animate-wobble-bottom'           => __( 'Wobble Bottom', $this->plugin_slug ),
			'hover-animate-wobble-skew'             => __( 'Wobble Skew', $this->plugin_slug ),
			'hover-animate-skew'                    => __( 'Skew', $this->plugin_slug ),
			'hover-animate-skew-forward'            => __( 'Skew Forward', $this->plugin_slug ),
			'hover-animate-skew-backward'           => __( 'Skew Backward', $this->plugin_slug ),
			'hover-animate-float'                   => __( 'Float', $this->plugin_slug ),
			'hover-animate-sink'                    => __( 'Sink', $this->plugin_slug ),
			'hover-animate-hover'                   => __( 'Hover', $this->plugin_slug ),
			'hover-animate-hang'                    => __( 'Hang', $this->plugin_slug ),
			'hover-animate-float-shadow'            => __( 'Float Shadow', $this->plugin_slug ),
			'hover-animate-hover-shadow'            => __( 'Hover Shadow', $this->plugin_slug )
		);

		$default_size_options = array(
			'size-2x'                               => __( '2x Larger', $this->plugin_slug ),
			'size-3x'                               => __( '3x Larger', $this->plugin_slug ),
			'size-4x'                               => __( '4x Larger', $this->plugin_slug ),
			'size-5x'                               => __( '5x Larger', $this->plugin_slug ),
			'size-6x'                               => __( '6x Larger', $this->plugin_slug ),
			'size-7x'                               => __( '7x Larger', $this->plugin_slug ),
			'size-8x'                               => __( '8x Larger', $this->plugin_slug ),
			'size-9x'                               => __( '9x Larger', $this->plugin_slug ),
			'size-10x'                              => __( '10x Larger', $this->plugin_slug ),
			'size-sharp'                            => __( 'Sharp', $this->plugin_slug ),
			'size-sharp-2x'                         => __( 'Sharp 2x Larger', $this->plugin_slug ),
			'size-sharp-3x'                         => __( 'Sharp 3x Larger', $this->plugin_slug ),
			'size-sharp-4x'                         => __( 'Sharp 4x Larger', $this->plugin_slug ),
			'size-sharp-5x'                         => __( 'Sharp 5x Larger', $this->plugin_slug ),
			'size-sharp-6x'                         => __( 'Sharp 6x Larger', $this->plugin_slug ),
			'size-sharp-7x'                         => __( 'Sharp 7x Larger', $this->plugin_slug ),
			'size-sharp-8x'                         => __( 'Sharp 8x Larger', $this->plugin_slug ),
			'size-sharp-9x'                         => __( 'Sharp 9x Larger', $this->plugin_slug ),
			'size-sharp-10x'                        => __( 'Sharp 10x Larger', $this->plugin_slug )
		);

		$default_align_options = array(
			'align-left'                            => __( 'Left', $this->plugin_slug ),
			'align-center'                          => __( 'Center', $this->plugin_slug ),
			'align-right'                           => __( 'Right', $this->plugin_slug )
		);

		/**
		 * Allow users to customize dialog dropdown options.
		 *
		 * Functions attached to one of the filters below must return an array in format:
		 * 	array(
		 *		'custom-css-class-1' => 'Custom CSS Class 1 Label',
		 *		'custom-css-class-2' => 'Custom CSS Class 2 Label',
		 *		...
		 *		'custom-css-class-n' => 'Custom CSS Class n Label'
		 * 	)
		 */

		$transform_options = apply_filters( 'iconize_dialog_transform_options', $default_transform_options );

		$animate_options   = apply_filters( 'iconize_dialog_animate_options', $default_animate_options );

		$hover_options     = apply_filters( 'iconize_dialog_hover_options', $default_hover_options );

		$size_options      = apply_filters( 'iconize_dialog_size_options', $default_size_options );

		$align_options     = apply_filters( 'iconize_dialog_align_options', $default_align_options );

		$options_array = array();

		switch ( $dropdown ) {

			case 'transform':
				
				$options_array = ( is_array( $transform_options ) && ! empty( $transform_options ) ) ? $transform_options : $default_transform_options;

				break;

			case 'animate':
				
				$options_array = ( is_array( $animate_options ) && ! empty( $animate_options ) ) ? $animate_options : $default_animate_options;

				break;

			case 'hover':
				
				$options_array = ( is_array( $hover_options ) && ! empty( $hover_options ) ) ? $hover_options : $default_hover_options;

				break;

			case 'size':
				
				$options_array = ( is_array( $size_options ) && ! empty( $size_options ) ) ? $size_options : $default_size_options;

				break;

			case 'align':
				
				$options_array = ( is_array( $align_options ) && ! empty( $align_options ) ) ? $align_options : $default_align_options;

				break;
		}

		return $options_array;
	}

	/**
	 * Function to generate HTML for modal dialog.
	 *
	 * @since 1.0.0
	 *
	 * @uses Iconize_WP::get_icons_array()
	 * @uses Iconize_WP::get_iconize_dialog_strings()
	 * @uses Iconize_WP::get_iconize_dialog_dropdown_options_for()
	 * 
	 * @param string  $prefix - prefix for several dialog CSS ids
	 * @param array   $options - array of options to include
	 * @param array   $extra_buttons - array of action buttons to include
	 *
	 */
	public function iconize_dialog( $prefix = '', $options = '', $extra_buttons = '' ) {

		$default_options = array(
			'transform',
			'animate',
			'hover',
			'color',
			'size',
			'align',
			'custom_classes'
		);

		$default_extra_buttons = array(
			'stack'
		);

		$pref = empty( $prefix ) ? 'mce' : $prefix;
		$opts = ( '' === $options ) ? $default_options : $options;
		$btns = empty( $extra_buttons ) ? $default_extra_buttons : $extra_buttons;

		$include_opts          = ( false !== $opts ) ? $opts : array();
		$include_transform_opt = ( ! empty( $include_opts ) && in_array( 'transform', $include_opts ) ) ? true : false;
		$include_animate_opt   = ( ! empty( $include_opts ) && in_array( 'animate', $include_opts ) ) ? true : false;
		$include_hover_opt     = ( ! empty( $include_opts ) && in_array( 'hover', $include_opts ) ) ? true : false;
		$include_color_opt     = ( ! empty( $include_opts ) && in_array( 'color', $include_opts ) ) ? true : false;
		$include_size_opt      = ( ! empty( $include_opts ) && in_array( 'size', $include_opts ) ) ? true : false;
		$include_align_opt     = ( ! empty( $include_opts ) && in_array( 'align', $include_opts ) ) ? true : false;
		$include_custom_opt    = ( ! empty( $include_opts ) && in_array( 'custom_classes', $include_opts ) ) ? true : false;

		$include_btns       = ( false !== $btns ) ? $btns : array();
		$include_stack_btn  = ( ! empty( $include_btns ) && in_array( 'stack', $include_btns ) ) ? true : false;
		$include_remove_btn = ( ! empty( $include_btns ) && in_array( 'remove', $include_btns ) ) ? true : false;

		$icons_arr = $this->get_icons_array();
		$icon_sets = array_keys( $icons_arr );

		$dialog_strings = $this->get_iconize_dialog_strings();

		$effect_type_options = array();
		$effect_type_options['transform'] = ( true === $include_transform_opt ) ? $dialog_strings['option_transform_label'] : '';
		$effect_type_options['animate']   = ( true === $include_animate_opt ) ? $dialog_strings['option_animate_label'] : '';
		$effect_type_options['hover']     = ( true === $include_hover_opt ) ? $dialog_strings['option_hover_label'] : '';

		?>

		<form style="display: none;" id="iconize-<?php echo $pref; ?>-modal" class="iconize-modal wpbs-modal fade" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="wpbs-modal-dialog">
				<div class="wpbs-modal-content">
					<div class="wpbs-modal-header">
						<button type="button" class="wpbs-modal-close" data-dismiss="wpbsmodal" aria-hidden="true">&times;</button>
						<h4 id="iconize-<?php echo $pref; ?>-title" class="wpbs-modal-title"><?php echo $dialog_strings['insert']; ?></h4>
					</div><!-- /.wpbs-modal-header -->
					<div class="wpbs-modal-body">
						<div class="icons-list-controls">
							<label for="<?php echo $pref; ?>-icon-set" class="howto"><?php echo $dialog_strings['icon_set_label']; ?></label>
							<select name="<?php echo $pref; ?>-icon-set" id="<?php echo $pref; ?>-icon-set" size="1">
							<?php
							foreach ( $icon_sets as $key => $set ) {

								$selected = ( 0 == $key ) ? ' selected="selected"' : '';
							?>
								<option value="<?php echo $set; ?>"<?php echo $selected; ?>><?php echo $set; ?></option>
							<?php
							}
							?>
							</select>
							<label class="name-label">
								<span class="howto"><?php echo $dialog_strings['icon_name_label']; ?></span>
								<input type="text" id="<?php echo $pref; ?>-icon-name" name="<?php echo $pref; ?>-icon-name" value=''>
							</label>
						</div><!-- /.icons-list-controls -->
						<div class="clear"></div>
						<div id="iconize-<?php echo $pref; ?>-icons" class="icons-list-wrapper loading-overlay"></div><!-- /.icons-list-wrapper -->
						<div class="clear"></div>
						<?php
						// Check if there is any option enabled.
						if ( ! empty( $include_opts ) ) {

							// Check if any effect option is enabled.
							if ( true === $include_transform_opt || true === $include_animate_opt || true === $include_hover_opt ) {
		
								$transform_arr = ( true === $include_transform_opt ) ? $this->get_iconize_dialog_dropdown_options_for('transform') : array();
								$animate_arr   = ( true === $include_animate_opt ) ? $this->get_iconize_dialog_dropdown_options_for('animate') : array();
								$hover_arr     = ( true === $include_hover_opt ) ? $this->get_iconize_dialog_dropdown_options_for('hover') : array();

								?>
								<div class="iconize-modal-option">
									<p class="howto"><?php echo $dialog_strings['icon_effect_label']; ?></p>
									<select name="<?php echo $pref; ?>-icon-effect" id="<?php echo $pref; ?>-icon-effect" class="iconize-mother-select" size="1" >
									<?php
									$count = 0;
									foreach ( $effect_type_options as $class => $label ) {
										if ( ! empty( $label ) ) {
										$selected = ( 0 == $count ) ? ' selected="selected"' : '';
									?>
										<option value="<?php echo $class; ?>"<?php echo $selected; ?>><?php echo $label; ?></option>
									<?php
										$count++;
										}
									} // end foreach
									?>
									</select>
									<?php

									if ( ! empty( $transform_arr ) ) {
									?>

									<select name="<?php echo $pref; ?>-icon-transform" id="<?php echo $pref; ?>-icon-transform" class="mother-opt-<?php echo $pref; ?>-icon-effect mother-val-transform" size="1" >
										<option value="" selected="selected"><?php _e( 'None', $this->plugin_slug ); ?></option>
									<?php
									foreach ( $transform_arr as $class => $label ) {
									?>
										<option value="<?php echo $class; ?>"><?php echo $label; ?></option>
									<?php
									} // end foreach
									?>
									</select>
									<?php
									} // end if

									if ( ! empty( $animate_arr ) ) {
									?>
									<select name="<?php echo $pref; ?>-icon-animate" id="<?php echo $pref; ?>-icon-animate" class="mother-opt-<?php echo $pref; ?>-icon-effect mother-val-animate" size="1" >
										<option value="" selected="selected"><?php _e( 'None', $this->plugin_slug ); ?></option>
									<?php
									foreach ( $animate_arr as $class => $label ) {
									?>
										<option value="<?php echo $class; ?>"><?php echo $label; ?></option>
									<?php
									} // end foreach
									?>
									</select>
									<?php
									} // end if

									if ( ! empty( $hover_arr ) ) {
									?>
									<select name="<?php echo $pref; ?>-icon-hover" id="<?php echo $pref; ?>-icon-hover" class="mother-opt-<?php echo $pref; ?>-icon-effect mother-val-hover" size="1" >
										<option value="" selected="selected"><?php _e( 'None', $this->plugin_slug ); ?></option>
									<?php
									foreach ( $hover_arr as $class => $label ) {
									?>
										<option value="<?php echo $class; ?>"<?php echo $selected; ?>><?php echo $label; ?></option>
									<?php
									} // end foreach
									?>
									</select>
									<?php
									} // end if
									?>
								</div>
								<?php
							} // end effect options

							// Check if color option is enabled.
							if ( true === $include_color_opt ) {
							?>
								<div class="iconize-modal-option">
									<p class="howto"><?php echo $dialog_strings['icon_color_label']; ?><span id="<?php echo $pref; ?>-color-hover-checkbox" class="color-hover-checkbox hidden"><input type="checkbox" id="<?php echo $pref; ?>-icon-color-hover" name="<?php echo $pref; ?>-icon-color-hover" /><label for="<?php echo $pref; ?>-icon-color-hover"><?php _e('Change color to parent color on hover', $this->plugin_slug); ?></label></span></p>
									<input type="text" value="" name="<?php echo $pref; ?>-icon-color" id="<?php echo $pref; ?>-icon-color" />
								</div>
								<div class="clear"></div>
							<?php
							} // end $include_color_opt check

							// Check if size option is enabled.
							if ( true === $include_size_opt ) {

								// Get options for size dropdown.
								$size_arr = $this->get_iconize_dialog_dropdown_options_for('size');

								if ( ! empty( $size_arr ) ) {
							?>
								<div class="iconize-modal-option">
									<p id="<?php echo $pref; ?>-icon-size-howto" class="howto"><?php echo $dialog_strings['icon_size_label']; ?> </p>
									<select name="<?php echo $pref; ?>-icon-size" id="<?php echo $pref; ?>-icon-size" <?php if ( 'mce' === $pref ) :?>class="iconize-mother-select"<?php endif ?> size="1">
										<option value="" selected="selected"><?php _e( 'Inherit', $this->plugin_slug ); ?></option>
									<?php
									foreach ( $size_arr as $class => $label ) {
									?>
										<option value="<?php echo $class; ?>"><?php echo $label; ?></option>
									<?php
									} // end foreach
									?>
										<?php if ( 'mce' === $pref ) :?><option value="custom-size"><?php _e('Custom', $this->plugin_slug ) ?></option><?php endif; ?>
									</select>
									<?php if ( 'mce' === $pref ) :?><input type="text" id="<?php echo $pref; ?>-icon-custom-size" name="<?php echo $pref; ?>-icon-custom-size" value='' class="icon-custom-size mother-opt-<?php echo $pref; ?>-icon-size mother-val-custom-size"></option><?php endif; ?>
								</div>
							<?php
								} // end if
							} // end $include_size_opt check

							// Check if align option is enabled.
							if ( true === $include_align_opt ) {

								// Get options for align dropdown.
								$align_arr = $this->get_iconize_dialog_dropdown_options_for('align');

								if ( ! empty( $align_arr ) ) {
							?>
								<div class="iconize-modal-option">
									<p id="<?php echo $pref; ?>-icon-align-howto" class="howto"><?php echo $dialog_strings['icon_align_label']; ?></p>
									<select name="<?php echo $pref; ?>-icon-align" id="<?php echo $pref; ?>-icon-align" size="1" >
										<option value="" selected="selected"><?php _e( 'None', $this->plugin_slug ); ?></option>
									<?php
									foreach ( $align_arr as $class => $label ) {
									?>
										<option value="<?php echo $class; ?>"><?php echo $label; ?></option>
									<?php
									} // end foreach
									?>
									</select>
								</div>
							<?php
								}
							} // end $include_align_opt check

							// Check if custom classes option is enabled.
							if ( true === $include_custom_opt ) {
							?>
								<div class="iconize-modal-option full-width">
									<p class="howto"><?php echo $dialog_strings['icon_custom_classes_label']; ?></p>
									<input type="text" id="<?php echo $pref; ?>-icon-custom-classes" name="<?php echo $pref; ?>-icon-custom-classes" value=''>
								</div>
							<?php
							} // $include_custom_opt check
							?>
							<div class="clear"></div>
					<?php
						} // $include_opts check
					?>
					</div><!-- /.wpbs-modal-body -->
					<div class="wpbs-modal-footer">
						<button type="button" id="iconize-<?php echo $pref; ?>-cancel" class="iconize-cancel button button-large left" data-dismiss="wpbsmodal" aria-hidden="true"><?php echo $dialog_strings['cancel']; ?></button>
						<button type="button" id="iconize-<?php echo $pref; ?>-update" class="iconize-update button button-large button-primary right"><?php echo $dialog_strings['insert']; ?></button>
						<?php
						// Check if stack button is enabled.
						if ( true === $include_stack_btn ) {
						?>
						<button type="button" id="iconize-<?php echo $pref; ?>-stack" class="iconize-stack button button-large right"><?php echo $dialog_strings['stack']; ?></button>
						<?php
						}
						// Check if remove button is enabled.
						if ( true === $include_remove_btn ) {
						?>
						<button type="button" id="iconize-<?php echo $pref; ?>-remove" class="iconize-remove button button-large right"><?php echo $dialog_strings['remove']; ?></button>
						<?php
						}
						?>
					</div><!-- /.wpbs-modal-footer -->
				</div><!-- /.wpbs-modal-content -->
			</div><!-- /.wpbs-modal-dialog -->
		</form><!-- /.wpbs-modal -->
	<?php
	}

	/**
	 * Get an array of all supported taxonomies
	 *
	 * @since 1.1.0
	 *
	 * @return array $screen_ids
	 */
	public function iconize_get_supported_taxonomy_screens_ids() {

		$screen_ids = array();

		// Get all registered taxonomies with backend ui
		$args = array(
			'public'   => true,
			'show_ui' => true
		); 
		$output = 'names';
		$operator = 'and';

		$taxonomies = get_taxonomies( $args, $output, $operator );

		if ( $taxonomies ) {

			foreach ( $taxonomies  as $taxonomy ) {

				// Check for support
				$tax_support = $this->get_iconize_support_for( 'taxonomy_'.$taxonomy );
				$tax_icons_enabled  = $tax_support['enabled'];

				if ( $tax_icons_enabled ) {

					$screen_ids[] = 'edit-'.$taxonomy;
				}
			}
		}

		return $screen_ids;
	}

	/**
	 * Function to add "widgets" to array of screen ids.
	 * Used if widget support is disabled ( widget title icons ), but we need dialog for Iconize Taxonomies Widget.
	 *
	 * @since 1.1.0
	 * 
	 * @param array $array
	 * @return array $array
	 *
	 */
	public function return_widgets_screen( $array ) {

		$array[] = 'widgets';

		return $array;
	}
	
} // End class Iconize_WP