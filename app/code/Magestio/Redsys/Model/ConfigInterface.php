<?php

namespace Magestio\Redsys\Model;

/**
 * Interface ConfigInterface
 */
interface ConfigInterface 
{

	const REDSYS_DEVELOPMENT_ENVIRONMENT    = 0;
	const REDSYS_PRODUCTION_ENVIRONMENT     = 1;
    const REDSYS_REDIRECT_URI               = 'redsys/redirect/';
    const REDSYS_DEVELOPMENT_URI            = 'https://sis-t.redsys.es:25443/sis/realizarPago/utf-8';
    const REDSYS_PRODUCTION_URI             = 'https://sis.redsys.es/sis/realizarPago/utf-8';
    const REDSYS_SIGNATURE_VERSION          = 'HMAC_SHA256_V1';
    const REDSYS_PAYMETHODS                 = 'C';
    const REDSYS_DEFAULT_LANGUAGE           = '002';
    const REDSYS_DEFAULT_CURRENCY           = '978';

    const XML_PATH_ACTIVE                   = 'payment/redsys/active';
    const XML_PATH_TITLE                    = 'payment/redsys/title';
    const XML_PATH_ENVIRONMENT              = 'payment/redsys/environment';
    const XML_PATH_COMMERCE_NAME            = 'payment/redsys/commerce_name';
    const XML_PATH_COMMERCE_NUM             = 'payment/redsys/commerce_num';
    const XML_PATH_KEY256                   = 'payment/redsys/key256';
    const XML_PATH_TERMINAL                 = 'payment/redsys/terminal';
    const XML_PATH_TRANSACTION_TYPE         = 'payment/redsys/transaction_type';
    const XML_PATH_LANGUAGES                = 'payment/redsys/languages';
    const XML_PATH_AUTOINVOICE              = 'payment/redsys/autoinvoice';
    const XML_PATH_SENDINVOICE              = 'payment/redsys/sendinvoice';
    const XML_PATH_RECOVERY_CART            = 'payment/redsys/recovery_cart';
    const XML_PATH_DEBUG                    = 'payment/redsys/debug';
    const XML_PATH_ALLOWSPECIFIC            = 'payment/redsys/allowspecific';
    const XML_PATH_SPECIFICCOUNTRY          = 'payment/redsys/specificcountry';
    const XML_PATH_SORT_ORDER               = 'payment/redsys/sort_order';

}