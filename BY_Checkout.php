<?php
/**
  * Plugin Name: B.Y. Checkout
  * Description:       Show or hide shipping addrees based on selected shipping method
  * Version:           1.09.0
  * Author:            Being You
 */



add_filter('woocommerce_checkout_fields', 'by_remove_billing_checkout_fields');

function by_remove_billing_checkout_fields( $fields ) {

  $local_pickup_shipping = 'local_pickup:2'; // Value of the local pickup shipping method.
  $free_shipping = 'free_shipping:1'; // Value of the free shipping method.

  global $woocommerce;
  $chosen_methods = WC()->session->get( 'chosen_shipping_methods' ); //get the selected method array

  $chosen_shipping = $chosen_methods[0]; //select the first element in the array

  // if shipping equal local_pickup and fields are showing
  // then hide fields and refresh page
  if ($chosen_shipping == $local_pickup_shipping && isset($fields['billing'][ 'billing_company' ])) {

    unset( $fields['billing'][ 'billing_company' ] );
    unset( $fields['billing'][ 'billing_country' ] );
    unset( $fields['billing'][ 'billing_city' ] );
    unset( $fields['billing'][ 'billing_address_1' ] );
    unset( $fields['billing'][ 'billing_address_2' ] );
    unset( $fields['billing'][ 'billing_postcode' ] );
    unset( $fields['billing'][ 'billing_state' ] );
    header("refresh:0");
  }

  // if shipping equal free shipping and fields are not showing
  // then show fields and refresh page
  if ($chosen_shipping == $free_shipping && !isset($fields['billing'][ 'billing_company' ])) {

    set( $fields['billing'][ 'billing_company' ] );
    set( $fields['billing'][ 'billing_country' ] );
    set( $fields['billing'][ 'billing_city' ] );
    set( $fields['billing'][ 'billing_address_1' ] );
    set( $fields['billing'][ 'billing_address_2' ] );
    set( $fields['billing'][ 'billing_postcode' ] );
    set( $fields['billing'][ 'billing_state' ] );
    header("refresh:0");
  }

  return $fields;

}





?>
