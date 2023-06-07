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

class Delete implements HttpPostActionInterface
{
    private RequestInterface $request;
    private DeleteQuoteDescriptionByIdInterface $deleteQuoteDescriptionById;
    private ResultFactory $resultFactory;
    private Url $url;
    private MaskedQuoteIdToQuoteId $maskedQuoteIdToQuoteId;

    public function __construct(
        RequestInterface                    $request,
        DeleteQuoteDescriptionByIdInterface $deleteQuoteDescriptionById,
        ResultFactory                       $resultFactory,
        Url $url,
        MaskedQuoteIdToQuoteId $maskedQuoteIdToQuoteId,
    ) {
        $this->request = $request;
        $this->deleteQuoteDescriptionById = $deleteQuoteDescriptionById;
        $this->resultFactory = $resultFactory;
        $this->url = $url;
        $this->maskedQuoteIdToQuoteId = $maskedQuoteIdToQuoteId;
    }

    /**
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        $entityId = $this->maskedQuoteIdToQuoteId->execute($this->request->getParam('entity_id'));
        $this->deleteQuoteDescriptionById->execute($entityId);
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl($this->url->getUrl('mdnsavecart/customer'));
        return $redirect;
    }
}
