<?php
/**
 * class file
 * 
 * @author Christian Reinecke <christian.reinecke@gameforge.com>
 */
namespace HtmlJson;

use Zend\Session\Container;

/**
 * Bootstrap class for this module
 */
class Module
{
    /* .. */
    
    public function onBootstrap($e)
    {
        // @link http://zend-framework-community.634137.n4.nabble.com/Disable-layout-with-Query-parameter-td4659897.html#a4659902
        $sharedManager = $e->getApplication()->getEventManager()->getSharedManager();
        $sharedManager->attach(
            'Zend\Mvc\Controller\AbstractActionController',
            'dispatch',
            function($e) {
                if ($e->getRequest()->isXmlHttpRequest()) {
                    // generally disables layouts for XHR requests
                    $viewModel = $e->getResult();
                    $viewModel->setTerminal(true);
                }
            }
        );
    }
}
