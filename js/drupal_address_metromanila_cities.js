(($, Drupal) => {
  'use strict';

  const $win = $(window);
  const $doc = $(document);
  
  /*
  * Drupal behaviors
  */
  Drupal.behaviors.jayson_custom_module = {
    attach: (context, settings) => {
      
    }
  };
    
  $win.on('load', function() {
    $(document).on('click', '.commerce-checkout-flow .form-item-shipping-information-shipping-profile-address-0-address-administrative-area select, .commerce-checkout-flow .form-item-shipping-information-shipping-profile-address-0-address-locality select', function(){
      $('.commerce-checkout-flow .form-item-shipping-information-shipping-profile-address-0-address-postal-code input.postal-code').val('');
    });
    
    $(document).on('focus', '.commerce-checkout-flow .form-item-shipping-information-shipping-profile-address-0-address-administrative-area select', function(){
      $('.commerce-checkout-flow .form-item-shipping-information-shipping-profile-address-0-address-postal-code input.postal-code').val('');
      if($('.commerce-checkout-flow .form-item-shipping-information-shipping-profile-address-0-address-locality input.locality').length) {
        $('.commerce-checkout-flow .form-item-shipping-information-shipping-profile-address-0-address-locality input.locality').val('');
      }
      
      if($('.commerce-checkout-flow .form-item-shipping-information-shipping-profile-address-0-address-locality select.locality').length) {
        $('.commerce-checkout-flow .form-item-shipping-information-shipping-profile-address-0-address-locality select.locality').prop("selectedIndex", 0);
      }
    });
    
    $(document).on('click', '.commerce-checkout-flow .form-item-shipping-information-shipping-profile-address-0-address-administrative-area select', function(){
      $('.commerce-checkout-flow .form-item-shipping-information-shipping-profile-address-0-address-postal-code input.postal-code').val('');
    });
    
  });
  
})(jQuery, Drupal);