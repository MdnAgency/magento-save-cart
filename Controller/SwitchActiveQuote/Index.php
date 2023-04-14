<?php

namespace Maisondunet\SaveQuote\Controller\SwitchActiveQuote;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\Manager;
use Magento\Quote\Api\CartManagementInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\CartInterface;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;
use Maisondunet\SaveQuote\Model\ResourceModel\QuoteDescriptionModel\QuoteDescriptionCollectionFactory;

class Index implements HttpPostActionInterface
{
    private RequestInterface $request;
    private Session $session;
    private CartManagementInterface $cartManagement;
    private CartRepositoryInterface $cartRepository;
    private ResultFactory $resultFactory;
    private QuoteDescriptionCollectionFactory $collectionFactory;
    private Manager $manager;

    public function __construct(
        RequestInterface                  $request,
        Session                           $session,
        CartManagementInterface           $cartManagement,
        CartRepositoryInterface           $cartRepository,
        ResultFactory                     $resultFactory,
        QuoteDescriptionCollectionFactory $collectionFactory,
        Manager $manager,
    ) {
        $this->request = $request;
        $this->session = $session;
        $this->cartManagement = $cartManagement;
        $this->cartRepository = $cartRepository;
        $this->resultFactory = $resultFactory;
        $this->collectionFactory = $collectionFactory;
        $this->manager = $manager;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        $customer = $this->session->getCustomer();

        if ($customer != null) {

            //Get current quote
            $currentQuote = $this->cartManagement->getCartForCustomer($customer->getId());
            try {
                if ($this->checkIfCurrentCartIsAlreadySave($currentQuote)) {
                    throw new LocalizedException(__('Your current cart is not save'));
                }
            } catch (LocalizedException $exception) {
                $this->manager->addErrorMessage($exception->getMessage());
            }

            //Get selected inactive quote
            $inactiveQuote = $this->cartRepository->get($this->request->getParam('quote_id'));

            //Switch

            $inactiveQuote->setIsActive(true);
            $this->cartRepository->save($inactiveQuote);

            $currentQuote->setIsActive(false);
            $this->cartRepository->save($currentQuote);

            $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $redirect->setUrl('https://app.test-magento.test/checkout/cart');
            return $redirect;
        }
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
}
