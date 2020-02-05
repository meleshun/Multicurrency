<?php
/**
 * Copyright © 2019 Cubo. All rights reserved.
 * See https://cubo.agency/
**/
namespace Cubo\Multicurrency\Controller\Adminhtml\Manufacturers;

class Index extends \Magento\Backend\App\Action {
    /**
    * @var \Magento\Framework\View\Result\PageFactory
    */
    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute() {
        return  $resultPage = $this->resultPageFactory->create();
    }
}