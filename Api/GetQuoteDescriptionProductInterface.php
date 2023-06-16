<?php

namespace Maisondunet\SaveQuote\Api;

use Magento\Quote\Model\Quote;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;

/**
 * Get QuoteDescription product detail list.
 * @api
 */

interface GetQuoteDescriptionProductInterface
{
    /**
     * @param  Magento\Quote\Model\Quote $quote
     * @return mixed
     */
    public function execute(Quote $quote);
}
