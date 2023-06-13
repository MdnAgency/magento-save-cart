<?php

namespace Maisondunet\SaveQuote\Block;

use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template;


class SaveQuote extends Template
{
    private Session $session;


    public function __construct(
        Template\Context $context,
        Session          $session,
        array            $data = []
    ) {
        parent::__construct($context, $data);
        $this->session = $session;
    }

    public function userIsLoggedIn(): bool
    {
        return $this->session->isLoggedIn();
    }
}
