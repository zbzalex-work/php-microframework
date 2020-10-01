<?php

namespace Xand\Component\Foundation;
use Xand\Component\EventDispatcher\EventDispatcherInterface;
use Xand\Component\Foundation\Controller\ControllerResolverInterface;
use Xand\Component\Foundation\Controller\ControllerResolver;
use Xand\Component\Foundation\Event\RequestEvent;
use Xand\Component\Foundation\Event\ControllerEvent;
use Xand\Component\Foundation\Event\ResponseEvent;

/**
 * Class Kernel
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Kernel implements KernelInterface
{
    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var ControllerResolverInterface
     */
    protected $resolver;

    /**
     * @param EventDispatcherInterface $dispatcher
     * @param ControllerResolverInterface|null $resolver
     */
    public function __construct(EventDispatcherInterface $dispatcher, ControllerResolverInterface $resolver = null)
    {
        $this->dispatcher = $dispatcher;
        $this->resolver = null === $resolver ? new ControllerResolver() : $resolver;
    }
	
	/**
	 * @return EventDispatcherInterface
	 */
	public function getEventDispatcher()
	{
		return $this->dispatcher;
	}

    /**
     * @param \Xand\Component\Foundation\ServerRequest|null $request
     *
     * @return mixed|void
     * @throws \ReflectionException
     */
    public function handleRequest(ServerRequest $request = null)
    {
		/* @var ServerRequest */
        $request = null === $request ? ServerRequest::createFromGlobals() : $request;
		
        $event = new RequestEvent($request);
        $this->dispatcher->dispatch(KernelEvents::REQUEST, $event);

        try
        {
            if ($event->hasResponse())
                throw new Result($event->getResponse());

            list($object, $method) = $this->resolver->getController($request);

            $event = new ControllerEvent($request);
            $event->setController($object);
            $this->dispatcher->dispatch(KernelEvents::CONTROLLER, $event);

            $reflector = new \ReflectionMethod(get_class($object), $method);
            $reflector->invokeArgs($object, [
                $request
            ]);
		} catch(Result $e) {

            $event = new ResponseEvent($request);
            $event->setResponse($e->getResponse());
            $this->dispatcher->dispatch(KernelEvents::RESPONSE, $event);

            if ($event->hasResponse()) {
                $event->getResponse()->send();
            }

        }
    }
}