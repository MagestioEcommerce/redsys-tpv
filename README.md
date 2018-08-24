# Redsys TPV extension for Magento 2

[![N|Solid](https://magestio.com/wp-content/uploads/logo_web_r.png)](https://magestio.com)

### Features

* Developed with the new API Getway Payment of Magento 2 [Magento 2 Payment Provider Gateway](https://devdocs.magento.com/guides/v2.2/payments-integrations/payment-gateway/payment-gateway-intro.html)
* Allow customers to pay with credit or debit cards
* Secure payment throught Redsys Payment Gateway
* Customers can change the payment method if Redsys fails
* Recovery cart if payment fails
* Automatic invoice
* Send invoice to the customer
* Compatible with HTTPS/SSL
* Redsys Gateway will use the same language that the store
* Multiple currency
* Production and Test environment
* Multi store


### Installation

* Download the extension
* Unzip the file
* Copy the content from the unzip folder to Magento root


### Enable extension

```
php bin/magento module:enable Magestio_Redsys
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento cache:flush
php bin/magento setup:static-content:deploy
```

### Requirements

* Compatible with Magento 2.2.+

### Technical support

* Web: [https://magestio.com/](https://magestio.com/)