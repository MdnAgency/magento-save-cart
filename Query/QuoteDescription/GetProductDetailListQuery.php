<?php

namespace Maisondunet\SaveQuote\Query\QuoteDescription;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Maisondunet\SaveQuote\Api\GetQuoteDescriptionProductInterface;

class GetProductDetailListQuery implements GetQuoteDescriptionProductInterface
{
    private CartRepositoryInterface $cartRepository;

    public function __construct(
        CartRepositoryInterface $cartRepository
    ) {
        $this->cartRepository = $cartRepository;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function execute(int $quoteId)
    {
        $quote = $this->cartRepository->get($quoteId);
        return $quote->getAllItems();
    }
}
