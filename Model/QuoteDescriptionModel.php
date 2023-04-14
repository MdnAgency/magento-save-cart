<?php

namespace Maisondunet\SaveQuote\Model;

use Magento\Framework\Model\AbstractModel;
use Maisondunet\SaveQuote\Model\ResourceModel\QuoteDescriptionResource;

class QuoteDescriptionModel extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'quote_description_model';

    /**
     * Initialize magento model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(QuoteDescriptionResource::class);
    }
}
