<?php

namespace Maisondunet\SaveQuote\Api;

use Magento\Customer\Model\Customer;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\Data\CartItemInterface;
use Magento\Quote\Model\Quote;

interface RestoreCartInterface
{
    /**
     * Restore QuoteDescription Command.
     *
     * @api
     */

    /**
     * @param Customer $customer
     * @param Quote $savedCart
     * @return CartInterface
     */
    public function execute(Customer $customer, int $quoteDescriptionId): CartInterface;
}
