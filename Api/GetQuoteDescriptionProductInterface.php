<?php

namespace Maisondunet\SaveQuote\Api;


use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;

/**
 * Get QuoteDescription product detail list.
 * @api
 */

interface GetQuoteDescriptionProductInterface
{
    /**
     * @param  string $quoteMaskedId
     * @return \Magento\Quote\Api\Data\CartItemInterface[]
     */
    public function execute(string $quoteMaskedId);
}
