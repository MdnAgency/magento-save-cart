<?php

namespace Maisondunet\SaveQuote\Command\QuoteDescription;

use Magento\Customer\Model\Customer;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartManagementInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\Quote;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterfaceFactory;
use Maisondunet\SaveQuote\Api\QuoteDescriptionAuthorizationInterface;
use Maisondunet\SaveQuote\Api\RestoreCartInterface;
use Maisondunet\SaveQuote\Model\NotAuthorizedException;
use Maisondunet\SaveQuote\Model\QuoteDescriptionModelFactory;
use Maisondunet\SaveQuote\Model\ResourceModel\QuoteDescriptionResource;

class RestoreCartCommand implements RestoreCartInterface
{
    private CartManagementInterface $cartManagement;
    private CartRepositoryInterface $cartRepository;
    private QuoteDescriptionModelFactory $modelFactory;
    private QuoteDescriptionResource $resource;
    private QuoteDescriptionInterfaceFactory $quoteDescriptionInterfaceFactory;
    private QuoteDescriptionAuthorizationInterface $quoteDescriptionAuthorization;

    public function __construct(
        QuoteDescriptionModelFactory $modelFactory,
        QuoteDescriptionResource     $resource,
        QuoteDescriptionInterfaceFactory $quoteDescriptionInterfaceFactory,
        CartRepositoryInterface $cartRepository,
        CartManagementInterface $cartManagement,
        QuoteDescriptionAuthorizationInterface $quoteDescriptionAuthorization,
    ) {
        $this->cartManagement = $cartManagement;
        $this->cartRepository = $cartRepository;
        $this->modelFactory = $modelFactory;
        $this->resource = $resource;
        $this->quoteDescriptionInterfaceFactory = $quoteDescriptionInterfaceFactory;
        $this->quoteDescriptionAuthorization = $quoteDescriptionAuthorization;
    }

    /**
     * @inheritDoc
     * @throws NoSuchEntityException|NotAuthorizedException
     */
    public function execute(Customer $customer, int $quoteDescriptionId): CartInterface
    {
        $model = $this->modelFactory->create();
        $this->resource->load($model, $quoteDescriptionId);

        if (!$model->getData(QuoteDescriptionInterface::QUOTE_ID)) {
            throw new NoSuchEntityException(
                __(
                    'Could not find QuoteDescription with id: `%id`',
                    [
                        'id' => $model
                    ]
                )
            );
        }

        $quoteDescription= $this->quoteDescriptionInterfaceFactory->create(["data" => $model->getData()]);
        if($this->quoteDescriptionAuthorization->canDelete($quoteDescription)) {
            $currentCart = $this->cartManagement->getCartForCustomer($customer->getId());

            //Get selected inactive quote
            $savedCart = $this->cartRepository->get($quoteDescription->getQuoteId());
            $merge = $currentCart->merge($savedCart);
            $this->cartRepository->save($merge);

            return $merge;
        } else {
            throw new NotAuthorizedException(__("Not allowed"));
        }







    }
}
