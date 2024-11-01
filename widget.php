<?php

class WP_Domain_Search extends WP_Widget {
  public $defaults;

  function __construct() {
    parent::__construct(
      'wpdn', // Base ID
      'WP Domain Search'  // Name
    );

    $this->defaults = array(
      'customCSS' => '',
      'defaultCSS' => 'on',
      'placeholder' => esc_html__('Enter Domain', 'text_domain'),
      'registrar' => get_option('wpdn_registrar') !== null ? get_option('wpdn_registrar') : 'nerdwarehouse',
      'textCTA' => esc_html__('Buy Now', 'text_domain'),
      'textSearch' => esc_html__('Search', 'text_domain'),
      'title' => esc_html__('Domain Search', 'text_domain'),
    );

    add_action('widgets_init', function() {
      register_widget('WP_Domain_Search');
    });
  }

  public $args = array(
    'before_title'  => '<h4 class="widgettitle">',
    'after_title'   => '</h4>',
    'before_widget' => '<div class="widget-wrap">',
    'after_widget'  => '</div></div>'
  );

  public function widget($args, $instance) {
    echo $args['before_widget'];

    if (!empty($instance['title'])) {
      echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
    }

    echo '<div class="textwidget">';

    if ($instance['defaultCSS'] == 'on') {
      include 'widget.css.php';
    }

    if (!empty($instance['customCSS'])) {
      echo '<style>'. $instance['customCSS'] .'</style>';
    }

    echo '<form class="wpdn_form"
                data-id="'. $this->id .'"
                data-registrar="'. $instance['registrar'] .'"
                id="form_'. $this->id .'">
            <div id="icon_'. $this->id .'">
              <span class="wpdn-icon-search"></span>
            </div>
            <input id="domain_'. $this->id .'"
                   name="domain_'. $this->id .'"
                   placeholder="'. (isset($instance['placeholder']) ? $instance['placeholder'] : '') .'"
                   type="text" />
            <button id="search_'. $this->id .'" type="submit">
              '. (isset($instance['textSearch']) ? $instance['textSearch'] : '') .'
            </button>
            <a id="buy_'. $this->id .'" href="" target="_blank" style="display:none;">
              '. (isset($instance['textCTA']) ? $instance['textCTA'] : '') .'
            </a>
          </form>

          <div id="error_'. $this->id .'" style="display: none;"></div>
      </div>';

    echo $args['after_widget'];

    wp_enqueue_style(
      'wpdn-domain-search-icons',
      plugin_dir_url(__FILE__) . 'icomoon.css'
    );

    wp_enqueue_script(
      'jquery-validate',
      'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js',
      array('jquery')
    );

    wp_enqueue_script(
      'wpdn-domain-search'. $this->id,
      plugin_dir_url(__FILE__) . 'widget.js',
      array('jquery', 'jquery-validate')
    );
  }

  public function form($instance) {
    $instance = wp_parse_args((array) $instance, $this->defaults);
    ?>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
        <?php echo esc_html__('Title:', 'text_domain'); ?>
      </label>
      <input class="widefat"
             id="<?php echo esc_attr($this->get_field_id('title')); ?>"
             name="<?php echo esc_attr($this->get_field_name('title')); ?>"
             type="text"
             value="<?php echo esc_attr($instance['title']); ?>">
    </p>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('registrar')); ?>">
        <?php echo esc_html__('Domain Registrar:', 'text_domain'); ?> <sup style="color:red;">*</sup>
      </label>
      <select class="widefat"
              id="<?php echo esc_attr($this->get_field_id('registrar')); ?>"
              name="<?php echo esc_attr($this->get_field_name('registrar')); ?>">
        <option value="nerdwarehouse" <?php echo selected('nerdwarehouse', $instance['registrar']); ?>>NerdWarehouse.com</option>
        <option value="domain" <?php echo selected('domain', $instance['registrar']); ?>>Domain.com</option>
        <option value="godaddy" <?php echo selected('godaddy', $instance['registrar']); ?>>GoDaddy.com</option>
        <option value="namecheap" <?php echo selected('namecheap', $instance['registrar']); ?>>Namecheap.com</option>
      </select>
    </p>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('placeholder')); ?>">
        <?php echo esc_html__('Search Placeholder:', 'text_domain'); ?>
      </label>
      <input class="widefat"
             id="<?php echo esc_attr($this->get_field_id('placeholder')); ?>"
             name="<?php echo esc_attr($this->get_field_name('placeholder')); ?>"
             type="text"
             value="<?php echo esc_attr($instance['placeholder']); ?>" />
    </p>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('textSearch')); ?>">
        <?php echo esc_html__('Search Button:', 'text_domain'); ?> <sup style="color:red;">*</sup>
      </label>
      <input class="widefat"
             id="<?php echo esc_attr($this->get_field_id('textSearch')); ?>"
             name="<?php echo esc_attr($this->get_field_name('textSearch')); ?>"
             type="text"
             value="<?php echo esc_attr($instance['textSearch']); ?>" />
    </p>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('textCTA')); ?>">
        <?php echo esc_html__('Buy Button:', 'text_domain'); ?> <sup style="color:red;">*</sup>
      </label>
      <input class="widefat"
             id="<?php echo esc_attr($this->get_field_id('textCTA')); ?>"
             name="<?php echo esc_attr($this->get_field_name('textCTA')); ?>"
             type="text"
             value="<?php echo esc_attr($instance['textCTA']); ?>" />
    </p>
    <p>
      <input class="checkbox"
             id="<?php echo esc_attr($this->get_field_id('defaultCSS')); ?>"
             name="<?php echo esc_attr($this->get_field_name('defaultCSS')); ?>"
             type="checkbox"
             <?php checked($instance['defaultCSS'], 'on'); ?> />
      <label for="<?php echo esc_attr($this->get_field_id('defaultCSS')); ?>">
        <?php echo esc_html__('Include Default CSS', 'text_domain'); ?>
      </label>
    </p>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('customCSS')); ?>">
        <?php echo esc_html__('Custom CSS:', 'text_domain'); ?>
      </label>
      <textarea class="widefat"
                id="<?php echo esc_attr($this->get_field_id('customCSS')); ?>"
                name="<?php echo esc_attr($this->get_field_name('customCSS')); ?>"
                style="min-height: 100px;"><?php echo esc_attr($instance['customCSS']); ?></textarea>
      <span style="color:#AAA;">
        WP will assign the widget an ID after you save the first time.<br/>
        Then you can use these selectors in your custom CSS:<br/><br/>
        form.wpdn_form { }<br/>
        #form_<?php echo $this->id; ?> { }<br/>
        #form_<?php echo $this->id; ?> button, #form_<?php echo $this->id; ?> a { }<br/>
        #icon_<?php echo $this->id; ?> { }<br/>
        #domain_<?php echo $this->id; ?> { }<br/>
        #search_<?php echo $this->id; ?> { }<br/>
        #buy_<?php echo $this->id; ?> { }<br/>
        #error_<?php echo $this->id; ?> { }
      </span>
    </p>
    <?php
  }

  public function update($new_instance, $old_instance ) {
    $instance = array();
    $instance['customCSS'] = !empty($new_instance['customCSS']) ? $new_instance['customCSS'] : '';
    $instance['defaultCSS'] = $new_instance['defaultCSS'];
    $instance['placeholder'] = !empty($new_instance['placeholder']) ? $new_instance['placeholder'] : '';
    $instance['registrar'] = isset($new_instance['registrar']) ? $new_instance['registrar'] : 'nerdwarehouse';
    $instance['textCTA'] = !empty($new_instance['textCTA']) ? esc_attr($new_instance['textCTA']) : $this->defaults['textCTA'];
    $instance['textSearch'] = !empty($new_instance['textSearch']) ? esc_attr($new_instance['textSearch']) : $this->defaults['textSearch'];
    $instance['title'] = isset($new_instance['title']) ? esc_attr($new_instance['title']) : '';
    return $instance;
  }
}

$wp_domain_search = new WP_Domain_Search();