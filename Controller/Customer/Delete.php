<?php

namespace Maisondunet\SaveQuote\Controller\Customer;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Url;
use Magento\Quote\Model\MaskedQuoteIdToQuoteId;
use Magento\Quote\Model\QuoteIdToMaskedQuoteIdInterface;
use Maisondunet\SaveQuote\Api\DeleteQuoteDescriptionByIdInterface;
use Maisondunet\SaveQuote\Query\QuoteDescription\QuoteDescriptionIdToQuoteId;

class Delete implements HttpPostActionInterface
{
    private RequestInterface $request;
    private DeleteQuoteDescriptionByIdInterface $deleteQuoteDescriptionById;
    private ResultFactory $resultFactory;
    private Url $url;
    private QuoteDescriptionIdToQuoteId $quoteId;

    public function __construct(
        RequestInterface                    $request,
        DeleteQuoteDescriptionByIdInterface $deleteQuoteDescriptionById,
        ResultFactory                       $resultFactory,
        QuoteDescriptionIdToQuoteId $quoteId,
        Url $url,
    ) {
        $this->request = $request;
        $this->deleteQuoteDescriptionById = $deleteQuoteDescriptionById;
        $this->resultFactory = $resultFactory;
        $this->url = $url;
        $this->quoteId = $quoteId;
    }

    /**
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        $quoteDescriptionId = $this->request->getParam('entity_id');
        $this->deleteQuoteDescriptionById->execute($this->quoteId->execute($quoteDescriptionId));
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl($this->url->getUrl('mdnsavecart/customer'));
        return $redirect;
    }
}
