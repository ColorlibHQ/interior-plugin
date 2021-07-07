<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * @Packge     : Interior Companion
 * @Version    : 1.0
 * @Author     : Colorlib
 * @Author     URI : http://colorlib.com/wp/
 *
 */


/*===========================================================
	Get elementor templates
============================================================*/
function get_elementor_templates() {
	$options = [];
	$args = [
		'post_type' => 'elementor_library',
		'posts_per_page' => -1,
	];

	$page_templates = get_posts($args);

	if (!empty($page_templates) && !is_wp_error($page_templates)) {
		foreach ($page_templates as $post) {
			$options[$post->ID] = $post->post_title;
		}
	}
	return $options;
}

// Section Heading
function interior_section_heading( $title = '', $subtitle = '' ) {
	if( $title || $subtitle ) :
	?>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section-heading text-center">
						<?php
						// Sub title
						if ( $subtitle ) {
							echo '<p>' . esc_html( $subtitle ) . '</p>';
						}
						// Title
						if ( $title ) {
							echo '<h2>' . esc_html( $title ) . '</h2>';
						}
						?>
					</div>
				</div>
			</div>
		</div>
	<?php
	endif;
}

// Enqueue scripts
add_action( 'wp_enqueue_scripts', 'interior_companion_frontend_scripts', 99 );
function interior_companion_frontend_scripts() {

	wp_enqueue_script( 'interior-companion-script', plugins_url( '../js/loadmore-ajax.js', __FILE__ ), array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'interior-common-js', plugins_url( '../js/common.js', __FILE__ ), array( 'jquery' ), '1.0', true );

}
// 
add_action( 'wp_ajax_interior_portfolio_ajax', 'interior_portfolio_ajax' );

add_action( 'wp_ajax_nopriv_interior_portfolio_ajax', 'interior_portfolio_ajax' );
function interior_portfolio_ajax( ){

	ob_start();

	if( !empty( $_POST['elsettings'] ) ):


		$items = array_slice( $_POST['elsettings'], $_POST['postNumber'] );

	    $i = 0;
	    foreach( $items as $val ):

	    $tagclass = sanitize_title_with_dashes( $val['label'] );
	    $i++;
	?>
	<div class="single_gallery_item <?php echo esc_attr( $tagclass ); ?>">
	    <?php 
	    if( !empty( $val['img']['url'] ) ){
	        echo '<img src="'.esc_url( $val['img']['url'] ).'" />';
	    }
	    ?>
	    <div class="gallery-hover-overlay d-flex align-items-center justify-content-center">
	        <div class="port-hover-text text-center">
	            <?php 
	            if( !empty( $val['title'] ) ){
	                echo interior_heading_tag(
	                    array(
	                        'tag'  => 'h4',
	                        'text' => esc_html( $val['title'] )
	                    )
	                );
	            }

	            if( !empty( $val['sub-title-url'] ) &&  !empty( $val['sub-title'] ) ){
	                echo '<a href="'.esc_url( $val['sub-title-url'] ).'">'.esc_html( $val['sub-title'] ).'</a>';
	            }else{
	                echo '<p>'.esc_html( $val['sub-title'] ).'</p>';
	            }
	            ?>
	            
	        </div>
	    </div>
	</div>

	<?php 

	if( !empty( $_POST['postIncrNumber'] ) ){

	    if( $i == $_POST['postIncrNumber'] ){
	        break;
	    }
	}
	    endforeach;
	endif;
	echo ob_get_clean();
	die();
}

	// Update the post/page by your arguments
	function interior_update_the_followed_post_page_status( $title = 'Hello world!', $type = 'post', $status = 'draft', $message = false ){

		// Get the post/page by title
		$target_post_id = get_page_by_title( $title, OBJECT, $type);

		// Post/page arguments
		$target_post = array(
			'ID'    => $target_post_id->ID,
			'post_status'   => $type,
		);

		if ( $message == true ) {
			// Update the post/page
			$update_status = wp_update_post( $target_post, true );
		} else {
			// Update the post/page
			$update_status = wp_update_post( $target_post, false );
		}

		return $update_status;
	}


	
// Project - Custom Post Type
function project_custom_posts() {	
	$labels = array(
		'name'               => _x( 'Project', 'post type general name', 'interior-companion' ),
		'singular_name'      => _x( 'Project', 'post type singular name', 'interior-companion' ),
		'menu_name'          => _x( 'Projects', 'admin menu', 'interior-companion' ),
		'name_admin_bar'     => _x( 'Projects', 'add new on admin bar', 'interior-companion' ),
		'add_new'            => _x( 'Add New', 'interior', 'interior-companion' ),
		'add_new_item'       => __( 'Add New Project', 'interior-companion' ),
		'new_item'           => __( 'New Project', 'interior-companion' ),
		'edit_item'          => __( 'Edit Project', 'interior-companion' ),
		'view_item'          => __( 'View Project', 'interior-companion' ),
		'all_items'          => __( 'All Projects', 'interior-companion' ),
		'search_items'       => __( 'Search Project', 'interior-companion' ),
		'parent_item_colon'  => __( 'Parent Project:', 'interior-companion' ),
		'not_found'          => __( 'No Project found.', 'interior-companion' ),
		'not_found_in_trash' => __( 'No Project found in Trash.', 'interior-companion' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description.', 'interior-companion' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		// 'menu_icon' 		 => 'dashicons-store',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'project' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'thumbnail' )
	);

	register_post_type( 'project', $args );

}
add_action( 'init', 'project_custom_posts' );

/*=========================================================
    Service Section
========================================================*/
function interior_get_projects( $sec_title ){ 
	$services = new WP_Query( array(
		'post_type' => 'project',
	) );
	?>
	
    <div class="service_area">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="section_title mb-50 text-center">
                        <h3><?php echo esc_html( $sec_title )?></h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="service_active owl-carousel">
                        <?php
						if( $services->have_posts() ) {
							while ( $services->have_posts() ) {
								$services->the_post();			
								$service_img = get_the_post_thumbnail( get_the_ID(), 'interior_service_thumb_362x258', '', array( 'alt' => get_the_title() ) );
								?>
								<div class="single_service">
									<?php
									if( $service_img ) {
										?>
										<div class="thumb">
											<?php echo $service_img?>
										</div>
										<?php
									}
									?>
									<div class="service_info">
										<h3><a href="<?php the_permalink()?>"><?php the_title()?></a></h3>
										<?php echo interior_excerpt_length(10)?>
									</div>
								</div>
                        		<?php
							}
						}
						?>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php
}
