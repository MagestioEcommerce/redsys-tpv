<?php

namespace Magestio\Redsys\Controller\Redirect;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Checkout\Model\Session;
use Magento\Sales\Api\OrderRepositoryInterface;

/**
 * Class Index
 * @package Magestio\Redsys\Controller\Redirect
 */
class Index implements HttpGetActionInterface
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * Index constructor.
     * @param PageFactory $resultPageFactory
     * @param Session $session
     * @param OrderRepositoryInterface $orderRepository
     */
	public function __construct(
        PageFactory $resultPageFactory,
        Session $session,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->session = $session;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $order = $this->session->getLastRealOrder();

        $order->setState('new')->setStatus('pending_payment');
        $order->addCommentToStatusHistory(__('Customer redirected to Redsys Payment Gateway'), false)
            ->setIsCustomerNotified(false);
        $this->orderRepository->save($order);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__("Redirecting..."));
        return $resultPage;
    }

}
