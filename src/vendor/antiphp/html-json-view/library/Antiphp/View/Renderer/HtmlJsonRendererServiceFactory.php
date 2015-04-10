<?php
/**
 * class file
 * 
 * @author Christian Reinecke <christian.reinecke@gameforge.com>
 */
namespace Antiphp\View\Renderer;

use Antiphp\View\Renderer\HtmlJsonRenderer;
use Zend\View\Renderer\JsonRenderer;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class HtmlJsonRendererServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceManager)
    {
        return new HtmlJsonRenderer(
            $serviceManager->get('viewRenderer'), // PHP renderer
            new JsonRenderer()
        );
    }
}