<?php

namespace Maisondunet\SaveQuote\Model\Button;

use Magento\Framework\Data\Helper\PostHelper;
use Maisondunet\SaveQuote\Api\Button\ButtonActionInterface;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;

class ButtonActionRestore implements ButtonActionInterface
{
    private PostHelper $postHelper;

    public function __construct(
        PostHelper $postHelper
    ) {
        $this->postHelper = $postHelper;
    }

    public function createAction(QuoteDescriptionInterface $quoteDescription): string
    {
        return $this->postHelper->getPostData('/mdnsavecart/customer/switchcart', [
            "id" => $quoteDescription->getQuoteDescriptionId()
        ]);
    }

    public function isPost(): bool
    {
        return true;
    }
}
