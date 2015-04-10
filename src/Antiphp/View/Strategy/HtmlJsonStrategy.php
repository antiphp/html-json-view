<?php
namespace Antiphp\View\Strategy;

use Antiphp\View\Model\HtmlJsonModel;
use Antiphp\View\Renderer\HtmlJsonRenderer;
use Zend\View\ViewEvent;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\AbstractListenerAggregate;

class HtmlJsonStrategy extends AbstractListenerAggregate
{
    private $renderer;
    
    public function __construct(HtmlJsonRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RENDERER, array($this, 'selectRenderer'), $priority);
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RESPONSE, array($this, 'injectResponse'), $priority);
    }
    
    public function selectRenderer(ViewEvent $e)
    {
        $model = $e->getModel();
        if (!$model instanceof HtmlJsonModel) {
            return;
        }
        $request = $e->getRequest();
        if (!$request->isXmlHttpRequest()) {
            return;
        }
        return $this->renderer;
    }

    public function injectResponse(ViewEvent $e)
    {
        $renderer = $e->getRenderer();
        if ($renderer !== $this->renderer) {
            return;
        }

        $result = $e->getResult();
        if (!is_string($result)) {
            return;
        }
        
        // Populate response
        $response = $e->getResponse();
        $response->setContent($result);
        $headers = $response->getHeaders();

        $contentType = 'application/json';
        $contentType .= '; charset=utf-8';
        $headers->addHeaderLine('content-type', $contentType);
    }
}