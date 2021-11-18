<?php
/**
  * Plugin Name: B.Y. Checkout
  * Description:       Show or hide shipping addrees based on selected shipping method
  * Version:           1.00.0
  * Author:            Being You
 */



add_filter('woocommerce_checkout_fields', 'remove_billing_checkout_fields');

function remove_billing_checkout_fields( $fields ) {

  $shipping_method ='local_pickup:3'; // Value of the applicable shipping method.
  //global $woocommerce;
  //$chosen_methods = WC()->session->get( 'chosen_shipping_methods' ); //get the selected method array
  $chosen_shipping = $chosen_methods[0]; //select the first element in the array

  // check if the selected value is local pickup
  if ($chosen_shipping == $shipping_method) {

    unset( $fields['billing'][ 'billing_company' ] );
    unset( $fields['billing'][ 'billing_country' ] );
    unset( $fields['billing'][ 'billing_city' ] );
    unset( $fields['billing'][ 'billing_address_1' ] );
    unset( $fields['billing'][ 'billing_address_2' ] );
    unset( $fields['billing'][ 'billing_postcode' ] );
    unset( $fields['billing'][ 'billing_state' ] );

  }

  return $fields;

}
