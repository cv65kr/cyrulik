<?php

declare(strict_types=1);

namespace App\Controller\Action;

use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

final class IndexAction
{
    /**
     * @var Twig_Environment
     */
    private $environment;

    /**
     * IndexAction constructor.
     *
     * @param Twig_Environment $environment
     */
    public function __construct(Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function __invoke(): Response
    {
        return new Response($this->environment->render('Action/index.html.twig'));
    }
}