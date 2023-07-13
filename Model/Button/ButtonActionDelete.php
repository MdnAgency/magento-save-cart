<?php

namespace Maisondunet\SaveQuote\Model\Button;

use Magento\Framework\Data\Helper\PostHelper;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;

class ButtonActionDelete implements \Maisondunet\SaveQuote\Api\Button\ButtonActionInterface
{
    private PostHelper $postHelper;

    public function __construct(
        PostHelper $postHelper
    )
    {
        $this->postHelper = $postHelper;
    }

    public function createAction(QuoteDescriptionInterface $quoteDescription): string
    {
        return $this->postHelper->getPostData('/mdnsavecart/customer/delete', [
            "id" => $quoteDescription->getQuoteDescriptionId()
        ]);
    }

    public function isPost(): bool
    {
        return true;
    }
}
