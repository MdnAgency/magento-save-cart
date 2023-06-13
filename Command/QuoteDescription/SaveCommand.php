<?php

namespace Maisondunet\SaveQuote\Command\QuoteDescription;

use Exception;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Validation\ValidationException;
use Magento\Quote\Api\CartManagementInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\QuoteRepository;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;
use Maisondunet\SaveQuote\Api\SaveQuoteDescriptionInterface;
use Maisondunet\SaveQuote\Model\QuoteDescriptionModel;
use Maisondunet\SaveQuote\Model\QuoteDescriptionModelFactory;
use Maisondunet\SaveQuote\Model\ResourceModel\QuoteDescriptionResource;
use Psr\Log\LoggerInterface;

/**
 * Save QuoteDescription Command.
 */
class SaveCommand implements SaveQuoteDescriptionInterface
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

    /**
     * @var Session
     */
    private Session $session;

    /**
     * @var CartRepositoryInterface
     */
    private CartRepositoryInterface $cartRepository;
    private CartManagementInterface $cartManagement;
    private QuoteRepository $quoteRepository;
    private QuoteDescriptionFormValidation $formValidation;

    /**
     * @param LoggerInterface $logger
     * @param QuoteDescriptionModelFactory $modelFactory
     * @param QuoteDescriptionResource $resource
     * @param Session $session
     * @param CartRepositoryInterface $cartRepository
     * @param CartManagementInterface $cartManagement
     * @param QuoteRepository $quoteRepository
     */
    public function __construct(
        LoggerInterface              $logger,
        QuoteDescriptionModelFactory $modelFactory,
        QuoteDescriptionResource     $resource,
        Session                      $session,
        CartRepositoryInterface      $cartRepository,
        CartManagementInterface      $cartManagement,
        QuoteRepository              $quoteRepository,
        QuoteDescriptionFormValidation $formValidation,
    ) {
        $this->logger = $logger;
        $this->modelFactory = $modelFactory;
        $this->resource = $resource;
        $this->session = $session;
        $this->cartRepository = $cartRepository;
        $this->cartManagement = $cartManagement;
        $this->quoteRepository = $quoteRepository;
        $this->formValidation = $formValidation;
    }

    public function execute(QuoteDescriptionInterface $quoteDescription): int
    {
        try {
            $validationResult = $this->formValidation->validate($quoteDescription);
            if (!$validationResult->isValid()) {
                throw new ValidationException(
                    __('Validation error'),
                    null,
                    0,
                    $validationResult
                );
            }
            /** @var QuoteDescriptionModel $model */
            $model = $this->modelFactory->create();
            $model->addData($quoteDescription->getData());
            $model->setHasDataChanges(true);

            if (!$model->getData(QuoteDescriptionInterface::QUOTE_DESCRIPTION_ID)) {
                $model->isObjectNew(true);
            }

            // Fetch current customer cart
            $currentQuote = $this->getCustomerQuote();

            // Can user save current cart
            if ($this->checkForSave($currentQuote)) {
                // Disable current cart
                $currentQuote->setIsActive(false);
                $this->quoteRepository->save($currentQuote);
                // create new cart
                $this->cartManagement->createEmptyCartForCustomer($currentQuote->getCustomer()->getId());

                $connection = $this->resource->getConnection();
                $tableName = 'quote_description';
                $data = ['quote_id' => $quoteDescription->getQuoteId(), 'name' => $quoteDescription->getName(), 'description' => $quoteDescription->getDescription()];

                $connection->insertOnDuplicate($tableName, $data);
            } else {
                throw new LocalizedException(__('cart empty'));
            }
        } catch (Exception $exception) {
            if ($exception instanceof ValidationException) {
                throw $exception;
            }
            $this->logger->error(
                __('Could not save QuoteDescription. Original message: {message}'),
                [
                    'message' => $exception->getMessage(),
                    'exception' => $exception
                ]
            );
            throw new CouldNotSaveException(__('Could not save QuoteDescription.'));
        }

        return (int)$model->getData(QuoteDescriptionInterface::QUOTE_DESCRIPTION_ID);
    }


    /**
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    private function getCustomerQuote(): CartInterface
    {
        $customer = $this->session->getCustomerData();
        if ($customer === null) {
            throw new LocalizedException(__('Hello guest if you want to saved your cart you have to login'));
        }
        return $this->cartRepository->getActiveForCustomer($customer->getId(), [$customer->getStoreId()]);
    }

    private function checkForSave(CartInterface $cart): bool
    {
        if ($cart->getItemsQty() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
