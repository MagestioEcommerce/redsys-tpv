<?php

namespace Magestio\Redsys\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magestio\Redsys\Model\RedsysApi;
use Magestio\Redsys\Model\RedsysFactory;
use Magestio\Redsys\Model\ConfigInterface;

/**
 * Class Redirect
 * @package Magestio\Redsys\Block
 */
class Redirect extends Template
{

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var RedsysFactory
     */
    protected $redsysFactory;

    /**
     * @var RedsysApi
     */
    protected $redsysObj;

    /**
     * Redirect constructor.
     * @param Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param RedsysFactory $redsysFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        RedsysFactory $redsysFactory,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->redsysFactory = $redsysFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        $environment = $this->scopeConfig->getValue(ConfigInterface::XML_PATH_ENVIRONMENT, ScopeInterface::SCOPE_STORE);
        $action = ($environment == ConfigInterface::REDSYS_PRODUCTION_ENVIRONMENT) ? ConfigInterface::REDSYS_PRODUCTION_URI : ConfigInterface::REDSYS_DEVELOPMENT_URI;
        return $action;
    }

    /**
     * @return string
     */
    public function getSignatureVersion()
    {
        return ConfigInterface::REDSYS_SIGNATURE_VERSION;
    }

    /**
     * @return RedsysApi
     */
    private function getRedsysObject()
    {
        if (is_null($this->redsysObj)) {
            $this->redsysObj = $this->redsysFactory->createRedsysObject();
        }
        return $this->redsysObj;
    }

    /**
     * @return string
     */
    public function getParameters()
    {
        $redsysObj = $this->getRedsysObject();
        return $redsysObj->createMerchantParameters();
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        $redsysObj = $this->getRedsysObject();
        $key256 = $this->scopeConfig->getValue(ConfigInterface::XML_PATH_KEY256, ScopeInterface::SCOPE_STORE);
        return $redsysObj->createMerchantSignature($key256);
    }

}