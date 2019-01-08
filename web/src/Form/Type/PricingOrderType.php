<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Model\Plan\PlanItem;
use App\Model\PricingOrderModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PricingOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var PlanItem|null $plan */
        $plan = $options['plan'];
        if (null === $plan) {
            return;
        }

        $choices = PricingOrderModel::getChoices();
        if ($plan->getPricePerYear() <= 0) {
            unset($choices[1]);
        }

        $builder->add('mode', ChoiceType::class, [
            'choices' => \array_flip($choices),
            'expanded' => true,
            'multiple' => false,
        ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'plan' => null,
        ));
    }
}
