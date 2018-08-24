/*browser:true*/
/*global define*/
define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'redsys',
                component: 'Magestio_Redsys/js/view/payment/method-renderer/redsys'
            }
        );
        /** Add view logic here if needed */
        return Component.extend({});
    }
);