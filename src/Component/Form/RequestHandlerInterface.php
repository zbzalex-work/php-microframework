<?php

namespace Xand\Component\Form;
use Xand\Component\Foundation\ServerRequest;

/**
 * Interface RequestHandlerInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface RequestHandlerInterface
{
	/**
	 * @param FormInterface $form
	 * @param ServerRequest $request
	 */
	public function __invoke(FormInterface $form, ServerRequest $request);
}
