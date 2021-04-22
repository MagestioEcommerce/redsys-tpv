<?php

namespace Magestio\Redsys\Controller\KoResult;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Checkout\Model\Session;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magestio\Redsys\Helper\Helper;
use Magestio\Redsys\Logger\Logger;

/**
 * Class Index
 * @package Magestio\Redsys\Controller\KoResult
 */
class Index extends Action
{

    /**
     * @var Session
     */
    protected $checkoutSession;

    /**
     * @var CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var OrderInterface;
     */
    protected $order = null;

    /**
     * Index constructor.
     * @param Context $context
     * @param Session $checkoutSession
     * @param CartRepositoryInterface $quoteRepository
     * @param Helper $helper
     * @param Logger $logger
     */
	public function __construct(
		Context $context,
        Session $checkoutSession,
        CartRepositoryInterface $quoteRepository,
        Helper $helper,
        Logger $logger
    ) {
        parent::__construct($context);
        $this->checkoutSession = $checkoutSession;
        $this->quoteRepository = $quoteRepository;
        $this->helper = $helper;
        $this->logger = $logger;
    }

    public function execute()
    {
        $order = $this->getOrder();
        $this->helper->cancelOrder($order, __('Order canceled.'));
        $this->recoveryCart($order);
        $this->messageManager->addErrorMessage(__('We are sorry, something was wrong with payment. Try again or select another payment method.'));
        $this->_redirect('checkout/cart');
    }

    /**
     * @return OrderInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getOrder()
    {
        if (is_null($this->order)) {
            $orderId = $this->getRequest()->getParam('order_id');
            $this->order = $this->helper->getOrderByIncrementId($orderId);
        }
        return $this->order;
    }

    /**
     * @param OrderInterface $order
     */
    private function recoveryCart($order)
    {
        if ($order->getEntityId()) {
            try {
                $quote = $this->quoteRepository->get($order->getQuoteId());
                $quote->setIsActive(1)->setReservedOrderId(null);
                $this->quoteRepository->save($quote);
                $this->checkoutSession->replaceQuote($quote)->unsLastRealOrderId();
            } catch (NoSuchEntityException $e) {
                $this->logger->critical($e->getMessage());
            }
        }
    }

}