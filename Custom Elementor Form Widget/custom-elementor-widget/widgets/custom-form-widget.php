<?php
if (!defined('ABSPATH')) {
    exit;
}

class Custom_Form_Widget extends \Elementor\Widget_Base {

    // Widget name
    public function get_name() {
        return 'custom_form_widget';
    }

    // Widget title
    public function get_title() {
        return __('Custom Form Widget', 'plugin-name');
    }

    // Widget icon
    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    // Widget categories
    public function get_categories() {
        return ['basic'];
    }

    // Register the widget controls (form fields)
    protected function _register_controls() {
      $this->start_controls_section(
          'form_section',
          [
              'label' => __('Form Settings', 'plugin-name'),
              'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
          ]
      );

      // Form Title Control
      $this->add_control(
          'form_title',
          [
              'label'   => __('Form Title', 'plugin-name'),
              'type'    => \Elementor\Controls_Manager::TEXT,
              'default' => __('Contact Us', 'plugin-name'),
          ]
      );

      // Name Placeholder Control
      $this->add_control(
          'name_placeholder',
          [
              'label'   => __('Name Placeholder', 'plugin-name'),
              'type'    => \Elementor\Controls_Manager::TEXT,
              'default' => __('Enter your name', 'plugin-name'),
          ]
      );

      // Email Placeholder Control
      $this->add_control(
          'email_placeholder',
          [
              'label'   => __('Email Placeholder', 'plugin-name'),
              'type'    => \Elementor\Controls_Manager::TEXT,
              'default' => __('Enter your email', 'plugin-name'),
          ]
      );

      // Message Placeholder Control
      $this->add_control(
          'message_placeholder',
          [
              'label'   => __('Message Placeholder', 'plugin-name'),
              'type'    => \Elementor\Controls_Manager::TEXTAREA,
              'default' => __('Enter your message', 'plugin-name'),
          ]
      );

      // Background Color Control
      $this->add_control(
          'background_color',
          [
              'label'   => __('Background Color', 'plugin-name'),
              'type'    => \Elementor\Controls_Manager::COLOR,
              'default' => '#f9f9f9',
          ]
      );

      // Submit Button Color Control
      $this->add_control(
          'submit_button_color',
          [
              'label'   => __('Submit Button Color', 'plugin-name'),
              'type'    => \Elementor\Controls_Manager::COLOR,
              'default' => '#0073aa',
          ]
      );

      $this->end_controls_section();
  }




    // Render the form
    protected function render() {
      $settings = $this->get_settings_for_display();

      // Apply inline CSS for background and button colors
      $background_color = $settings['background_color'];
      $submit_button_color = $settings['submit_button_color'];

      ?>
      <div class="custom-form" style="background-color: <?php echo esc_attr($background_color); ?>;">
          <h3><?php echo esc_html($settings['form_title']); ?></h3>
          <form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
              <input type="text" name="custom_name" placeholder="<?php echo esc_attr($settings['name_placeholder']); ?>" required>
              <input type="email" name="custom_email" placeholder="<?php echo esc_attr($settings['email_placeholder']); ?>" required>
              <textarea name="custom_message" placeholder="<?php echo esc_attr($settings['message_placeholder']); ?>" required></textarea>
              <input type="submit" value="Submit" style="background-color: <?php echo esc_attr($submit_button_color); ?>;">
          </form>
      </div>
      <script>
      jQuery(document).ready(function($) {
          $('#custom-form').on('submit', function(e) {
              e.preventDefault();
              var formData = $(this).serialize();
              $.ajax({
                  url: '<?php echo admin_url('admin-ajax.php'); ?>',
                  type: 'POST',
                  data: formData + '&action=submit_custom_form',
                  success: function(response) {
                      $('#form-response').html(response);
                  }
              });
          });
      });
      </script>
      <?php
  }

    // Handle the form submission
    public function handle_form_submission() {
      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['custom_email'])) {
          $name    = sanitize_text_field($_POST['custom_name']);
          $email   = sanitize_email($_POST['custom_email']);
          $message = sanitize_textarea_field($_POST['custom_message']);

          // Validate form fields
          if (empty($name) || empty($email) || empty($message)) {
              echo '<div class="form-error">Please fill in all fields.</div>';
              return;
          }
          if (!is_email($email)) {
              echo '<div class="form-error">Please enter a valid email address.</div>';
              return;
          }

          // Process form data (send email or store it).
          // ...
      }
  }



}
