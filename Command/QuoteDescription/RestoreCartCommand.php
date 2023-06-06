<?php

namespace Maisondunet\SaveQuote\Command\QuoteDescription;

use Magento\Customer\Model\Customer;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartManagementInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\Quote;
use Maisondunet\SaveQuote\Api\RestoreCartInterface;

class RestoreCartCommand implements RestoreCartInterface
{
    private CartManagementInterface $cartManagement;
    private CartRepositoryInterface $cartRepository;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        CartManagementInterface $cartManagement
    ) {
        $this->cartManagement = $cartManagement;
        $this->cartRepository = $cartRepository;
    }

    /**
     * @inheritDoc
     * @throws NoSuchEntityException
     */
    public function execute(Customer $customer, Quote $savedCart)
    {
        $currentCart = $this->cartManagement->getCartForCustomer($customer->getId());

        $merge = $currentCart->merge($savedCart);

        $this->cartRepository->save($merge);

        return $merge;
    }
}
