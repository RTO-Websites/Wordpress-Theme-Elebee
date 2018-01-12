<?php
namespace Elebee\Widgets\General\Imprint;

use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Controls_Manager;
use Elebee\Lib\Elebee;
use Elebee\Lib\ElebeeWidget;
use Elebee\Lib\Template;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 0.1.0
 */
class Imprint extends ElebeeWidget {

    public function __construct( $data = [], $args = null ) {

        parent::__construct( $data, $args );
        $this->album = null;

    }

    public function enqueueStyles() {

        wp_enqueue_style( $this->get_name(), get_stylesheet_directory_uri() . '/Widgets/General/Imprint/css/imprint.css', [], Elebee::VERSION, 'all' );

    }

    public function enqueueScripts() {
        // TODO: Implement enqueueScripts() method.
    }

	/**
	 * Retrieve the widget name.
	 *
	 * @since 0.1.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'imprint';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 0.1.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Imprint', TEXTDOMAIN );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 0.1.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-ticker';
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.3.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'imprint' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 0.1.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {

	    $this->registerSectionContent();
		$this->registerSectionTitleStyle();
        $this->registerSectionTextStyle();
        $this->registerSectionLinkStyle();

	}

    /**
     *
     *
     * @since 0.1.0
     */
    private function registerSectionContent() {

        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Imprint', TEXTDOMAIN ),
            ]
        );

        $this->add_control(
            'title_options',
            [
                'label' => __( 'Titel', 'elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', TEXTDOMAIN ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __( 'Impressum' , TEXTDOMAIN),
            ]
        );

        $this->add_control(
            'header_size',
            [
                'label' => __( 'HTML Tag', TEXTDOMAIN ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => __( 'H1', TEXTDOMAIN ),
                    'h2' => __( 'H2', TEXTDOMAIN ),
                    'h3' => __( 'H3', TEXTDOMAIN ),
                    'h4' => __( 'H4', TEXTDOMAIN ),
                    'h5' => __( 'H5', TEXTDOMAIN ),
                    'h6' => __( 'H6', TEXTDOMAIN ),
                    'div' => __( 'div', TEXTDOMAIN ),
                    'span' => __( 'span', TEXTDOMAIN ),
                    'p' => __( 'p', TEXTDOMAIN ),
                ],
                'default' => 'h2',
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => __( 'Alignment', TEXTDOMAIN ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', TEXTDOMAIN ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', TEXTDOMAIN ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', TEXTDOMAIN ),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => __( 'Justified', TEXTDOMAIN ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'imprint_options',
            [
                'label' => __( 'Impressum', 'elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'text',
            [
                'label' => __( 'Text', TEXTDOMAIN ),
                'type' => Controls_Manager::WYSIWYG,
                'default' => (new Template( __DIR__ . '/partials/text-default.php' ))->getRendered(),
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => __( 'View', TEXTDOMAIN ),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->end_controls_section();

    }

    /**
     *
     *
     * @since 0.1.0
     */
    private function registerSectionTitleStyle() {

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => __( 'Title', TEXTDOMAIN ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Title Color', TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-heading-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'title_text_shadow',
                'selector' => '{{WRAPPER}} .elementor-heading-title',
            ]
        );

        $this->end_controls_section();

    }

    /**
     *
     *
     * @since 0.1.0
     */
    private function registerSectionTextStyle() {

        $this->start_controls_section(
            'section_text_style',
            [
                'label' => __( 'Text', TEXTDOMAIN ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'h_tag_color',
            [
                'label' => __( 'H-Tag Color', TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .text h2' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .text h3' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .text h4' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .text h5' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .text h6' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .text',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'text_text_shadow',
                'selector' => '{{WRAPPER}} .text',
            ]
        );

        $this->end_controls_section();

    }

    /**
     *
     *
     * @since 0.1.0
     */
    private function registerSectionLinkStyle() {

        $this->start_controls_section(
            'section_link_style',
            [
                'label' => __( 'Links', TEXTDOMAIN ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_link_style' );
        $this->start_controls_tab(
            'tab_link',
            [
                'label' => __( 'Normal', TEXTDOMAIN ),
            ]
        );
        $this->add_control(
            'link_color',
            [
                'label' => __( 'Link Color', TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors' => [
                    '{{WRAPPER}} a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_link_hover',
            [
                'label' => __( 'Hover', TEXTDOMAIN ),
            ]
        );
        $this->add_control(
            'link_color_hover',
            [
                'label' => __( 'Link Color Hover', TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors' => [
                    '{{WRAPPER}} a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link_hover_time',
            [
                'label' => __( 'Speed (ms)', TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'ms' ],
                'range' => [
                    'ms' => [
                        'min'  => 0,
                        'max'  => 2000,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 600,
                    'unit' => 'ms',
                ],
                'selectors' => [
                    '{{WRAPPER}} a' => 'transition-duration: {{SIZE}}ms;',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'link_typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .text a',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'link_text_shadow',
                'selector' => '{{WRAPPER}} .text a',
            ]
        );

        $this->end_controls_section();

    }

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 0.1.0
	 *
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings();

		if ( empty( $settings['title'] ) ) {
			return;
		}

		$this->add_render_attribute( 'title', 'class', 'elementor-heading-title' );
//		$this->add_inline_editing_attributes( 'title' );
		
        $imprintTemplate = new Template( __DIR__ . '/partials/imprint.php', [
            'title' => $settings['title'],
            'headerSize' => $settings['header_size'],
            'headerAttributes' => $this->get_render_attribute_string( 'heading' ),
            'text' => $settings['text'],
        ] );
        $imprintTemplate->render();
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 0.1.0
	 *
	 * @access protected
	 */
	protected function _content_template() {

	    $contentTemplate = new Template( __DIR__ . '/partials/editor-content.php' );
	    $contentTemplate->render();

	}

}
