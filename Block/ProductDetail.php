<?php

namespace Maisondunet\SaveQuote\Block;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Template;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\MaskedQuoteIdToQuoteId;
use Magento\Quote\Model\Quote;
use Maisondunet\SaveQuote\Api\GetQuoteDescriptionProductInterface;

class ProductDetail extends Template
{
    private RequestInterface $request;
    private GetQuoteDescriptionProductInterface $getQuoteDescriptionProduct;
    private MaskedQuoteIdToQuoteId $maskedQuoteIdToQuoteId;
    private CartRepositoryInterface $cartRepository;

    public function __construct(
        Template\Context $context,
        RequestInterface $request,
        GetQuoteDescriptionProductInterface $getQuoteDescriptionProduct,
        MaskedQuoteIdToQuoteId $maskedQuoteIdToQuoteId,
        CartRepositoryInterface $cartRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->request = $request;
        $this->getQuoteDescriptionProduct = $getQuoteDescriptionProduct;
        $this->maskedQuoteIdToQuoteId = $maskedQuoteIdToQuoteId;
        $this->cartRepository = $cartRepository;
    }


    public function getSavedCartItem()
    {
        $quote = $this->getQuote();
        return $this->getQuoteDescriptionProduct->execute($quote);
    }

    /**
     * @return \Magento\Quote\Api\Data\CartInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getQuote(): \Magento\Quote\Api\Data\CartInterface
    {
        $quoteId = $this->maskedQuoteIdToQuoteId->execute($this->request->getParam('id'));
        $quote = $this->cartRepository->get($quoteId);
        return $quote;
    }
}
