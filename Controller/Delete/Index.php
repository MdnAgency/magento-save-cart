<?php

namespace Maisondunet\SaveQuote\Controller\Delete;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Maisondunet\SaveQuote\Api\DeleteQuoteDescriptionByIdInterface;

class Index implements HttpPostActionInterface
{
    private RequestInterface $request;
    private DeleteQuoteDescriptionByIdInterface $deleteQuoteDescriptionById;
    private ResultFactory $resultFactory;

    public function __construct(
        RequestInterface                    $request,
        DeleteQuoteDescriptionByIdInterface $deleteQuoteDescriptionById,
        ResultFactory                       $resultFactory,
    ) {
        $this->request = $request;
        $this->deleteQuoteDescriptionById = $deleteQuoteDescriptionById;
        $this->resultFactory = $resultFactory;
    }

    public function execute()
    {
        $this->deleteQuoteDescriptionById->execute($this->request->getParam('entity_id'));
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl('https://app.test-magento.test/checkout/cart');
        return $redirect;
    }
}
