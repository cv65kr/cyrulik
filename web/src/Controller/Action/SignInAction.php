<?php

declare(strict_types=1);

namespace App\Controller\Action;

use App\Api\RegisterAccountHandler;
use App\Form\Type\SignInType;
use App\Model\SignInModel;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig_Environment;

final class SignInAction
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
     * @var RegisterAccountHandler
     */
    private $registerAccountHandler;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * SignUpAction constructor.
     *
     * @param Twig_Environment $environment
     * @param FormFactoryInterface $formFactory
     * @param RegisterAccountHandler $registerAccountHandler
     * @param RouterInterface $router
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
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $model = new SignInModel();
        $form = $this->formFactory->create(SignInType::class, $model);

        $form->handleRequest($request);
        $error = $authenticationUtils->getLastAuthenticationError();
        if (false === empty($error)) {
            $request->getSession()->getFlashBag()->add('danger', 'Bad credentials, try again.');
            return new RedirectResponse(
                $this->router->generate('sign_in')
            );
        }

        return new Response(
            $this->environment->render(
                'Action/signin.html.twig',
                [
                    'form' => $form->createView(),
                ]
            )
        );
    }
}