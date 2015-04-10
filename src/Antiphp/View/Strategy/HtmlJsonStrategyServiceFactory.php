<?php
namespace Antiphp\View\Strategy;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class HtmlJsonStrategyServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceManager)
    {
        return new HtmlJsonStrategy(
            $serviceManager->get('htmlJsonRenderer')
        );
    }
}