<?php
namespace Changi\PreLogin\Controller\PreLogin;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    protected $_resultRedirectFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context
    ) {
        $this->_resultRedirectFactory = $context->getResultFactory();
        return parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->_resultRedirectFactory
                            ->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);     
        $resultRedirect->setUrl('pre-login');

        return $resultRedirect;
    }
}