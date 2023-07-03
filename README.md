# Magento 2 Save Cart module  

This Open-Source module allows users to save their cart with a name and description.  
Users can manage their saved cart in the user account section.  

<ins>Available Options :</ins>
- Add saved cart active
- View saved cart detail
- Delete saved cart  

The module can be enable or disable via admin magento admin panel  


## Compatibility  
This module has been tested with Magento 2.4.5 


## Installation  
To Install the Magento2 Save Cart module:  
```
composer require maisondunet/module-save-quote
```
To enable the module:  
```
bin/magento module:enable Maisondunet_SaveQuote
```  


## Module configuration  
Module configuration is located at:  
Stores > Configuration > Sales > Checkout > Save Cart  



## How it works  

The user selects items and adds them to the shopping cart.  
When accessing the shopping cart simply click on the "save your cart" link.  

If the user is logged in, a Magento modal opens with a "Name" and "Description" input form (only name is required).  

If the user is not logged in, he is redirected to login page.  
When user save cart, a new empty cart is created for current cart.

User can find his saved cart in his account section by clicking on "My Saved Carts"  

### Merge Strategy  

User can add a saved cart in his current cart. If the current cart contains items, the module merges the two carts in the current cart.  


### Hyva Theme Compatibility  

We have also created module compatibility for Hÿva Theme available [Here](https://github.com/MdnAgency/magento-hyva-save-cart)
