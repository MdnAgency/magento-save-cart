<?php

namespace Maisondunet\SaveQuote\Block;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Template;
use Magento\Quote\Api\CartRepositoryInterface;
use Maisondunet\SaveQuote\Api\GetQuoteDescriptionProductInterface;
use Maisondunet\SaveQuote\Query\QuoteDescription\QuoteDescriptionIdToQuoteId;

class ProductDetail extends Template
{
    private RequestInterface $request;
    private GetQuoteDescriptionProductInterface $getQuoteDescriptionProduct;
    private CartRepositoryInterface $cartRepository;
    private QuoteDescriptionIdToQuoteId $quoteId;

    public function __construct(
        Template\Context $context,
        RequestInterface $request,
        GetQuoteDescriptionProductInterface $getQuoteDescriptionProduct,
        CartRepositoryInterface $cartRepository,
        QuoteDescriptionIdToQuoteId $quoteId,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->request = $request;
        $this->getQuoteDescriptionProduct = $getQuoteDescriptionProduct;
        $this->cartRepository = $cartRepository;
        $this->quoteId = $quoteId;
    }

    /**
     * @return \Magento\Quote\Api\Data\CartInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getQuote(): \Magento\Quote\Api\Data\CartInterface
    {
        $quoteDescriptionId = $this->request->getParam('id');
        return $this->cartRepository->get($this->quoteId->execute($quoteDescriptionId));
    }
}
