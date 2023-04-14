<?php

namespace Maisondunet\SaveQuote\Command\QuoteDescription;

use Exception;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\QuoteRepository;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;
use Maisondunet\SaveQuote\Api\DeleteQuoteDescriptionByIdInterface;
use Maisondunet\SaveQuote\Model\QuoteDescriptionModel;
use Maisondunet\SaveQuote\Model\QuoteDescriptionModelFactory;
use Maisondunet\SaveQuote\Model\ResourceModel\QuoteDescriptionResource;
use Psr\Log\LoggerInterface;

/**
 * Delete QuoteDescription by id Command.
 */
class DeleteByIdCommand implements DeleteQuoteDescriptionByIdInterface
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var QuoteDescriptionModelFactory
     */
    private QuoteDescriptionModelFactory $modelFactory;

    /**
     * @var QuoteDescriptionResource
     */
    private QuoteDescriptionResource $resource;
    private QuoteRepository $quoteRepository;
    private CartRepositoryInterface $cartRepository;

    /**
     * @param LoggerInterface $logger
     * @param QuoteDescriptionModelFactory $modelFactory
     * @param QuoteDescriptionResource $resource
     * @param QuoteRepository $quoteRepository
     * @param CartRepositoryInterface $cartRepository
     */
    public function __construct(
        LoggerInterface              $logger,
        QuoteDescriptionModelFactory $modelFactory,
        QuoteDescriptionResource     $resource,
        QuoteRepository $quoteRepository,
        CartRepositoryInterface $cartRepository,
    ) {
        $this->logger = $logger;
        $this->modelFactory = $modelFactory;
        $this->resource = $resource;
        $this->quoteRepository = $quoteRepository;
        $this->cartRepository = $cartRepository;
    }

    /**
     * @inheritDoc
     */
    public function execute(int $entityId): void
    {
        try {
            /** @var QuoteDescriptionModel $model */
            $model = $this->modelFactory->create();
            $this->resource->load($model, $entityId, QuoteDescriptionInterface::QUOTE_DESCRIPTION_ID);

            if (!$model->getData(QuoteDescriptionInterface::QUOTE_DESCRIPTION_ID)) {
                throw new NoSuchEntityException(
                    __(
                        'Could not find QuoteDescription with id: `%id`',
                        [
                            'id' => $entityId
                        ]
                    )
                );
            }

            $this->resource->delete($model);
        } catch (Exception $exception) {
            $this->logger->error(
                __('Could not delete QuoteDescription. Original message: {message}'),
                [
                    'message' => $exception->getMessage(),
                    'exception' => $exception
                ]
            );
            throw new CouldNotDeleteException(__('Could not delete QuoteDescription.'));
        }
    }
}
