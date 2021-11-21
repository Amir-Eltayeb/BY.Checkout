<?php
/**
  * Plugin Name: BY-Checkout
  * Description:       Show or hide shipping addrees based on selected shipping method
  * Version:           1.16.0
  * Author:            Being You
 */

session_start();

if(!isset($_SESSION["local_pickup_once"]))  {
  echo 'local_pickup_once not set';
  $_SESSION["local_pickup_once"] = false;
}
else {
  echo 'local_pickup_once set';
}

if(!isset($_SESSION["free_shipping_once"]))  {
  echo 'free_shipping_once not set';
  $_SESSION["free_shipping_once"] = false;
}
else {
  echo 'free_shipping_once set';
}

add_filter('woocommerce_checkout_fields', 'by_remove_billing_checkout_fields');

function by_remove_billing_checkout_fields( $fields ) {

  $local_pickup_shipping = 'local_pickup:2'; // Value of the local pickup shipping method.
  $free_shipping = 'free_shipping:1'; // Value of the free shipping method.

  global $woocommerce;
  $chosen_methods = WC()->session->get( 'chosen_shipping_methods' ); //get the selected method array

  $chosen_shipping = $chosen_methods[0]; //select the first element in the array

  // if shipping equal local_pickup and fields are showing
  // then hide fields and refresh page

  if ( $chosen_shipping == $local_pickup_shipping && $_SESSION["local_pickup_once"] == false ) {

    $_SESSION["local_pickup_once"] = true;
    $_SESSION["free_shipping_once"] = false;

    unset( $fields['billing'][ 'billing_company' ] );
    unset( $fields['billing'][ 'billing_country' ] );
    unset( $fields['billing'][ 'billing_city' ] );
    unset( $fields['billing'][ 'billing_address_1' ] );
    unset( $fields['billing'][ 'billing_address_2' ] );
    unset( $fields['billing'][ 'billing_postcode' ] );
    unset( $fields['billing'][ 'billing_state' ] );
    header("refresh:0");

    echo 'local_pickup_shipping updated';
  }

  // if shipping equal free shipping and fields are not showing
  // then show fields and refresh page
  if ( $chosen_shipping == $free_shipping && $_SESSION["free_shipping_once"] == false ) {

    $_SESSION["local_pickup_once"] = false;
    $_SESSION["free_shipping_once"] = true;

    set( $fields['billing'][ 'billing_company' ] );
    set( $fields['billing'][ 'billing_country' ] );
    set( $fields['billing'][ 'billing_city' ] );
    set( $fields['billing'][ 'billing_address_1' ] );
    set( $fields['billing'][ 'billing_address_2' ] );
    set( $fields['billing'][ 'billing_postcode' ] );
    set( $fields['billing'][ 'billing_state' ] );
    header("refresh:0");

    echo 'free_shipping_once updated';
  }

  echo "choosen";
  echo $chosen_shipping;
  echo "local_pickup_once";
  echo $_SESSION["local_pickup_once"];
  echo "free_shipping_once";
  echo $_SESSION["free_shipping_once"];

  return $fields;

}
