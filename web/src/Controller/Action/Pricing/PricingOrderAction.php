<?php

declare(strict_types=1);

namespace App\Controller\Action\Pricing;

use App\Form\Type\PricingOrderType;
use App\Model\Plan\PlanItem;
use App\Model\PricingOrderModel;
use App\Service\PlanService;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;
use Webmozart\Assert\Assert;

final class PricingOrderAction
{
    /**
     * @var PlanService
     */
    private $planService;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var Twig_Environment
     */
    private $environment;

    /**
     * PricingOrderAction constructor.
     */
    public function __construct(PlanService $planService, FormFactoryInterface $formFactory, Twig_Environment $environment)
    {
        $this->planService = $planService;
        $this->formFactory = $formFactory;
        $this->environment = $environment;
    }

    public function __invoke(Request $request): Response
    {
        $id = $request->get('id', null);
        Assert::notEmpty($id);

        $plans = $this->planService->getPlans();
        $plan = $plans->filter(function(PlanItem $item) use($id) {
            return $item->getId() === $id;
        })->first();

        Assert::notEmpty($plan);

        $model = new PricingOrderModel();
        $form = $this->formFactory->create(PricingOrderType::class, $model, [
            'plan' => $plan
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

        }

        return new Response(
            $this->environment->render(
                'Action/pricing_order.html.twig',
                [
                    'form' => $form->createView(),
                    'plan' => $plan,
                ]
            )
        );
    }
}
