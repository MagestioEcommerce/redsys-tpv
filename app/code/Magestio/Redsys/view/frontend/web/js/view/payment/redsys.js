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

        var config = window.checkoutConfig.payment,
            redsysType = 'redsys',
            bizumType = 'bizum';

        if (config[redsysType].isActive) {
            rendererList.push(
                {
                    type: redsysType,
                    component: 'Magestio_Redsys/js/view/payment/method-renderer/redsys'
                }
            );
        }

        if (config[bizumType].isActive) {
            rendererList.push(
                {
                    type: bizumType,
                    component: 'Magestio_Redsys/js/view/payment/method-renderer/bizum'
                }
            );
        }

        /** Add view logic here if needed */
        return Component.extend({});
    }
);
