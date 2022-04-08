<?php
/**
 * @snippet       Hide ALL shipping rates in ALL zones when Free Shipping is available
 */
  
add_filter( 'woocommerce_package_rates', 'akshayn_unset_shipping_when_free_is_available_all_zones', 9999, 2 );
   
function akshayn_unset_shipping_when_free_is_available_all_zones( $rates, $package ) {
   $all_free_rates = array();
   foreach ( $rates as $rate_id => $rate ) {
      if ( 'free_shipping' === $rate->method_id ) {
         $all_free_rates[ $rate_id ] = $rate;
         break;
      }
   }
   if ( empty( $all_free_rates )) {
      return $rates;
   } else {
      return $all_free_rates;
   } 
}
?>