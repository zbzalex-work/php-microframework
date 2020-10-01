<?php

namespace Xand\Component\Form;
use Xand\Component\Foundation\ServerRequest;

/**
 * Class RequestHandler
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class RequestHandler implements RequestHandlerInterface
{
    /**
     * @param \Xand\Component\Form\FormInterface       $form
     * @param \Xand\Component\Foundation\ServerRequest $request
     */
	public function __invoke(FormInterface $form, ServerRequest $request)
	{
		try
		{
			if ($form->getMethod() != $request->getMethod())
				throw new \Exception();
			
			/* @var array */
			$data = $request->getQueryParams();
			switch($request->getMethod()) {
				case "POST":
					{
					    /** @var array $data */
						$data = $request->getParsedBody();
					}
					break;
			}
			
			$submittedData = [];
			$names = \array_keys($form->children());
			
			foreach($names as $name) {
                if (!isset($data[$name]))
                    continue;

                $submittedData[$name] = $data[$name];
            }

            if (\count($submittedData) == \count($names)) {
                $form->submit($submittedData);
            }
		} catch(\Exception $e) {}
	}
}
