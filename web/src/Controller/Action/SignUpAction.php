<?php

declare(strict_types=1);

namespace App\Controller\Action;

use App\Form\Type\SignUpType;
use App\Model\SignUpModel;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

final class SignUpAction
{
    /**
     * @var Twig_Environment
     */
    private $environment;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * SignUpAction constructor.
     *
     * @param Twig_Environment $environment
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(Twig_Environment $environment, FormFactoryInterface $formFactory)
    {
        $this->environment = $environment;
        $this->formFactory = $formFactory;
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(Request $request): Response
    {
        $model = new SignUpModel();
        $form = $this->formFactory->create(SignUpType::class, $model);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        }

        return new Response(
            $this->environment->render(
                'Action/signup.html.twig',
                [
                    'form' => $form->createView(),
                ]
            )
        );
    }
}