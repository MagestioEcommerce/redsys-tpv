<?php

namespace Magestio\Redsys\Model\System\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Magestio\Redsys\Model\ConfigInterface;

class Environment implements ArrayInterface
{

	/**
	* Options getter
	*
	* @return array
	*/
	public function toOptionArray()
	{
		return [
			['value' => ConfigInterface::REDSYS_DEVELOPMENT_ENVIRONMENT, 'label' => __('Test Enviroment')],
			['value' => ConfigInterface::REDSYS_PRODUCTION_ENVIRONMENT, 'label' => __('Real Enviroment')]
		];
	}

	public function toArray()
	{
		return [
			ConfigInterface::REDSYS_DEVELOPMENT_ENVIRONMENT => __('Test Enviroment'),
			ConfigInterface::REDSYS_PRODUCTION_ENVIRONMENT => __('Real Enviroment'),
		];
	}
}
