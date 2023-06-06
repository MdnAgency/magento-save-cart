<?php

namespace Maisondunet\SaveQuote\Block;

use Magento\Customer\Model\Session;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\View\Element\Template;
use Magento\Quote\Api\CartManagementInterface;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionSearchResultsInterface;
use Maisondunet\SaveQuote\Api\GetQuoteDescriptionListInterface;

class SaveQuote extends Template
{
    private Session $session;
    private CartManagementInterface $cartManagement;

    private GetQuoteDescriptionListInterface $list;
    private FilterBuilder $filter;
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private RequestInterface $request;
    private FilterGroup $filterGroup;
    private PriceCurrencyInterface $priceCurrency;

    public function __construct(
        Template\Context                 $context,
        Session                          $session,
        CartManagementInterface          $cartManagement,
        GetQuoteDescriptionListInterface $list,
        FilterBuilder                    $filter,
        FilterGroup                      $filterGroup,
        SearchCriteriaBuilder            $searchCriteriaBuilder,
        RequestInterface                 $request,
        PriceCurrencyInterface           $priceCurrency,
        array                            $data = []
    ) {
        parent::__construct($context, $data);
        $this->session = $session;
        $this->cartManagement = $cartManagement;
        $this->list = $list;
        $this->filter = $filter;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->request = $request;
        $this->filterGroup = $filterGroup;
        $this->priceCurrency = $priceCurrency;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getActiveQuote(): int
    {
        $cart = $this->cartManagement->getCartForCustomer($this->session->getCustomerId());
        return $cart->getId();
    }

    public function getCustomerSaveCart(): ?QuoteDescriptionSearchResultsInterface
    {
        $customer = $this->session->getCustomer();

        if ($customer != null) {
            $filter1 = $this->filter
                ->setField('customer_id')
                ->setValue($customer->getId())
                ->create();

            $this->searchCriteriaBuilder->addFilters([$filter1]);
            $searchCriteria = $this->searchCriteriaBuilder->create();

            return $this->list->execute($searchCriteria);
        }
        return null;
    }

    /**
     * Function getFormatedPrice
     *
     * @param Float $amount
     * @return string
     */
    public function getFormatedPrice(Float $amount): string
    {
        return $this->priceCurrency->convertAndFormat($amount);
    }
}
