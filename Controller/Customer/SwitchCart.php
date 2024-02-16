<?php

namespace Maisondunet\SaveQuote\Controller\Customer;

use Magento\Customer\Controller\AccountInterface;
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
use Maisondunet\SaveQuote\Model\NotAuthorizedException;
use Maisondunet\SaveQuote\Query\QuoteDescription\QuoteDescriptionIdToQuoteId;

class SwitchCart implements HttpPostActionInterface, AccountInterface
{
    private RequestInterface $request;
    private Session $session;
    private ResultFactory $resultFactory;
    private Manager $manager;
    private Url $url;
    private RestoreCartCommand $restoreCartCommand;

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
        $this->resultFactory = $resultFactory;
        $this->manager = $manager;
        $this->url = $url;
        $this->restoreCartCommand = $restoreCartCommand;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        $customer = $this->session->getCustomer();
        $quoteDescriptionId = (int) $this->request->getParam('id');
        try {
            $this->restoreCartCommand->execute($customer, $quoteDescriptionId);
            $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $redirect->setUrl($this->url->getUrl("checkout/cart"));
            return $redirect;
        } catch (LocalizedException $exception) {
            $this->manager->addErrorMessage($exception->getMessage());
        }
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $redirect->setUrl($this->url->getUrl('*/*'));
    }
}
