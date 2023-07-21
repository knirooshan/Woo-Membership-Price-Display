<?php
/*
Plugin Name: Woo Membership Price Display
Plugin URI: https://aradhana.au/
Description: Display Woocommerce membership prices for non-members.
Version: 1.0.0
Author: Aradhana Group
Author URI: https://aradhana.au/
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

function sv_wc_memberships_members_only_product_notice() {
    // Get the current user's membership
$user_memberships = new WC_Memberships_User_Memberships();
$user_id = 3;
$membership_slug = 'ucomputers-membership';
$user_membership = $user_memberships->get_user_membership( $user_id, $membership_slug );

// Get the current product ID
$product_id = get_the_ID();

// Get the product object
$product = wc_get_product( $product_id );


if ( wc_memberships_is_user_member( get_current_user_id(), $membership_slug ) ) {
    
    return;
    
	}else{
	    
	    // Check if the user has a membership and the product is valid
        if ( $user_membership && $product ) {
            
             // Get the discounted price for the product
            $discount = wc_memberships_get_member_product_discount( $user_membership, $product );

            if ( $discount ) {
                // Calculate the discounted price
                $discounted_price = $product->get_price() - $discount;

                // Display the discounted price
                echo '<p style="font-size: 18px; color: #ff0404;  font-weight: 700;">Membership price: $' . $discounted_price . '</br> <a style="font-size: 14px;" href="https://ucomputers.com.au/product/ucomputers-membership/">Want a discount? Become a member!</a></p>';
            
                
            }
            
        }else{
            
            return;
            
        }
	}

}
add_action( 'woocommerce_single_product_summary', 'sv_wc_memberships_members_only_product_notice', 12 );