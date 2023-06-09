<?php

namespace Maisondunet\SaveQuote\Query\QuoteDescription;

use Magento\Quote\Model\Quote;
use Maisondunet\SaveQuote\Api\GetQuoteDescriptionProductInterface;

class GetProductDetailListQuery implements GetQuoteDescriptionProductInterface
{
    public function execute(Quote $quote)
    {
        return $quote->getAllItems();
    }
}
