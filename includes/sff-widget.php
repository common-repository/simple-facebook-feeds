<?php
/**
 * Widget Register
 *
 * Register a widget for plugin
 *
 * @since 1.0.1
 *
 * @param 'widgets_init' => Fires after all default WordPress widgets have been registered.
 * @param  'register_widget' => Registers a widget.
**/
add_action('widgets_init', 'sff_feeds_widget');
function sff_feeds_widget() {
    register_widget('SFF_Feeds');
}

/**
 * Widget Class
 *
 * Create a class for widget with name 'SFF_Feeds' and also extends the 'WP_Widget' class
 *
 * This class must be extended for each widget, and WP_Widget::widget() must be overriden.
 *
 * If adding widget options, WP_Widget::update() and WP_Widget::form() should also be overridden.
 *
 * @since 1.0.1
**/
class SFF_Feeds extends WP_Widget {

	/**
	 * Widget Class Construct
	 *
	 * Constructor for 'SFF_Feeds' class
	 *
	 * @param '$id_base' => (string) (Optional) Base ID for the widget, lowercase and unique. If left empty, a portion of the widget's class name will be used Has to be unique.
	 * @param '$name' => (string) (Optional) Name for the widget displayed on the configuration page.
	 * @param '$widget_options' => (array) (Optional) Widget options. See wp_register_sidebar_widget() for information on accepted arguments. Default value: array()
	 * @param '$control_options' => (array) (Optional) Widget control options. See wp_register_widget_control() for information on accepted arguments. Default value: array()
	 *
	 * @since 1.0.1
	**/
	function __construct() {
        parent::__construct(
            'sff_feeds', // Base ID
            __( 'Simple Facebook Widget', 'simple-facebook-feeds' ), // Name
            array( 'description' => __('Simple widget for facebook feeds', 'sff_feeds', 'simple-facebook-feeds'), 
                    'classname' => 'simple-facebook-feeds' ), // Args
            array( 'width' => 250, 'height' => 320, 'id_base' => 'sff_feeds' )
        );
    }

    /**
	 * Widget Area
	 * 
	 * Echoes the widget content.
	 * Sub-classes should over-ride this function to generate their widget code.
	 *
	 * @since 1.0.1
	 * 
	 * @param '$args' => (array) (Required) Display arguments including 'before_title', 'after_title', 'before_widget', and 'after_widget'.
	 * @param '$instance' => (array) (Required) The settings for the particular instance of the widget.
    */
    function widget($args, $widgetData) {
        extract($args);
      
        $sff_feeds_title = $widgetData['sff_feeds_title'];
        $sff_feeds_limit = $widgetData['sff_feeds_limit'];
     
        echo $before_widget;
?>
		<!-- favourites post -->
	    <div class="sff_feeds_widget">
	    	<h3><?php echo $sff_feeds_title ?></h3>
			<?php
				if(!empty($sff_feeds_limit)) {
					echo do_shortcode('[simple-facebook-feed limit=' . $sff_feeds_limit . ']');
				} else {
					echo do_shortcode('[simple-facebook-feed]');
				}
			?>
	   	</div>
	    <!-- /favourites post -->
<?php
    	echo $after_widget;
	}

	/**
	 * Widget Update
	 * 
	 * Updates a particular instance of a widget.
	 * This function should check that $new_instance is set correctly. The newly-calculated value of $instance should be returned. If false is returned, the instance won’t be saved/updated.
	 *
	 * @since 1.0.1
	 * 
	 * @param '$new_instance' => (array) (Required) New settings for this instance as input by the user via WP_Widget::form().
	 * @param '$old_instance' => (array) (Required) Old settings for this instance.
    */
    function update($new_widgetData, $old_widgetData) {
        $widgetData = $old_widgetData;

        //Strip tags from title and name to remove HTML
        $widgetData['sff_feeds_title'] = $new_widgetData['sff_feeds_title'];
        $widgetData['sff_feeds_limit'] = $new_widgetData['sff_feeds_limit'];

        return $widgetData;
    }

    /**
	 * Widget Form
	 * 
	 * Outputs the settings update form.
	 *
	 * @since 1.0.1
	 * 
	 * @param '$instance' => (array) (Required) Current settings.
    */
    function form($widgetData) {
        //Set up some default widget settings.
        $widgetData = wp_parse_args((array) $widgetData);
?>
        <p>
            <label for="<?php echo $this->get_field_id('sff_feeds_title'); ?>">Title</label>
			<input type="text" name="<?php echo $this->get_field_name('sff_feeds_title'); ?>" value="<?php echo $widgetData['sff_feeds_title']; ?>" style="width: 100%;" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('sff_feeds_limit'); ?>">Limit</label>
			<input type="text" name="<?php echo $this->get_field_name('sff_feeds_limit'); ?>" value="<?php echo $widgetData['sff_feeds_limit']; ?>" style="width: 100%;" />
        </p>
<?php
    }

}
