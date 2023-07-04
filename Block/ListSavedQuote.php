<?php

namespace Maisondunet\SaveQuote\Block;

use Magento\Customer\Model\Session;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Url;
use Magento\Framework\View\Element\Template;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionSearchResultsInterface;
use Maisondunet\SaveQuote\Api\GetQuoteDescriptionListInterface;

class ListSavedQuote extends Template
{
    private Session $session;
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private FilterBuilder $filter;
    private GetQuoteDescriptionListInterface $list;
    private PriceCurrencyInterface $priceCurrency;
    private PostHelper $postHelper;
    private Url $url;

    public function __construct(
        Template\Context $context,
        Session $customerSession,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        GetQuoteDescriptionListInterface $list,
        PriceCurrencyInterface           $priceCurrency,
        PostHelper $postHelper,
        Url $url,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->session = $customerSession;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filter = $filterBuilder;
        $this->list = $list;
        $this->priceCurrency = $priceCurrency;
        $this->postHelper = $postHelper;
        $this->url = $url;
    }

    public function getCustomerSavedCartList(): ?QuoteDescriptionSearchResultsInterface
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

    public function getFormatedPrice(Float $amount): string
    {
        return $this->priceCurrency->convertAndFormat($amount);
    }

    public function getAddActivePostData(QuoteDescriptionInterface $item): string
    {
        return $this->postHelper->getPostData('/mdnsavecart/customer/switchcart', [
            "quote_id" => $item->getQuoteDescriptionId()
        ]);
    }

    public function getAddDeletePostData(QuoteDescriptionInterface $item): string
    {
        return $this->postHelper->getPostData('/mdnsavecart/customer/delete', [
            "entity_id" => $item->getQuoteDescriptionId()
        ]);
    }

    public function getAddViewProductDetail(string $quoteDescriptionId): string
    {
        return $this->url->getUrl('mdnsavecart/customer/view', [ "id" => $quoteDescriptionId]);
    }
}
