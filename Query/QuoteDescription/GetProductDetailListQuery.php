<?php

namespace Maisondunet\SaveQuote\Query\QuoteDescription;

use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\MaskedQuoteIdToQuoteId;
use Magento\Quote\Model\Quote;
use Maisondunet\SaveQuote\Api\GetQuoteDescriptionProductInterface;

class GetProductDetailListQuery implements GetQuoteDescriptionProductInterface
{
    private CartRepositoryInterface $cartRepository;
    private MaskedQuoteIdToQuoteId $maskedQuoteIdToQuoteId;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        MaskedQuoteIdToQuoteId $maskedQuoteIdToQuoteId,
    ) {

        $this->cartRepository = $cartRepository;
        $this->maskedQuoteIdToQuoteId = $maskedQuoteIdToQuoteId;
    }

    public function execute(string $quoteMaskedId)
    {
        $this->cartRepository->get($this->maskedQuoteIdToQuoteId->execute($quoteMaskedId));
        return $quoteMaskedId->getAllItems();
    }
}
