<?php

namespace Maisondunet\SaveQuote\Block;

use Magento\Customer\Model\Session;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderFactory;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Url;
use Magento\Framework\View\Element\Template;
use Magento\Quote\Api\CartRepositoryInterface;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionSearchResultsInterface;
use Maisondunet\SaveQuote\Api\GetQuoteDescriptionListInterface;
use Maisondunet\SaveQuote\Query\QuoteDescription\QuoteDescriptionIdToQuoteId;

class ListSavedQuote extends Template
{
    private Session $session;
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private FilterBuilder $filter;
    private GetQuoteDescriptionListInterface $list;
    private PriceCurrencyInterface $priceCurrency;
    private Url $url;
    private QuoteDescriptionIdToQuoteId $quoteId;
    private CartRepositoryInterface $cartRepository;
    private SortOrderFactory $sortOrderFactory;

    public function __construct(
        Template\Context                 $context,
        Session                          $customerSession,
        SearchCriteriaBuilder            $searchCriteriaBuilder,
        FilterBuilder                    $filterBuilder,
        GetQuoteDescriptionListInterface $list,
        PriceCurrencyInterface           $priceCurrency,
        Url                              $url,
        QuoteDescriptionIdToQuoteId      $quoteId,
        CartRepositoryInterface          $cartRepository,
        SortOrderFactory                 $sortOrderFactory,
        array                            $data = []
    )
    {
        parent::__construct($context, $data);
        $this->session = $customerSession;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filter = $filterBuilder;
        $this->list = $list;
        $this->priceCurrency = $priceCurrency;
        $this->quoteId = $quoteId;
        $this->cartRepository = $cartRepository;
        $this->url = $url;
        $this->sortOrderFactory = $sortOrderFactory;
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
            $this->searchCriteriaBuilder->setSortOrders([
                $this->sortOrderFactory->create([
                    "data" => [
                        SortOrder::FIELD => QuoteDescriptionInterface::CREATED_AT,
                        SortOrder::DIRECTION => SortOrder::SORT_DESC
                    ]
                ])
            ]);
            $searchCriteria = $this->searchCriteriaBuilder->create();

            return $this->list->execute($searchCriteria);
        }
        return null;
    }

    public function getFormatedPrice(float $amount): string
    {
        return $this->priceCurrency->convertAndFormat($amount);
    }

    /**
     * @deprecated
     * @param QuoteDescriptionInterface $item
     * @return string
     */
    public function getAddViewProductDetail(QuoteDescriptionInterface $item): string
    {
        return $this->url->getUrl('mdnsavecart/customer/view', ["id" => $item->getQuoteDescriptionId()]);
    }

    /**
     * Fetch quote content related to a given QuoteDescriptionInterface
     * (ie get the actual content of the persisted quote)
     * @param QuoteDescriptionInterface $quoteDescription
     * @return \Magento\Quote\Api\Data\CartInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getQuote(QuoteDescriptionInterface $quoteDescription)
    {
        $id = $quoteDescription->getQuoteDescriptionId();
        return $this->cartRepository->get($this->quoteId->execute($id));
    }
}
