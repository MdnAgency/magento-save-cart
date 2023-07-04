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
     * @param  int $quoteId
     * @return \Magento\Quote\Api\Data\CartItemInterface[]
     */
    public function execute(int $quoteId);
}
