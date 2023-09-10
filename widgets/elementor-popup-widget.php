<?php


class ELEMENTOR_POPUP_WIDGET extends \Elementor\Widget_Base
{

	/**
	 * Get widget name.
	 *
	 * Retrieve Elementor Popup name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_name()
	{
		return 'elementor_popup';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Elementor Popup title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_title()
	{
		return __('Elementor Popup', 'elementor-popup');
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Elementor Popup icon.
	 *
	 * @return string Widget icon.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_icon()
	{
		return 'fa fa-address-card-o';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Elementor Popup belongs to.
	 *
	 * @return array Widget categories.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_categories()
	{
		return ['general'];
	}

	/**
	 * Register Elementor Popup controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls()
	{

		$this->register_content_controls();
		$this->register_style_controls();
	}

	/**
	 * Register Elementor Popup content ontrols.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_content_controls()
	{
		// Left Contents
		$this->start_controls_section(
			'content_section',
			[
				'label' => __('Left Contents', 'elementor-popup'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => __('Title', 'elementor-popup'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'placeholder' => __('Jal Amrith', 'elementor-popup'),
				'default'     => __('Jal Amrith', 'elementor-popup'),
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__('Choose Image', 'elementor-popup'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'timer',
			[
				'label' => esc_html__('Popup Timer', 'elementor-popup'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 30,
				'step' => 1,
				'default' => 10,
			]
		);


		$this->add_control(
			'price',
			[
				'label'       => __('Price Detail', 'elementor-popup'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'default'     => __('MRP ₹ 1500', 'elementor-popup'),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'list_title',
			[
				'label' => esc_html__('List', 'textdomain'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('List', 'elementor-popup'),
				'label_block' => true,
			]
		);

		$this->add_control('feature', [
			'label'       => __('Feature', 'elementor-popup'),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'list_title'       => 'List 1',
					'list_content' => 'Water, Electricity and  Fertilizer Conservation'
				],
				[
					'list_title'       => 'List 2',
					'list_content' => 'Efficient Water Management'
				],
			],
			'title_field' => '{{{ list_title }}}',
		]);

		$this->end_controls_section();

		// Right Contents
		$this->start_controls_section(
			'right_content_section',
			[
				'label' => __('Right Contents', 'elementor-popup'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'number_heading',
			[
				'label'       => __('Heading for Number', 'elementor-popup'),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 3,
				'default'     => __('Share your Number with Us', 'elementor-popup'),
			]
		);

		$this->add_control(
			'number_text',
			[
				'label'       => __('Text for Number', 'elementor-popup'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'default'     => __('MOBILE NUMBER', 'elementor-popup'),
			]
		);

		$this->add_control(
			'show_number_input',
			[
				'label' => esc_html__('Show Input Number Field', 'elementor-popup'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'elementor-popup'),
				'label_off' => esc_html__('Hide', 'elementor-popup'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'after_number_description',
			[
				'label' => esc_html__('After Input Content', 'elementor-popup'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 3,
				'default' => esc_html__('We will contact you in this number', 'elementor-popup'),
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => esc_html__('Contact Now Button', 'elementor-popup'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'default' => esc_html__('CONTACT NOW', 'elementor-popup'),
			]
		);

		$this->add_control(
			'button_link',
			[
				'label' => esc_html__('Contact link', 'elementor-popup'),
				'type' => \Elementor\Controls_Manager::URL,
				'options' => ['url', 'is_external', 'nofollow'],
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
			]
		);

		$this->end_controls_section();


		// Right Contents
		$this->start_controls_section(
			'footer_content_section',
			[
				'label' => __('Footer Contents', 'elementor-popup'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'footer_content',
			[
				'label' => esc_html__('Footer Content', 'elementor-popup'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 4,
				'default' => esc_html__('Popup Footer Description', 'elementor-popup'),
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Register Elementor Popup style ontrols.
	 *
	 * Adds different input fields in the style tab to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_style_controls()
	{

		$this->start_controls_section(
			'style_section',
			[
				'label' => __('Text Style', 'elementor-popup'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->end_controls_section();
	}

	/**
	 * Render Elementor Popup output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render()
	{

		$settings   = $this->get_settings_for_display(); //and echo $settings['dummy_text']
		// $dummy_text = $this->get_settings('dummy_text');
		// $this->add_render_attribute('dummy_text', 'class', 'dummy_text');
		// $this->add_inline_editing_attributes('dummy_text');
?>
		<div class="popup" id="popup">
			<span class="close-btn">&times;</span>
			<div class="wrapper">
				<div class="popup-timer" data-timer="<?php echo absint($settings['timer']); ?>">
					<?php
					if ($settings['image']) {
						$image = $this->get_settings('image');
						printf('<img style="margin-bottom:20px" src="%s" alt="Jal Amrith Logo">', esc_url($image['url']));
					} else {
						printf('<img style="margin-bottom:20px" src="%s" alt="Jal Amrith Logo">', esc_url(plugin_dir_url(__DIR__) . 'image/logo-jal-amrith.png'));
					}

					if ($settings['title']) {
						printf('<h6 style="margin-bottom:10px">%s</h6>', esc_html($settings['title']));
					}

					if ($settings['price']) {
						printf('<h6>%s</h6>', esc_html($settings['price']));
						// MRP ₹ 1500
					}

					if ($settings['feature']) : ?>
						<ul style="margin: 0; padding: 0;">
							<?php
							foreach ($settings['feature'] as $feature) {
								if (!empty($feature['list_title'])) {
									printf('<li style="list-style-type:none; font-size:16px; line-height: 1.75rem;">%s</li>', $feature['list_title']);
								}
							}
							?>
							<!-- <li>Efficient Water Management</li>
					<li>Enhanced water absorption</li>
					<li>Prolonged Soil Mostrue</li>
					<li>Minimized Water Evaporation</li>
					<li>Environmental Impact</li> -->
						</ul>
					<?php endif; ?>

				</div>
				<div class="popup-timer">
					<?php
					if ($settings['number_heading']) {
						printf('<h2>%s</h2>', esc_html($settings['number_heading']));
					}

					if ($settings['number_text']) {
						printf('<h6>%s</h6>', esc_html($settings['number_text']));
					}

					if ($settings['show_number_input']) : ?>
						<form action="" class="phone-number" method="post">
							<input id="phone" name="phone" type="tel" />
							<?php
							if ($settings['after_number_description']) {
								printf('<p>%s</p>', esc_html($settings['after_number_description']));
							}
							if ($settings['button_text'] && $settings['button_link']) {
								printf('<button type="submit" id="submit" data-send="%s" name="submit">%s</button>', $settings['button_link']['url'], esc_html($settings['button_text']));
							}
							?>
						</form>

					<?php endif; ?>
				</div>
			</div>
			<?php
			if ($settings['footer_content']) {
				printf('<p>%s</p>', esc_html($settings['footer_content']));
				// Incorporate Jal Amrith can help reduce water usage under by 30%, and you will enjoy an additional 5% reduction in fertilizer without any impace on yield quality and quantity.
			} ?>
		</div>
	<?php
	}

	/**
	 * Render Elementor Popup output on the frontend.
	 *
	 * Written in JS and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _content_template()
	{
		$this->add_render_attribute('dummy_text', 'class', 'dummy_text');
		// $this->add_inline_editing_attributes('dummy_text', 'none');
	?>
		<div <?php
				echo $this->get_render_attribute_string('dummy_text')
				?>>
			{{ settings.dummy_text }}
		</div>
<?php
	}
}
