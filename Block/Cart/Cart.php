<?php

namespace Maisondunet\SaveQuote\Block\Cart;

use Magento\Checkout\Block\Cart as OrigCart;
use Magento\Quote\Model\Quote;

class Cart extends OrigCart
{
    public function unsetQuote(){
        $this->_quote = null;
        $this->_totals = null;
    }

    public function setQuote(?Quote $quote){
        $this->_quote = $quote;
        $this->_totals = null;
    }

}
