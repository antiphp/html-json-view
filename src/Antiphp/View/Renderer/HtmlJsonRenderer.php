<?php
namespace Antiphp\View\Renderer;

use Antiphp\View\Model\HtmlJsonModel;
use Zend\View\Model\JsonModel;
use Zend\View\Renderer\JsonRenderer;
use Zend\View\Resolver\ResolverInterface;
use Zend\View\Renderer\TreeRendererInterface;
use Zend\View\Renderer\RendererInterface;

class HtmlJsonRenderer implements RendererInterface, TreeRendererInterface
{
    private $htmlRenderer;
    private $jsonRenderer;
    private $resolver;
    
    public function __construct(RendererInterface $htmlRenderer, JsonRenderer $jsonRenderer)
    {
        $this->htmlRenderer = $htmlRenderer;
        $this->jsonRenderer = $jsonRenderer;
    }
    
    public function getEngine()
    {
        return $this;
    }
    
    public function setResolver(ResolverInterface $resolver)
    {
        $this->htmlRenderer->setResolver($resolver);
        $this->jsonRenderer->setResolver($resolver);
    }
    
    public function render($htmlJsonModel, $values = null)
    {
        if (!$htmlJsonModel instanceof HtmlJsonModel) {
            // wrong model
            return;
        }
        
        $html = $this->htmlRenderer->render($htmlJsonModel, $values);
        
        $json = array('html' => $html);
        $jsonModel = new JsonModel($json);
        
        $json = $this->jsonRenderer->render($jsonModel, $values);
        
        return $json;
    }
    
    public function canRenderTrees()
    {
        return $this->jsonRenderer->canRenderTrees();
    }
}