<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_My_Custom_Elementor_Thing extends Widget_Base {

   public function get_name() {
      return 'lined-heading';
   }

   public function get_title() {
      return __( 'Heading - Lined', 'elementor-lined-heading' );
   }

   public function get_icon() { 
        return 'eicon-heading';
   }

   protected function _register_controls() {

		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Title', 'elementor' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Enter your title', 'elementor' ),
				'default' => __( 'Add Your Heading Text Here', 'elementor' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'elementor' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'elementor' ),
				'default' => [
					'url' => '',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'size',
			[
				'label' => __( 'Size', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'elementor' ),
					'small' => __( 'Small', 'elementor' ),
					'medium' => __( 'Medium', 'elementor' ),
					'large' => __( 'Large', 'elementor' ),
					'xl' => __( 'XL', 'elementor' ),
					'xxl' => __( 'XXL', 'elementor' ),
				],
			]
		);

		$this->add_control(
			'header_size',
			[
				'label' => __( 'HTML Tag', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h2',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'elementor' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'elementor' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'elementor' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __( 'Title', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
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
				'name' => 'typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .elementor-heading-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .elementor-heading-title',
			]
		);

		$this->end_controls_section();

   }

	/**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		//<h2 class="h-custom-headline cs-ta-center h3 accent"><span>Supported By</span></h2>

		$settings = $this->get_settings();

		if ( empty( $settings['title'] ) ) {
			return;
		}

		$this->add_render_attribute( 'title', 'class', 'elementor-heading-title' );
		$this->add_render_attribute( 'title', 'class', 'elementor-lined-heading' );

		if ( ! empty( $settings['size'] ) ) {
			$this->add_render_attribute( 'title', 'class', 'elementor-size-' . $settings['size'] );
		}

		$this->add_inline_editing_attributes( 'title' );

		$title = $settings['title'];

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_render_attribute( 'url', 'href', $settings['link']['url'] );

			if ( $settings['link']['is_external'] ) {
				$this->add_render_attribute( 'url', 'target', '_blank' );
			}

			if ( ! empty( $settings['link']['nofollow'] ) ) {
				$this->add_render_attribute( 'url', 'rel', 'nofollow' );
			}

			$title = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( 'url' ), $title );
		}

		$title_html = sprintf( '<%1$s %2$s><span>%3$s</span></%1$s>', $settings['header_size'], $this->get_render_attribute_string( 'title' ), $title );

		echo $title_html;
	}

	/**
	 * Render heading widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<#
		var title = settings.title;

		if ( '' !== settings.link.url ) {
			title = '<a href="' + settings.link.url + '">' + title + '</a>';
		}

		view.addRenderAttribute( 'title', 'class', [ 'elementor-heading-title', 'elementor-size-' + settings.size ] );

		view.addInlineEditingAttributes( 'title' );

		var title_html = '<' + settings.header_size  + ' ' + view.getRenderAttributeString( 'title' ) + '>' + title + '</' + settings.header_size + '>';

		print( title_html );
		#>
		<?php
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_My_Custom_Elementor_Thing );
?>