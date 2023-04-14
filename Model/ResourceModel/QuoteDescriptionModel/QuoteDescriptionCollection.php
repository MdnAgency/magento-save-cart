<?php

namespace Maisondunet\SaveQuote\Model\ResourceModel\QuoteDescriptionModel;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Maisondunet\SaveQuote\Model\QuoteDescriptionModel;
use Maisondunet\SaveQuote\Model\ResourceModel\QuoteDescriptionResource;

class QuoteDescriptionCollection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'quote_description_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(QuoteDescriptionModel::class, QuoteDescriptionResource::class);
    }
}
