<?php
if( !defined( 'WPINC' ) ){
    die;
}
/**
 * @Packge     : Interior Companion
 * @Version    : 1.0
 * @Author     : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */

 
 
/**************************************
*Creating About Widget
***************************************/
 
class interior_about_widget extends WP_Widget {


function __construct() {

parent::__construct(
// Base ID of your widget
'interior_about_widget', 


// Widget name will appear in UI
esc_html__( '[ Interior ] About Widget', 'interior-companion' ), 

// Widget description
array( 'description' => esc_html__( 'Add footer about content', 'interior-companion' ), ) 
);

}

// This is where the action happens
public function widget( $args, $instance ) {
	
$title 		= apply_filters( 'widget_title', $instance['title'] );
$image 		= apply_filters( 'widget_image', $instance['image'] );
$textarea 	= apply_filters( 'widget_textarea', $instance['textarea'] );

// before and after widget arguments are defined by themes
echo wp_kses_post( $args['before_widget'] );
if ( ! empty( $title ) )
echo wp_kses_post( $args['before_title'] . $title . $args['after_title'] );

    
?>
    <div class="single-footer-widget mb-100">
        <?php 
        // logo
        if( $image ){
        	echo '<a href="'.esc_url( site_url('/') ).'" class="mb-50 d-block">';
		    	echo interior_img_tag(
		    		array(
		    			'url' 	 => esc_url( $image ),
		    		)
		    	);
        	echo '</a>';
        }
        //
		if( $textarea ){
			echo '<p>'.wp_kses_post( $textarea).'</p>';
		}
        ?>
    </div>
<?php
echo wp_kses_post( $args['after_widget'] );
}
		
// Widget Backend 
public function form( $instance ) {
	
if ( isset( $instance[ 'title' ] ) ) {
	$title = $instance[ 'title' ];
}else {
	$title = esc_html__( 'About', 'interior-companion' );
}


//	Text Area
if ( isset( $instance[ 'textarea' ] ) ) {
	$textarea = $instance[ 'textarea' ];
}else {
	$textarea = '';
}

//	logo
if ( isset( $instance[ 'image' ] ) ) {
	$image = $instance[ 'image' ];
}else {
	$image = '';
}

// Widget admin form
?>
<p>
<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:' ,'interior-companion'); ?></label> 
<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<p>
<label for="<?php echo esc_attr( $this->get_field_id( 'textarea' ) ); ?>"><?php esc_html_e( 'About Content:' ,'interior-companion'); ?></label> 
<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'textarea' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'textarea' ) ); ?>"><?php echo esc_textarea( $textarea ); ?></textarea>
</p>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php _e( 'Image', 'interior-companion' ); ?>:</label>
	<div class="interior-media-container">
		<div class="interior-media-inner">
			<?php $img_style = ( $image != '' ) ? '' : 'style="display:none;"'; ?>
			<img id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>-preview" src="<?php echo esc_attr( $image ); ?>" <?php echo wp_kses_post( $img_style ); ?> />
			<?php $no_img_style = ( $image != '' ) ? 'style="display:none;"' : ''; ?>
			<span class="interior-no-image" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>-noimg" <?php echo wp_kses_post( $no_img_style ); ?>><?php _e( 'No image selected', 'interior-companion' ); ?></span>
		</div>
	
	<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" value="<?php echo esc_attr( $image ); ?>" class="interior-media-url" />

	<input type="button" value="<?php echo _e( 'Remove', 'interior-companion' ); ?>" class="button interior-media-remove" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>-remove" <?php echo wp_kses_post( $img_style ); ?> />

	<?php $button_text = ( $image != '' ) ? __( 'Change Image', 'interior-companion' ) : __( 'Select Image', 'interior-companion' ); ?>
	<input type="button" value="<?php echo esc_html( $button_text ); ?>" class="button interior-media-upload" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>-button" />
	<br class="clear">
	</div>
</p>
<style>
.interior-media-container {
	width: 98%;
}

.interior-media-inner {
	border: 1px solid #ddd;
	padding: 10px;
	text-align: center;
	border-radius: 2px;
	margin-bottom: 10px;
}

.widget-description img,
.interior-media-inner img {
	max-width: 100%;
	height: auto;
}

.interior-media-url {
	display: none;
}

.interior-media-remove {
	float: left;
	width: 48%;
}

.interior-media-upload {
	float: right;
	width: 48%;
}
</style>
<script>
jQuery(function($){
    'use strict';
	/**
	 *
	 * About Widget Logo upload
	 *
	 */
	$( function(){
	    // Upload / Change Image
    function wpshed_image_upload( button_class ) {
        
        var _custom_media = true,
            _orig_send_attachment = wp.media.editor.send.attachment;

        $( 'body' ).on( 'click', button_class, function(e) {

            var button_id           = '#' + $( this ).attr( 'id' ),
                self                = $( button_id),
                send_attachment_bkp = wp.media.editor.send.attachment,
                button              = $( button_id ),
                id                  = button.attr( 'id' ).replace( '-button', '' );

            _custom_media = true;

            wp.media.editor.send.attachment = function( props, attachment ){

                if ( _custom_media ) {

                    $( '#' + id + '-preview'  ).attr( 'src', attachment.url ).css( 'display', 'block' );
                    $( '#' + id + '-remove'  ).css( 'display', 'inline-block' );
                    $( '#' + id + '-noimg' ).css( 'display', 'none' );
                    $( '#' + id ).val( attachment.url ).trigger( 'change' );  

                } else {

                    return _orig_send_attachment.apply( button_id, [props, attachment] );

                }
            }

            wp.media.editor.open( button );

            return false;
        });
    }
    wpshed_image_upload( '.interior-media-upload' );

    // Remove Image
    function wpshed_image_remove( button_class ) {

        $( 'body' ).on( 'click', button_class, function(e) {

            var button              = $( this ),
                id                  = button.attr( 'id' ).replace( '-remove', '' );

            $( '#' + id + '-preview' ).css( 'display', 'none' );
            $( '#' + id + '-noimg' ).css( 'display', 'block' );
            button.css( 'display', 'none' );
            $( '#' + id ).val( '' ).trigger( 'change' );

        });
    }
    wpshed_image_remove( '.interior-media-remove' );
	
	});
});
</script>
<?php 
}

	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {

	
$instance = array();
$instance['title'] 	  = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['textarea'] = ( ! empty( $new_instance['textarea'] ) ) ? strip_tags( $new_instance['textarea'] ) : '';
$instance['image']  	  = ( ! empty( $new_instance['image'] ) ) ? strip_tags( $new_instance['image'] ) : '';

return $instance;
}
} // Class quickfix_subscribe_widget ends here


// Register and load the widget
function interior_about_load_widget() {
	register_widget( 'interior_about_widget' );
}
add_action( 'widgets_init', 'interior_about_load_widget' );