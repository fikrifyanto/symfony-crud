<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Form\VehicleFormType;
use App\Repository\VehicleRepository;
use App\Repository\VehicleTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VehicleController extends AbstractController
{
    #[Route('/', name: 'vehicle')]
    public function index(VehicleRepository $vehicleRepository): Response
    {
        $vehicles = $vehicleRepository->findAll();
        return $this->render('index.html.twig', [
            'vehicles' => $vehicles,
        ]);
    }

    #[Route('/create', name: 'createVehicle')]
    public function create(VehicleTypeRepository $vehicleTypeRepository): Response
    {
        $form = $this->createForm(VehicleFormType::class, null, [
            'attr' => ['class' => 'flex flex-col gap-4']
        ]);
        $vehicleTypes = $vehicleTypeRepository->findAll();
        return $this->render('create.html.twig', [
            'vehicleTypes' => $vehicleTypes,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/store', name: 'storeVehicle', methods: ['POST'])]
    public function store(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(VehicleFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicle = $form->getData();
            $em->persist($vehicle);
            $em->flush();
            return $this->redirectToRoute('vehicle');
        }

        return $this->render('create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}