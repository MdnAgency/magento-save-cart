<?php

namespace Maisondunet\SaveQuote\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;

class QuoteDescriptionResource extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'quote_description_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('quote_description', QuoteDescriptionInterface::QUOTE_DESCRIPTION_ID);
        $this->_useIsObjectNew = true;
    }
}
