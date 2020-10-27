<?php
namespace Changi\PreLogin\Controller;

/**
 * Aureatelabs Custom router Controller Router
 */
class Router implements \Magento\Framework\App\RouterInterface
{
    /**
     * @var \Magento\Framework\App\ActionFactory
     */
    protected $actionFactory;

    /**
     * Response
     *
     * @var \Magento\Framework\App\ResponseInterface
     */
    protected $_response;

    protected $_customerSession;

    /**
     * @param \Magento\Framework\App\ActionFactory $actionFactory
     * @param \Magento\Framework\App\ResponseInterface $response
     */
    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Magento\Customer\Model\Session $customerSession
    ) {
        die('routerss');
        $this->actionFactory = $actionFactory;
        $this->_customerSession = $customerSession;
    }

    /**
     * @param \Magento\Framework\App\RequestInterface $request
     * @return \Magento\Framework\App\ActionInterface|void
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $identifier = explode('/', $request->getPathInfo());
        $openPages = [
            'customer',
            'contact',
            'about-porto-20',
            'blog'
        ];

        foreach ($openPages as $page) {
            if (in_array($page, $identifier)) return;
        }

        if(!$this->_customerSession->isLoggedIn()){
            $request->setModuleName('prelogin')
            ->setControllerName('prelogin')
            ->setActionName('index');
    
            return $this->actionFactory
                ->create('Magento\Framework\App\Action\Forward', ['request' => $request]);
        }      
    }
}