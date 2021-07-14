# Drupal Address Metro Manila Cities
Additional selection dropdown for Metro Manila Cities. The city field will automatically change the text field into select field if the user selected any Metro Manila Province. Reduces the set of available countries to just 1 (Philippines).

## How it works?
Under `admin/config/people/profile-types/manage/customer/fields/profile.customer.address`, a predefined list of cities are added for the Metro Manila province. The list of metro manila cities will be only show if the user selected the Metro Manila in the province field. The list of metro manila cities will also be added in the `TERRITORY` under the commerce `Shipping Method`. The only country available is Philippines.

## Installation
Copy the `drupal_address_metromanila_cities` folder into your `web/modules/custom` folder

## Dependencies
This custom module is require of `drupal/address` module.


Credits to Halcyon Web Design for development time.
