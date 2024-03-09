<?php

namespace App\Controller;

use App\Form\VehicleFormType;
use App\Form\VehicleTypeFormType;
use App\Repository\VehicleTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VehicleTypeController extends AbstractController
{
    #[Route('/vehicle/type', name: 'vehicleType')]
    public function index(VehicleTypeRepository $vehicleTypeRepository): Response
    {
        $vehicleTypes = $vehicleTypeRepository->findAll();
        return $this->render('vehicle_type/index.html.twig', [
            'vehicleTypes' => $vehicleTypes
        ]);
    }

    #[Route('/vehicle/type/create', name: 'createVehicleType')]
    public function create(VehicleTypeRepository $vehicleTypeRepository): Response
    {
        $form = $this->createForm(VehicleTypeFormType::class, null, [
            'attr' => ['class' => 'flex flex-col gap-4']
        ]);
        $vehicleTypes = $vehicleTypeRepository->findAll();
        return $this->render('vehicle_type/create.html.twig', [
            'vehicleTypes' => $vehicleTypes,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/vehicle/type/store', name: 'storeVehicleType', methods: ['POST'])]
    public function store(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(VehicleTypeFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicle = $form->getData();
            $em->persist($vehicle);
            $em->flush();
            return $this->redirectToRoute('vehicleType');
        }

        return $this->render('vehicle_type/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
