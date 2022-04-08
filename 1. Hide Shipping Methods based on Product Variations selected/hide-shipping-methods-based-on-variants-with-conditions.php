<?php
add_filter( 'woocommerce_package_rates', 'hide_shipping_method_based_on_variation_product_attribute', 10, 2 );
function hide_shipping_method_based_on_variation_product_attribute( $rates, $package ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    // HERE define the Product Attibute taxonomy (starts always with "pa_")
    $taxonomy = 'pa_mode'; // Example for "Mode"

    // HERE define shipping method rate ID to be removed from product attribute term(s) slug(s) (pairs) in this array
    $data_array = array(
        'flat_rate:2'   => array('pickup'),
		'local_pickup:3'   => array('delivery'),
    );

    // Loop through cart items
    foreach( $package['contents'] as $cart_item ){
        if( isset($cart_item['variation']['attribute_'.$taxonomy]) ) {
            // The product attribute selected term slug
            $term_slug = $cart_item['variation']['attribute_'.$taxonomy];

            // Loop through our data array
            foreach( $data_array as $rate_id => $term_slugs ) {
                if( in_array($term_slug, $term_slugs) && isset($rates[$rate_id]) ) {
                    // We remove the shipping method corresponding to product attribute term as defined
                    unset($rates[$rate_id]);
                }
            }
        }
    }
    return $rates;
}
?>