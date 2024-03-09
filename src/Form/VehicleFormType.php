<?php

namespace App\Form;

use App\Entity\Vehicle;
use App\Entity\VehicleType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehicleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'attr' => ['class' => 'mt-2 block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'],
                'label_attr' => ['class' => 'block text-sm font-medium leading-6 text-gray-900']
            ])
            ->add('vehicleType', EntityType::class, [
                'class' => VehicleType::class,
                'choice_label' => 'name',
                'attr' => ['class' => 'mt-2 block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'],
                'label_attr' => ['class' => 'block text-sm font-medium leading-6 text-gray-900']
            ])
            ->add('description', null, [
                'attr' => ['class' => 'mt-2 block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'],
                'label_attr' => ['class' => 'block text-sm font-medium leading-6 text-gray-900']
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Aktif' => true,
                    'Tidak Aktif' => false,
                ],
                'expanded' => false,
                'multiple' => false,
                'attr' => [
                    'class' => 'mt-2 block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                ],
                'label_attr' => [
                    'class' => 'block text-sm font-medium leading-6 text-gray-900'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}
