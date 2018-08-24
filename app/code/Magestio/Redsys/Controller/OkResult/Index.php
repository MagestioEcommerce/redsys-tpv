<?php

namespace Magestio\Redsys\Controller\OkResult;

use Magento\Framework\App\Action\Action;

/**
 * Class Index
 * @package Magestio\Redsys\Controller\OkResult
 */
class Index extends Action
{

    public function execute()
    {
        $this->_redirect('checkout/onepage/success');
    }

}