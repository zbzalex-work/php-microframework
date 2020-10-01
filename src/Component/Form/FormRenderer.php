<?php

namespace Xand\Component\Form;
use Xand\Component\Templating\EngineInterface;

/**
 * Class FormRenderer
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class FormRenderer implements FormRendererInterface
{
	/**
	 * @var EngineInterface
	 */
	protected $engine;

    /**
     * FormRenderer constructor.
     *
     * @param \Xand\Component\Templating\EngineInterface $engine
     */
	public function __construct(EngineInterface $engine)
	{
		$this->engine = $engine;
	}
	
	/**
	 * @return EngineInterface
	 */
	public function getEngine()
	{
		return $this->engine;
	}

    /**
     * @param                                    $blockName
     * @param \Xand\Component\Form\FormView|null $view
     * @param array                              $params
     *
     * @return mixed|string
     */
	public function renderBlock($blockName, FormView $view = null, array $params = [])
	{
		$params['view'] = $view;

		return $this->engine->render($blockName . ".html.php", $params);
	}
}