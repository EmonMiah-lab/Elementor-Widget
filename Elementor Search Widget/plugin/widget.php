<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class My_Custom_Widget extends \Elementor\Widget_Base {

	// Your widget's name, title, icon and category
    public function get_name() {
        return 'search_widget';
    }

    public function get_title() {
        return __( 'Search Widget', 'my-custom-widget' );
    }

    public function get_icon() {
        return 'eicon-search';
    }

    public function get_categories() {
        return [ 'basic' ];
    }




	// Your widget's sidebar settings
    protected function _register_controls() {
      $this->start_controls_section(
              'content_section',
              [
                  'label' => __( 'Content', 'plugin-name' ),
                  'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
              ]
          );

          $this->add_control(
              'placeholder_text',
              [
                  'label' => __( 'Placeholder Text', 'plugin-name' ),
                  'type' => \Elementor\Controls_Manager::TEXT,
                  'default' => __( 'Search...', 'plugin-name' ),
              ]
          );

          // Search Field Background Color Control
                $this->add_control(
                    'search_field_bg_color',
                    [
                        'label' => __( 'Search Field Background Color', 'plugin-name' ),
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'default' => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .search-field' => 'background-color: {{VALUE}};',
                        ],
                    ]
                );

                // Search Button Background Color Control
                $this->add_control(
                    'search_button_color',
                    [
                        'label' => __( 'Search Button Color', 'plugin-name' ),
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'default' => '#0073aa',
                        'selectors' => [
                            '{{WRAPPER}} .search-submit' => 'background-color: {{VALUE}}; color: #fff;',
                        ],
                    ]
                );


          $this->end_controls_section();
    }





	// What your widget displays on the front-end
    protected function render() {
		$settings = $this->get_settings_for_display();

    ?>
         <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
             <input type="search" class="search-field" placeholder="<?php echo esc_attr( $settings['placeholder_text'] ); ?>" value="" name="s">
             <button type="submit" class="search-submit"><?php echo esc_html( 'Search' ); ?></button>
         </form>
         <?php
     }

     protected function _content_template() {
         ?>
         <#
          var placeholder = settings.placeholder_text;
          var searchFieldBg = settings.search_field_bg_color;
          var searchButtonColor = settings.search_button_color;
          #>
          <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
              <input type="search" class="search-field" placeholder="{{{ placeholder }}}" value="" name="s" style="background-color: {{{ searchFieldBg }}};">
              <button type="submit" class="search-submit" style="background-color: {{{ searchButtonColor }}};"><?php echo esc_html( 'Search' ); ?></button>
          </form>
          <?php
      }

}
