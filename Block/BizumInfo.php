<?php

namespace Magestio\Redsys\Block;

use Magento\Framework\Phrase;
use Magento\Payment\Model\Config as PaymentConfig;
use Magento\Payment\Block\ConfigurableInfo;

/**
 * Class BizumInfo
 * @package Magestio\Redsys\Block
 */
class BizumInfo extends ConfigurableInfo
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
