<?php

namespace Maisondunet\SaveQuote\Query\QuoteDescription;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionSearchResultsInterface;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionSearchResultsInterfaceFactory;
use Maisondunet\SaveQuote\Api\GetQuoteDescriptionListInterface;
use Maisondunet\SaveQuote\Mapper\QuoteDescriptionDataMapper;
use Maisondunet\SaveQuote\Model\ResourceModel\QuoteDescriptionModel\QuoteDescriptionCollection;
use Maisondunet\SaveQuote\Model\ResourceModel\QuoteDescriptionModel\QuoteDescriptionCollectionFactory;

/**
 * Get QuoteDescription list by search criteria query.
 */
class GetListQuery implements GetQuoteDescriptionListInterface
{
    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;

    /**
     * @var QuoteDescriptionCollectionFactory
     */
    private QuoteDescriptionCollectionFactory $entityCollectionFactory;

    /**
     * @var QuoteDescriptionDataMapper
     */
    private QuoteDescriptionDataMapper $entityDataMapper;

    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @var QuoteDescriptionSearchResultsInterfaceFactory
     */
    private QuoteDescriptionSearchResultsInterfaceFactory $searchResultFactory;

    /**
     * @param CollectionProcessorInterface $collectionProcessor
     * @param QuoteDescriptionCollectionFactory $entityCollectionFactory
     * @param QuoteDescriptionDataMapper $entityDataMapper
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param QuoteDescriptionSearchResultsInterfaceFactory $searchResultFactory
     */
    public function __construct(
        CollectionProcessorInterface                  $collectionProcessor,
        QuoteDescriptionCollectionFactory             $entityCollectionFactory,
        QuoteDescriptionDataMapper                    $entityDataMapper,
        SearchCriteriaBuilder                         $searchCriteriaBuilder,
        QuoteDescriptionSearchResultsInterfaceFactory $searchResultFactory
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->entityCollectionFactory = $entityCollectionFactory;
        $this->entityDataMapper = $entityDataMapper;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute(?SearchCriteriaInterface $searchCriteria = null): QuoteDescriptionSearchResultsInterface
    {

        /** @var QuoteDescriptionCollection $collection */
        $collection = $this->entityCollectionFactory->create();

        $collection->join(
            [
                'quote' => $collection->getTable('quote')
            ],
            'main_table.quote_id = quote.entity_id',
            [
                'items_count' => 'items_count',
                'grand_total' => 'grand_total'
            ]
        );

        $collection->addFilter('is_active', false);

        if ($searchCriteria === null) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        } else {
            $this->collectionProcessor->process($searchCriteria, $collection);
        }

        $entityDataObjects = $this->entityDataMapper->map($collection);

        /** @var QuoteDescriptionSearchResultsInterface $searchResult */
        $searchResult = $this->searchResultFactory->create();
        $searchResult->setItems($entityDataObjects);
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;
    }
}
