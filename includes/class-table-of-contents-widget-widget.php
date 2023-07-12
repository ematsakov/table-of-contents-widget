<?php

/**
 * EM Table of Contents Widget
 *
 * @link       https://matsakov.com
 * @since      1.0.0
 *
 * @package    Table_Of_Contents_Widget
 * @subpackage Table_Of_Contents_Widget/includes
 */

/**
 * EM Table of Contents Widget
 *
 * This class defines widget class
 *
 * @since      1.0.0
 * @package    Table_Of_Contents_Widget
 * @subpackage Table_Of_Contents_Widget/includes
 * @author     Evgeny Masakov <ematsakov@gmail.com>
 */
class Table_Of_Contents_Widget_Widget extends WP_Widget {

    /**
     * Default widget values.
     *
     * @var array
     */
    protected $defaults;

    /**
     * Constructor method.
     *
     * Set some global values and create widget.
     */
    public function __construct() {
        /**
         * Filter for default widget option values.
         *
         * @since 1.0.0
         *
         * @param array $defaults Default widget options.
         */
        $this->defaults = apply_filters(
            'table-of-contents-widget',
            array(
                'title' => __( 'Table Of Contents', 'table-of-contents-widget' ),
                'selector' => '.entry-content',
                'sticky' => true,
                'offset_top' => '0',
                'viewport_offset_top' => '0',
            )
        );

        parent::__construct(
            'table-of-contents-widget',
            __( 'Table Of Contents', 'table-of-contents-widget' )
        );
    }

    /**
     * Widget Form.
     *
     * Outputs the widget form that allows users to control the output of the widget.
     *
     * @param array $instance The widget settings.
     */
    public function form( $instance ) {
        /** Merge with defaults */
        $instance = wp_parse_args( (array) $instance, $this->defaults );
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'table-of-contents-widget' );
        $selector = ! empty( $instance['selector'] ) ? $instance['selector'] : '.entry-content';
        $sticky = ! empty( $instance['sticky'] ) ? '1' : '0';
        $offset_top = ! empty( $instance['offset_top'] ) ? $instance['offset_top'] : '0';
        $viewport_offset_top = ! empty( $instance['viewport_offset_top'] ) ? $instance['viewport_offset_top'] : '0';
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'table-of-contents-widget' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'selector' ) ); ?>"><?php echo esc_html__( 'Content Selector:', 'table-of-contents-widget' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'selector' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'selector' ) ); ?>" type="text" value="<?php echo esc_attr( $selector ); ?>">
            <small><?php echo esc_html__( 'CSS selector for <?php the_content(); ?> wrapper.', 'table-of-contents-widget' ); ?></small>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked( $sticky ); ?> id="<?php echo esc_attr( $this->get_field_id( 'sticky' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sticky' ) ); ?>">
            <label for="<?php echo esc_attr( $this->get_field_id( 'sticky' ) ); ?>"><?php echo esc_html__( 'Sticky', 'table-of-contents-widget' ); ?></label>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'offset_top' ) ); ?>"><?php echo esc_html__( 'Offset Top:', 'table-of-contents-widget' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'offset_top' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'offset_top' ) ); ?>" type="number" value="<?php echo esc_attr( $offset_top ); ?>">
            <small><?php echo esc_html__( 'Widget top offset if sticky.', 'table-of-contents-widget' ); ?></small>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'viewport_offset_top' ) ); ?>"><?php echo esc_html__( 'Viewport Offset Top:', 'table-of-contents-widget' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'viewport_offset_top' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'viewport_offset_top' ) ); ?>" type="number" value="<?php echo esc_attr( $viewport_offset_top ); ?>">
            <small><?php echo esc_html__( 'Viewport top offset if you have sticky header.', 'table-of-contents-widget' ); ?></small>
        </p>
        <?php
    }

    /**
     * Form validation and sanitization.
     *
     * Runs when you save the widget form. Allows you to validate or sanitize widget options before they are saved.
     *
     * @param array $new_instance The new settings.
     * @param array $old_instance The old settings.
     * @return array The settings to save.
     */

    public function update( $new_instance, $old_instance ) {
        $instance          = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['selector'] = ( ! empty( $new_instance['selector'] ) ) ? strip_tags( $new_instance['selector'] ) : '';
        $instance['sticky'] = ( ! empty( $new_instance['sticky'] ) ) ? '1' : '0';
        $instance['offset_top'] = ( ! empty( $new_instance['offset_top'] ) ) ? intval($new_instance['offset_top']) : '0';
        $instance['viewport_offset_top'] = ( ! empty( $new_instance['viewport_offset_top'] ) ) ? intval($new_instance['viewport_offset_top']) : '0';
        return $instance;
    }

    /**
     * Widget Output.
     *
     * Outputs the actual widget on the front-end based on the widget options the user selected.
     *
     * @param array $args The display args.
     * @param array $instance The instance settings.
     */

    public function widget( $args, $instance ) {
        /** Merge with defaults */
        $instance = wp_parse_args( (array) $instance, $this->defaults );

        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }
        echo '<div class="table-of-contents-widget-container" 
            data-selector="'.$instance['selector'].'" 
            data-sticky="'.$instance['sticky'].'" 
            data-offset_top="'.$instance['offset_top'].'" 
            data-viewport_offset_top="'.$instance['viewport_offset_top'].'"
            >';
        echo '</div>';
        echo $args['after_widget'];
    }
}
