<?php

namespace App\Service\EventListener;

use App\Exception\FormException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

#[AsEventListener(event: 'kernel.exception', priority: 100, method: 'onFormException')]
class FormExceptionListener
{
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function onFormException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof FormException) {
            return;
        }

        $session = $this->requestStack->getCurrentRequest()->getSession();

        if ($session instanceof Session) {
            $session->getFlashBag()->add('error_form', $exception->getMessage());
        } else {
            return;
        }

        $request = $event->getRequest();
        $referer = $request->headers->get('referer');

        if ($referer) {
            $response = new RedirectResponse($referer);
            $event->setResponse($response);
        }
    }
}
