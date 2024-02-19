<?php

namespace Maisondunet\SaveQuote\Block;

use Magento\Framework\View\Element\Template;
use Maisondunet\SaveQuote\ViewModel\CurrentCart;

class PopupForm extends Template
{
    private CurrentCart $currentCart;

    public function __construct(
        CurrentCart $currentCart,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->currentCart = $currentCart;
    }
}
