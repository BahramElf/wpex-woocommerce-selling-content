<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       wpex.ir
 * @since      1.0.0
 *
 * @package    Wpex_Woocommerce_Content_Selling
 * @subpackage Wpex_Woocommerce_Content_Selling/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Wpex_Woocommerce_Content_Selling
 * @subpackage Wpex_Woocommerce_Content_Selling/includes
 * @author     BahramElf <bhrm.ch@gmail.com>
 */
class Wpex_Woocommerce_Content_Selling_Loader {

	/**
	 * The array of actions registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $actions    The actions registered with WordPress to fire when the plugin loads.
	 */
	protected $actions;

	/**
	 * The array of filters registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $filters    The filters registered with WordPress to fire when the plugin loads.
	 */
	protected $filters;

	/**
	 * Initialize the collections used to maintain the actions and filters.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->actions = array();
		$this->filters = array();

	}

	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress action that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the action is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 */
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * A utility function that is used to register the actions and hooks into a single
	 * collection.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    array                $hooks            The collection of hooks that is being registered (that is, actions or filters).
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         The priority at which the function should be fired.
	 * @param    int                  $accepted_args    The number of arguments that should be passed to the $callback.
	 * @return   array                                  The collection of actions and filters registered with WordPress.
	 */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;

	}

	/**
	 * Register the filters and actions with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		
		if ( isset($_POST['login_location']) && !empty($_POST['login_location']) ){
			add_filter('login_redirect', 'my_login_redirect', 10, 3);
			function my_login_redirect() {
				$location = $_SERVER['HTTP_REFERER'];
				wp_safe_redirect($location);
				exit();
			}
		}
		
		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}
		
		function Wpex_Woocommerce_Content_Selling_Shortcode( $atts, $content = null ) {
			$current_user = wp_get_current_user();
			if ( ! is_user_logged_in() ){
				return '<div class="userNotBought userNotLogin">
					<a href="'.get_permalink( get_option('woocommerce_myaccount_page_id') ).'">در صورتی که محصول را قبلا خریداری کرده اید، از اینجا وارد حساب کاربری خود شوید.</a><br>
					'.do_shortcode('[woocommerce_my_account]').'
					<a href="'.$url.'"> برای خرید محصول اینجا کلیک کنید</a>
				</div>';
			}
			if( ! $atts[product_id] ){ return;}
			
			/*extract( shortcode_atts( array(
				'product_id' => '1',
				'class' => 'wpex-content',
			), $atts, 'wpex-content' ) );*/
			
			
			if ( wc_customer_bought_product( $current_user->user_email, $current_user->ID, $atts['product_id'] ) ){
				 return '<div class="'.$atts['class'].' userBought">' . do_shortcode($content) . '</div>';
			}else{
				$url = get_permalink( $atts['product_id'] );
				return '<div class="'.$atts['class'].' userNotBought"><a href="'.$url.'"> برای خرید محصول اینجا کلیک کنید</a></div>';
			}
		
		}
		
		add_shortcode( 'wpex-content', 'Wpex_Woocommerce_Content_Selling_Shortcode' );
	}

}
