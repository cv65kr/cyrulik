<?php

declare(strict_types=1);

namespace App\Controller\Action;

use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

final class SignUpAction
{
    /**
     * @var Twig_Environment
     */
    private $environment;

    /**
     * SignUpAction constructor.
     *
     * @param Twig_Environment $environment
     */
    public function __construct(Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function __invoke(): Response
    {
        return new Response($this->environment->render('Action/signup.html.twig'));
    }
}