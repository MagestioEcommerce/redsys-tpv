<?php

namespace Magestio\Redsys\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Phrase;
use Magento\Sales\Api\OrderManagementInterface;
use Magento\Sales\Api\Data\OrderStatusHistoryInterfaceFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\OrderFactory;
use Magento\Sales\Model\Order\StatusResolver;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\MailException;
use Magestio\Redsys\Model\Language;
use Magestio\Redsys\Model\Currency;
use Magestio\Redsys\Model\Response;
use Magestio\Redsys\Model\CountryIso;
use Magento\Customer\Model\Session;

/**
 * Class Helper
 * @package Magestio\Redsys\Helper
 */
class Helper extends AbstractHelper
{

    /**
     * @var OrderFactory
     */
    protected $orderFactory;

    /**
     * @var OrderManagementInterface
     */
    protected $orderManagement;

    /**
     * @var OrderStatusHistoryInterfaceFactory
     */
    protected $historyFactory;

    /**
     * @var StatusResolver
     */
    protected $statusResolver;

    /**
     * @var Language
     */
    protected $language;

    /**
     * @var Currency
     */
    protected $currency;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var CountryIso
     */
    private $countryIso;

    /**
     * Helper constructor.
     * @param OrderFactory $orderFactory
     * @param OrderManagementInterface $orderManagement
     * @param OrderStatusHistoryInterfaceFactory $historyFactory
     * @param StatusResolver $statusResolver
     * @param Language $language
     * @param Currency $currency
     * @param Response $response
     */
    public function __construct(
        OrderFactory $orderFactory,
        OrderManagementInterface $orderManagement,
        OrderStatusHistoryInterfaceFactory $historyFactory,
        StatusResolver $statusResolver,
        Language $language,
        Currency $currency,
        Response $response,
        Session $session,
        CountryIso $countryIso
    ) {
        $this->orderFactory = $orderFactory;
        $this->orderManagement = $orderManagement;
        $this->historyFactory = $historyFactory;
        $this->statusResolver = $statusResolver;
        $this->language = $language;
        $this->currency = $currency;
        $this->response = $response;
        $this->session = $session;
        $this->countryIso = $countryIso;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language->getRedsysLanguage();
    }

    /**
     * @param $responseCode
     * @return string
     */
    public function messageResponse($responseCode)
    {
        return $this->response->messageResponse($responseCode);
    }

    /**
     * @param OrderInterface $order
     * @return string
     */
    public function getCurrency($order)
    {
        return $this->currency->getCurrency($order);
    }

    /**
     * @param OrderInterface $order
     * @param Phrase $comment
     */
    public function cancelOrder($order, $comment)
    {
        $this->orderManagement->cancel($order->getEntityId());

        $state = Order::STATE_CANCELED;
        $status = $this->getOrderStatusByState($order, $state);

        $this->addOrderComment($order, $comment, $status);

    }

    /**
     * @param OrderInterface $order
     * @param Phrase\ $comment
     * @param string $status
     * @param bool $notified
     */
    public function addOrderComment($order, $comment, $status, $notified = true)
    {
        $history = $this->historyFactory->create();
        $history->setParentId($order->getId())
            ->setComment($comment)
            ->setStatus($status)
            ->setEntityName('order')
            ->setIscustomerNotified($notified);

        try {
            $this->orderManagement->addComment($order->getEntityId(), $history);
        } catch (MailException $e) {
            // Fail quietly
        }
    }

    /**
     * @param OrderInterface $order
     * @param string $state
     * @return string
     */
    public function getOrderStatusByState($order, $state)
    {
        return $this->statusResolver->getOrderStatusByState($order, $state);
    }

    /**
     * @param int $incrementId
     * @return OrderInterface;
     * @throws LocalizedException
     */
    public function getOrderByIncrementId($incrementId)
    {
        $order = $this->orderFactory->create()->loadByIncrementId($incrementId);
        if (!$order->getId()) {
            throw new LocalizedException(__('The order no longer exists.'));
        }
        return $order;
    }

    /**
     * @param $order
     * @return array
     */
    public function generateMerchantEMV3DSData($order)
    {
        $billingAddress = $order->getBillingAddress();
        $shippingAddress = $order->getShippingAddress();

        if (!$shippingAddress) {
            $shippingAddress = $billingAddress;
        }

        $emv3dsData['cardholderName'] = $order->getData('customer_firstname') . ' ' . $order->getData('customer_lastname');
        $emv3dsData['Email'] = $order->getData('customer_email');

        // Shipping
        $emv3dsData['shipAddrLine1'] = $shippingAddress->getStreet(1);
        $emv3dsData['shipAddrLine2'] = $shippingAddress->getStreet(2);
        $emv3dsData['shipAddrCity'] = $shippingAddress->getCity();
        $emv3dsData['shipAddrPostCode'] = $shippingAddress->getPostcode();
        $emv3dsData['shipAddrCountry'] = $this->countryIso->getCountryNumericCode($shippingAddress->getCountryId());

        // Billing
        $emv3dsData['billAddrLine1'] = $billingAddress->getStreet(1);
        $emv3dsData['billAddrLine2'] = $billingAddress->getStreet(2);
        $emv3dsData['billAddrCity'] = $billingAddress->getCity();
        $emv3dsData['billAddrPostCode'] = $billingAddress->getPostcode();
        $emv3dsData['billAddrCountry'] = $this->countryIso->getCountryNumericCode($billingAddress->getCountryId());

        $emv3dsData['threeDSRequestorAuthenticationInfo'] = '01';
        if($this->session->isLoggedIn()) {
            $emv3dsData['threeDSRequestorAuthenticationInfo'] = '02';
        }

        return $emv3dsData;
    }

}
