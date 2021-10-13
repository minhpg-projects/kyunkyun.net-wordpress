<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

/**
 *
 * Field: Sidebar
 *
 */
class CSFramework_Option_sidebar extends CSFramework_Options {

  public function __construct( $field, $value = '', $unique = '' ) {
    parent::__construct( $field, $value, $unique );
  }

  public function output() {

    echo $this->element_before();

      $options    = $GLOBALS['wp_registered_sidebars'];
      $class      = $this->element_class();
      $options    = ( is_array( $options ) ) ? $options : array_filter( $this->element_data( $options ) );
      $extra_name = ( isset( $this->field['attributes']['multiple'] ) ) ? '[]' : '';
      $chosen_rtl = ( is_rtl() && strpos( $class, 'chosen' ) ) ? 'chosen-rtl' : '';

      echo '<select name="'. $this->element_name( $extra_name ) .'"'. $this->element_class( $chosen_rtl ) . $this->element_attributes() .'>';

      echo ( isset( $this->field['default_option'] ) ) ? '<option value="">'.$this->field['default_option'].'</option>' : '';

      foreach ( $options as $sidebar ) {
        echo '<option value="' . ucwords( $sidebar['id'] ) . '"' . $this->checked( $this->element_value(), ucwords( $sidebar['id'] ), 'selected' ) . '>' . ucwords( $sidebar['name'] ) . '</option>';
      }
	  echo '<option value="halim_nosidebar">No Sidebar</option>';
      echo '</select>';

    echo $this->element_after();

  }

}

