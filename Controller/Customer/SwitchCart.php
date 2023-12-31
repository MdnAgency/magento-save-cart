<?php

namespace Maisondunet\SaveQuote\Controller\Customer;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\Manager;
use Magento\Framework\Url;
use Magento\Quote\Api\CartRepositoryInterface;
use Maisondunet\SaveQuote\Command\QuoteDescription\RestoreCartCommand;
use Maisondunet\SaveQuote\Query\QuoteDescription\QuoteDescriptionIdToQuoteId;

class SwitchCart implements HttpPostActionInterface
{
    private RequestInterface $request;
    private Session $session;
    private CartRepositoryInterface $cartRepository;
    private ResultFactory $resultFactory;
    private Manager $manager;
    private Url $url;
    private RestoreCartCommand $restoreCartCommand;
    private QuoteDescriptionIdToQuoteId $quoteId;

    public function __construct(
        RequestInterface                  $request,
        Session                           $session,
        CartRepositoryInterface           $cartRepository,
        ResultFactory                     $resultFactory,
        Manager                           $manager,
        RestoreCartCommand  $restoreCartCommand,
        Url $url,
        QuoteDescriptionIdToQuoteId $quoteId
    ) {
        $this->request = $request;
        $this->session = $session;
        $this->cartRepository = $cartRepository;
        $this->resultFactory = $resultFactory;
        $this->manager = $manager;
        $this->url = $url;
        $this->restoreCartCommand = $restoreCartCommand;
        $this->quoteId = $quoteId;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function execute(): Redirect
    {
        $customer = $this->session->getCustomer();
        $quoteDescriptionId = $this->request->getParam('id');
        $quoteId = $this->quoteId->execute($quoteDescriptionId);
        try {
            if ($customer != null) {

                //Get selected inactive quote
                $savedCart = $this->cartRepository->get($quoteId);

                $this->restoreCartCommand->execute($customer, $savedCart);
            }
        } catch (LocalizedException $exception) {
            $this->manager->addErrorMessage($exception->getMessage());
        }
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl($this->url->getUrl("checkout/cart"));
        return $redirect;
    }
}
