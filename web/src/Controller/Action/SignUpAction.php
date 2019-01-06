<?php

declare(strict_types=1);

namespace App\Controller\Action;

use App\Api\RegisterAccountHandler;
use App\Form\Type\SignUpType;
use App\Model\SignUpModel;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig_Environment;

final class SignUpAction
{
    /** @var Twig_Environment */
    private $environment;

    /** @var FormFactoryInterface */
    private $formFactory;

    /** @var RegisterAccountHandler */
    private $registerAccountHandler;

    /** @var RouterInterface */
    private $router;

    /**
     * SignUpAction constructor.
     */
    public function __construct(
        Twig_Environment $environment,
        FormFactoryInterface $formFactory,
        RegisterAccountHandler $registerAccountHandler,
        RouterInterface $router
    ) {
        $this->environment = $environment;
        $this->formFactory = $formFactory;
        $this->registerAccountHandler = $registerAccountHandler;
        $this->router = $router;
    }

    /**
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
            if ($this->registerAccountHandler->create($model)) {
                $request->getSession()->getFlashBag()->add('success', 'Account was created.');
            } else {
                $request->getSession()->getFlashBag()->add('danger', 'Account cannot be created, try again after few seconds.');
            }

            return new RedirectResponse(
                $this->router->generate('sign_up')
            );
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
