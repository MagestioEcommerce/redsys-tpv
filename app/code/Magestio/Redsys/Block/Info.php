<?php

namespace Magestio\Redsys\Block;

use Magento\Framework\Phrase;
use Magento\Payment\Model\Config as PaymentConfig;
use Magento\Payment\Block\ConfigurableInfo;

/**
 * Class Info
 * @package Magestio\Redsys\Block
 */
class Info extends ConfigurableInfo
{

    /**
     * Returns label
     *
     * @param string $field
     * @return Phrase
     */
    protected function getLabel($field)
    {
        return __($field);
    }

}
