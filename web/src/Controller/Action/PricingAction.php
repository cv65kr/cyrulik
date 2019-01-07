<?php

declare(strict_types=1);

namespace App\Controller\Action;

use App\Service\PlanService;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

final class PricingAction
{
    /**
     * @var PlanService
     */
    private $planService;

    /**
     * @var Twig_Environment
     */
    private $twigEnvironment;

    /**
     * PricingAction constructor.
     *
     * @param PlanService $planService
     * @param Twig_Environment $twigEnvironment
     */
    public function __construct(PlanService $planService, Twig_Environment $twigEnvironment)
    {
        $this->planService = $planService;
        $this->twigEnvironment = $twigEnvironment;
    }

    public function __invoke(): Response
    {
        $criteria = new Criteria();
        $criteria->orderBy(['pricePerMonth' => 'ASC']);

        $plans = $this->planService
            ->getPlans()
            ->matching($criteria)
        ;

        return new Response(
            $this->twigEnvironment->render(
                'Partials/pricing.html.twig',
                [
                    'plans' => $plans
                ]
            )
        );
    }
}