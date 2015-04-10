<?php
/**
 * class file
 * 
 * @author Christian Reinecke <christian.reinecke@web.de>
 */
namespace Antiphp\View\Renderer;

use Antiphp\View\Model\HtmlJsonModel;
use Zend\View\Model\JsonModel;
use Zend\View\Renderer\JsonRenderer;
use Zend\View\Resolver\ResolverInterface;
use Zend\View\Renderer\TreeRendererInterface;
use Zend\View\Renderer\RendererInterface;

/**
 * HTML/JSON Renderer
 * 
 * Renders HTML first, then embed it as 'html' property within JSON
 */
class HtmlJsonRenderer implements RendererInterface, TreeRendererInterface
{
    /**
     * HTML Renderer (by default it's the PhpRenderer)
     * @var RendererInterface
     */
    private $htmlRenderer;
    
    /**
     * JSON Renderer
     * @var JsonRenderer
     */
    private $jsonRenderer;
    
    /**
     * Template resolver
     * @var ResolverInterface
     */
    private $resolver;
    
    /**
     * @param RendererInterface $htmlRenderer
     * @param JsonRenderer $jsonRenderer
     */
    public function __construct(RendererInterface $htmlRenderer, JsonRenderer $jsonRenderer)
    {
        $this->htmlRenderer = $htmlRenderer;
        $this->jsonRenderer = $jsonRenderer;
    }
    
    /**
     * @return \Antiphp\View\Renderer\HtmlJsonRenderer
     */
    public function getEngine()
    {
        return $this;
    }
    
    /**
     * @param ResolverInterface $resolver
     */
    public function setResolver(ResolverInterface $resolver)
    {
        $this->htmlRenderer->setResolver($resolver);
        $this->jsonRenderer->setResolver($resolver);
    }
    
    /**
     * Render JSON
     * @return string JSON
     */
    public function render($htmlJsonModel, $values = null)
    {
        if (!$htmlJsonModel instanceof HtmlJsonModel) {
            // wrong model
            return;
        }
        // if we're here, we don't want to render a layout
        $htmlJsonModel->setTerminal(true);
        
        // use our HTML renderer for the template
        $html = $this->htmlRenderer->render($htmlJsonModel, $values);
        
        // these are the JSON properties, feel free to copy more
        $json = array('html' => $html);
        $jsonModel = new JsonModel($json);]
        $json = $this->jsonRenderer->render($jsonModel, $values);
        
        return $json;
    }
    
    /**
     * @return bool
     */
    public function canRenderTrees()
    {
        return $this->jsonRenderer->canRenderTrees();
    }
}