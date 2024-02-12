<?php

namespace Magestio\Redsys\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Sales\Model\OrderFactory;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\UrlInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magestio\Redsys\Logger\Logger;
use Magestio\Redsys\Helper\Helper;

/**
 * Class RedsysFactory
 * @package Magestio\Redsys\Model
 */
class RedsysFactory
{

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;

    /**
     * @var OrderFactory
     */
    protected $orderFactory;

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * @var UrlInterface
     */
    protected $url;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var OrderInterface
     */
    protected $order = null;

    /**
     * RedsysFactory constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param CheckoutSession $checkoutSession
     * @param OrderFactory $orderFactory
     * @param Helper $helper
     * @param UrlInterface $url
     * @param Logger $logger
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        CheckoutSession $checkoutSession,
        OrderFactory $orderFactory,
        Helper $helper,
        UrlInterface $url,
        Logger $logger
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->checkoutSession = $checkoutSession;
        $this->orderFactory = $orderFactory;
        $this->helper = $helper;
        $this->url = $url;
        $this->logger = $logger;
    }

    /**
     * @return OrderInterface
     */
    private function getOrder()
    {
        if (is_null($this->order)) {
            $orderId = $this->checkoutSession->getLastRealOrderId();
            $this->order = $this->orderFactory->create()->loadByIncrementId($orderId);
        }
        return $this->order;
    }

    /**
     * @return float
     */
    private function getRedsysAmount()
    {
        $transaction_amount = number_format($this->getOrder()->getBaseGrandTotal(), 2, '', '');
        return (float)$transaction_amount;
    }

    /**
     * @return string
     */
    private function getRedsysOrderNumber()
    {
        $orderId = $this->getOrder()->getIncrementId();
        return strval($orderId);
    }

    /**
     * @return string
     */
    private function getRedsysProducts()
    {
        $order = $this->getOrder();
        $products = '';
        foreach ($order->getAllVisibleItems() as $itemId => $item) {
            $products .= $item->getName();
            $products .= "X" . $item->getQtyToInvoice();
            $products .= "/";
        }
        return $products;
    }

    /**
     * @return string
     */
    private function getRedsysCustomer()
    {
        $order = $this->getOrder();
        return $order->getCustomerFirstname()." ".$order->getCustomerLastname()."/ ".__("Email: ").$order->getCustomerEmail();
    }

    /**
     * @param string $method
     * @return \Magestio\Redsys\Model\RedsysApi
     */
    public function createRedsysObject($method)
    {
        // Get all module Configurations
        $commerce_name = $this->scopeConfig->getValue(ConfigInterface::XML_PATH_COMMERCE_NAME, ScopeInterface::SCOPE_STORE);
        $commerce_num = $this->scopeConfig->getValue(ConfigInterface::XML_PATH_COMMERCE_NUM, ScopeInterface::SCOPE_STORE);
        $terminal = $this->scopeConfig->getValue(ConfigInterface::XML_PATH_TERMINAL, ScopeInterface::SCOPE_STORE);
        $trans = $this->scopeConfig->getValue(ConfigInterface::XML_PATH_TRANSACTION_TYPE, ScopeInterface::SCOPE_STORE);
        $enableEMV3DS = $this->scopeConfig->getValue(ConfigInterface::XML_PATH_EMV_3DS, ScopeInterface::SCOPE_STORE);

        // Redirect Result URL
        $orderId = $this->getOrder()->getIncrementId();
        $commerce_url = $this->url->getUrl('redsys/result', ['order_id' => $orderId]);
        $KOcommerce_url = $this->url->getUrl('redsys/koresult', ['order_id' => $orderId]);
        $OKcommerce_url = $this->url->getUrl('redsys/okresult', ['order_id' => $orderId]);

        // Setting Parameters to Redsys
        $redsysObj = new RedsysApi();
        $redsysObj->setParameter("DS_MERCHANT_AMOUNT", $this->getRedsysAmount());
        $redsysObj->setParameter("DS_MERCHANT_ORDER", $this->getRedsysOrderNumber());
        $redsysObj->setParameter("DS_MERCHANT_MERCHANTCODE", $commerce_num);
        $redsysObj->setParameter("DS_MERCHANT_CURRENCY", $this->helper->getCurrency($this->getOrder()));
        $redsysObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE", $trans);
        $redsysObj->setParameter("DS_MERCHANT_TERMINAL", $terminal);
        $redsysObj->setParameter("DS_MERCHANT_MERCHANTURL", $commerce_url);
        $redsysObj->setParameter("DS_MERCHANT_URLOK", $OKcommerce_url);
        $redsysObj->setParameter("DS_MERCHANT_URLKO", $KOcommerce_url);
        $redsysObj->setParameter("Ds_Merchant_ConsumerLanguage", $this->helper->getLanguage());
        $redsysObj->setParameter("Ds_Merchant_ProductDescription", $this->getRedsysProducts());
        $redsysObj->setParameter("Ds_Merchant_Titular", $this->getRedsysCustomer());
        $redsysObj->setParameter("Ds_Merchant_MerchantData", sha1($commerce_url));
        $redsysObj->setParameter("Ds_Merchant_MerchantName", $commerce_name);
        $redsysObj->setParameter("Ds_Merchant_PayMethods", $method);
        $redsysObj->setParameter("Ds_Merchant_Module", "magestio_redsys");

        // EMV 3DS data (for PSD2 compliance)
        if ($enableEMV3DS && $method == ConfigInterface::REDSYS_PAYMETHODS) {
            $redsysObj->setParameter("DS_MERCHANT_EMV3DS", $this->helper->generateMerchantEMV3DSData($this->getOrder()));
        }

        return $redsysObj;
    }

}
