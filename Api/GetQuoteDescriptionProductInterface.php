<?php

namespace Maisondunet\SaveQuote\Api;

use Magento\Quote\Model\Quote;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;

interface GetQuoteDescriptionProductInterface
{
    public function execute(Quote $quote);
}
