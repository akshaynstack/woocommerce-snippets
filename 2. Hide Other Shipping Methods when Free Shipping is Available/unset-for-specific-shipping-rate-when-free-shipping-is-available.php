<?php
/**
 * @snippet       Hide one specific shipping rate when Free Shipping is available
 */
  
add_filter( 'woocommerce_package_rates', 'akshayn_unset_shipping_when_free_is_available_in_zone', 9999, 2 );
   
function akshayn_unset_shipping_when_free_is_available_in_zone( $rates, $package ) {
   // Only unset rates if free_shipping is available
   if ( isset( $rates['free_shipping:8'] ) ) {
      unset( $rates['flat_rate:1'] );
   }     
   return $rates;
}
?>