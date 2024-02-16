<?php

namespace Maisondunet\SaveQuote\Controller\Customer;

use Magento\Customer\Controller\AccountInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\Manager as MessageManager;
use Magento\Framework\Url;
use Magento\Quote\Model\MaskedQuoteIdToQuoteId;
use Magento\Quote\Model\QuoteIdToMaskedQuoteIdInterface;
use Maisondunet\SaveQuote\Api\DeleteQuoteDescriptionByIdInterface;
use Maisondunet\SaveQuote\Query\QuoteDescription\QuoteDescriptionIdToQuoteId;

class Delete implements HttpPostActionInterface, AccountInterface
{
    private RequestInterface $request;
    private DeleteQuoteDescriptionByIdInterface $deleteQuoteDescriptionById;
    private ResultFactory $resultFactory;
    private Url $url;
    private QuoteDescriptionIdToQuoteId $quoteId;
    private MessageManager $messageManager;
    private RedirectFactory $redirectFactory;

    public function __construct(
        RequestInterface                    $request,
        DeleteQuoteDescriptionByIdInterface $deleteQuoteDescriptionById,
        ResultFactory                       $resultFactory,
        MessageManager                      $messageManager,
        QuoteDescriptionIdToQuoteId         $quoteId,
        Url                                 $url,
        RedirectFactory                     $redirectFactory
    )
    {
        $this->request = $request;
        $this->deleteQuoteDescriptionById = $deleteQuoteDescriptionById;
        $this->resultFactory = $resultFactory;
        $this->url = $url;
        $this->quoteId = $quoteId;
        $this->messageManager = $messageManager;
        $this->redirectFactory = $redirectFactory;
    }

    /**
     * @return Redirect
     */
    public function execute()
    {
        try {
            $quoteDescriptionId = (int) $this->request->getParam('id');
            $this->deleteQuoteDescriptionById->execute($quoteDescriptionId);
            $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $redirect->setUrl($this->url->getUrl('mdnsavecart/customer'));
            return $redirect;
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $resultRedirect = $this->redirectFactory->create();
            return $resultRedirect->setUrl($this->url->getUrl('*/*'));
        }
    }
}
