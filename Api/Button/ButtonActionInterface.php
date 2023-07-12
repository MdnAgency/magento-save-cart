<?php

namespace Maisondunet\SaveQuote\Api\Button;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;

interface ButtonActionInterface extends ArgumentInterface
{
    public function createAction(QuoteDescriptionInterface $quoteDescription): string;

    public function isPost(): bool;
}
