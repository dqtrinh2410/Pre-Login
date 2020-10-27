<?php
namespace Changi\PreLogin\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Controller\ResultFactory;

class CheckLoginObserver implements ObserverInterface
{

    /**
     * @var \Magento\Framework\App\Response\RedirectInterface
     */
    protected $_redirect;

    /**
     * Customer session
     *
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

    protected $_http;

    protected $_url;

    protected $_responeseFactory;

    protected $_logger;

    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\UrlInterface $url,
        \Magento\Framework\App\Response\Http $http,
        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->_customerSession = $customerSession;
        $this->_http = $http;
        $this->_url = $url;
        $this->_responeseFactory = $responseFactory;
        $this->_logger= $logger;
    }

    public function execute(Observer $observer)
    {
        $actionName = $observer->getEvent()->getRequest()->getFullActionName();
        $controller = $observer->getControllerAction();

        $openActions = array(
            'customer_account_login',
            'customer_account_loginPost',
            'customer_account_index',
            'customer_account_create',
            'blog_index_index',
            'contact_index_index',
            'blog_post_view'
        );

        if(in_array($actionName, $openActions)) {
            return $this;
        }

        if(!$this->_customerSession->isLoggedIn()) {
            if($actionName != 'cms_page_view') {
                $this->_http->setRedirect($this->_url->getUrl('pre-login'), 301);
            }
        }
        else {
            return;
        }
    }
}