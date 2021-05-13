/*browser:true*/
/*global define*/
define(
    [
        'jquery',
        'Magento_Checkout/js/view/payment/default',
        'mage/url'
    ],
    function (
        $,
        Component,
        url
        ) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Magestio_Redsys/payment/bizum',
                code: 'bizum'
            },
            redirectAfterPlaceOrder: false,

            getCode: function() {
                return this.code;
            },

            getData: function() {
                return {
                    'method': this.item.method,
                    'additional_data': {}
                };
            },

            showIcons: function() {
                return window.checkoutConfig.payment.bizum.showIcon;
            },

            cardIcons: function(){
                return window.checkoutConfig.payment.bizum.icons;
            },

            afterPlaceOrder: function () {
                $.mage.redirect(
                    url.build(window.checkoutConfig.payment.bizum.redirectUrl + '?gateway=' + this.code)
                );
            }

        });
    }
);
