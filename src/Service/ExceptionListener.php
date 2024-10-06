<?php

namespace App\Service;

use App\Exception\SnowTrickException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsEventListener(event: 'kernel.exception', priority: 100, method: 'onSnowTrickException')]
class ExceptionListener
{
    private const HOMEPAGE_URL = 'accueil';
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function onSnowTrickException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof SnowTrickException) {
            return;
        }

        $session = new Session();
        $session->set('error_message', $exception->getMessage());

        $url = $this->urlGenerator->generate('homepage'); // Remplace
        $event->setResponse(new RedirectResponse($url));
    }
}
