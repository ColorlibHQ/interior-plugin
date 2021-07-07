<?php
namespace Interiorelementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Utils;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;



// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 *
 * Interior elementor about section widget.
 *
 * @since 1.0
 */
class Interior_About_Section extends Widget_Base {

	public function get_name() {
		return 'interior-about-us';
	}

	public function get_title() {
		return __( 'About Section', 'interior-companion' );
	}

	public function get_icon() {
		return 'eicon-column';
	}

	public function get_categories() {
		return [ 'interior-elements' ];
	}

	protected function _register_controls() {

        // ----------------------------------------  About Us content ------------------------------
        $this->start_controls_section(
            'about_content',
            [
                'label' => __( 'About Us Settings', 'interior-companion' ),
            ]
        );

        $this->add_control(
            'sec_img',
            [
                'label' => esc_html__( 'Left Image', 'interior-companion' ),
                'description' => esc_html__( 'Best size is 467x515', 'interior-companion' ),
                'type' => Controls_Manager::MEDIA,
                'label_block' => true,
                'default'     => [
                    'url'   => Utils::get_placeholder_image_src(),
                ]
            ]
        );
        $this->add_control(
            'sec_title',
            [
                'label' => esc_html__( 'Section Title', 'interior-companion' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default'   => 'Why Choose Us?',
            ]
        );
        $this->add_control(
            'sec_text',
            [
                'label' => esc_html__( 'Section Text', 'interior-companion' ),
                'type' => Controls_Manager::WYSIWYG,
                'label_block' => true,
                'default'   => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor incididunt.</p><ul><li> Apartments frequently or motionless. </li><li> Duis aute irure dolor in reprehenderit in voluptate. </li><li> Voluptatem quia voluptas sit aspernatur.</li></ul>',
            ]
        );
        $this->add_control(
            'btn_label',
            [
                'label' => esc_html__( 'Button Text', 'interior-companion' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default'   => __( 'About Us', 'interior-companion' ),
            ]
        );
        $this->add_control(
            'btn_url',
            [
                'label' => esc_html__( 'Button URL', 'interior-companion' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'default'   => [
                    'url' => '#'
                ],
            ]
        );
        $this->end_controls_section(); // End left content

        //------------------------------ Style title ------------------------------
        
        // Top Section Styles
        $this->start_controls_section(
            'about_sec_style', [
                'label' => __( 'About Section Styles', 'interior-companion' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'sub_title_col', [
                'label' => __( 'Sub Title Color', 'interior-companion' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .welcome_interior_area .welcome_interior_info h2' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'sec_title_col', [
                'label' => __( 'Sec Title Color', 'interior-companion' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .welcome_interior_area .welcome_interior_info h3' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'sec_text_col', [
                'label' => __( 'Sec Text Color', 'interior-companion' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .welcome_interior_area .welcome_interior_info p' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .welcome_interior_area .welcome_interior_info ul li' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'list_circle_col', [
                'label' => __( 'List Item Icon Color', 'interior-companion' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .welcome_interior_area .welcome_interior_info ul li::before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'btn_styles_seperator',
            [
                'label' => esc_html__( 'Button Styles', 'interior-companion' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after'
            ]
        );
        $this->add_control(
            'btn_txt_col', [
                'label' => __( 'Button Text & Border Color', 'interior-companion' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .welcome_interior_area .welcome_interior_info .boxed-btn3-white-2' => 'color: {{VALUE}} !important; border-color: {{VALUE}}',
                    '{{WRAPPER}} .welcome_interior_area .welcome_interior_info .boxed-btn3-white-2:hover' => 'background: {{VALUE}} !important; border-color: transparent',
                ],
            ]
        );
        $this->add_control(
            'btn_hvr_col', [
                'label' => __( 'Button Hover Color', 'interior-companion' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .welcome_interior_area .welcome_interior_info .boxed-btn3-white-2:hover' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->end_controls_section();

    }

	protected function render() {
    $settings   = $this->get_settings();  
    $sec_title  = !empty( $settings['sec_title'] ) ? $settings['sec_title'] : '';
    $sec_img    = !empty( $settings['sec_img']['id'] ) ? wp_get_attachment_image( $settings['sec_img']['id'], 'interior_about_thumb_460x390', '', array( 'alt' => $sec_title ) ) : '';
    $sec_text   = !empty( $settings['sec_text'] ) ? $settings['sec_text'] : '';
    $btn_label  = !empty( $settings['btn_label'] ) ? $settings['btn_label'] : '';
    $btn_url    = !empty( $settings['btn_url']['url'] ) ? $settings['btn_url']['url'] : '';
    ?>

    <!-- chose_area  -->
    <div class="chose_area ">
        <div class="container">
            <div class="features_main_wrap">
                <div class="row  align-items-center">
                    <div class="col-xl-5 col-lg-5 col-md-6">
                        <?php 
                            if ( $sec_img ) { 
                                echo '
                                    <div class="about_image">
                                        '.$sec_img.'
                                    </div>
                                ';
                            }
                        ?>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="features_info">
                            <?php 
                                if ( $sec_title ) { 
                                    echo '<h3>'.wp_kses_post($sec_title).'</h3>';
                                }
                                if ( $sec_text ) { 
                                    echo '<p>'.wp_kses_post( $sec_text ).'</p>';
                                }

                                if ( $btn_label ) { 
                                    ?>
                                    <div class="about_btn">
                                        <?php
                                            echo '<a class="boxed-btn3-line" href="'.esc_url( $btn_url ).'">'.esc_html( $btn_label ).'</a>';
                                        ?>
                                    </div>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ chose_area  -->
    <?php
    }
}