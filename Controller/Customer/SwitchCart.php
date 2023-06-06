<?php

namespace Maisondunet\SaveQuote\Controller\Customer;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\Manager;
use Magento\Framework\Url;
use Magento\Framework\View\Result\PageFactory;
use Magento\Quote\Api\CartManagementInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\QuoteFactory;
use Magento\Quote\Model\QuoteRepository;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;
use Maisondunet\SaveQuote\Command\QuoteDescription\RestoreCartCommand;
use Maisondunet\SaveQuote\Model\ResourceModel\QuoteDescriptionModel\QuoteDescriptionCollectionFactory;

class SwitchCart implements HttpPostActionInterface
{
    private RequestInterface $request;
    private Session $session;
    private CartManagementInterface $cartManagement;
    private CartRepositoryInterface $cartRepository;
    private ResultFactory $resultFactory;
    private QuoteDescriptionCollectionFactory $collectionFactory;
    private Manager $manager;
    private PageFactory $pageFactory;
    private Url $url;
    private RestoreCartCommand $restoreCartCommand;
    private QuoteRepository $quoteRepository;
    private QuoteFactory $quoteFactory;

    public function __construct(
        RequestInterface                  $request,
        Session                           $session,
        CartManagementInterface           $cartManagement,
        CartRepositoryInterface           $cartRepository,
        ResultFactory                     $resultFactory,
        QuoteDescriptionCollectionFactory $collectionFactory,
        Manager                           $manager,
        PageFactory                       $pageFactory,
        RestoreCartCommand  $restoreCartCommand,
        Url $url,
        QuoteRepository $quoteRepository,
        QuoteFactory $quoteFactory,
    ) {
        $this->request = $request;
        $this->session = $session;
        $this->cartManagement = $cartManagement;
        $this->cartRepository = $cartRepository;
        $this->resultFactory = $resultFactory;
        $this->collectionFactory = $collectionFactory;
        $this->manager = $manager;
        $this->pageFactory = $pageFactory;
        $this->url = $url;
        $this->restoreCartCommand = $restoreCartCommand;

        $this->quoteRepository = $quoteRepository;
        $this->quoteFactory = $quoteFactory;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        $customer = $this->session->getCustomer();
        try {
            if ($customer != null) {

                //Get selected inactive quote
                $savedCart = $this->cartRepository->get($this->request->getParam('quote_id'));

                $merge = $this->restoreCartCommand->execute($customer, $savedCart);
            }
        } catch (LocalizedException $exception) {
            $this->manager->addErrorMessage($exception->getMessage());
        }
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl($this->url->getUrl("checkout/cart"));
        return $redirect;
    }

    private function checkIfCurrentCartIsAlreadySave(CartInterface $currentQuote): bool
    {
        $collection = $this->collectionFactory->create();

        if (null === $collection->addFilter(
            QuoteDescriptionInterface::QUOTE_ID,
            $currentQuote->getId()
        )) {
            return false;
        }
        return true;
    }

    /**
     * @return ResultInterface
     */
    private function displayPopup(): ResultInterface
    {
//        $resultPage = $this->pageFactory->create();
//        $resultPage->getConfig()->getTitle()->prepend(__('heading'));
//
//        $block = $resultPage->getLayout()
//            ->createBlock('Maisondunet\SaveQuote\Block\SaveQuote')
//            ->setTemplate('Maisondunet_SaveQuote::PopupForm.phtml')
//            ->toHtml();
//
//        $this->getResponse()->setBody($block);
        return $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);
    }
}
