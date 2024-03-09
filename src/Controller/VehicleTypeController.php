<?php

namespace App\Controller;

use App\Form\VehicleFormType;
use App\Form\VehicleTypeFormType;
use App\Repository\VehicleRepository;
use App\Repository\VehicleTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VehicleTypeController extends AbstractController
{
    private EntityManagerInterface $em;
    private VehicleRepository $vehicleRepository;
    private VehicleTypeRepository $vehicleTypeRepository;

    public function __construct(VehicleRepository $vehicleRepository, VehicleTypeRepository $vehicleTypeRepository, EntityManagerInterface $em)
    {
        $this->vehicleRepository = $vehicleRepository;
        $this->vehicleTypeRepository = $vehicleTypeRepository;
        $this->em = $em;
    }
    #[Route('/vehicle/type', name: 'vehicleType')]
    public function index(): Response
    {
        $vehicleTypes = $this->vehicleTypeRepository->findAll();
        return $this->render('vehicle_type/index.html.twig', [
            'vehicleTypes' => $vehicleTypes
        ]);
    }

    #[Route('/vehicle/type/create', name: 'createVehicleType')]
    public function create(): Response
    {
        $form = $this->createForm(VehicleTypeFormType::class, null, [
            'attr' => ['class' => 'flex flex-col gap-4']
        ]);

        return $this->render('vehicle_type/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/vehicle/type/store', name: 'storeVehicleType', methods: ['POST'])]
    public function store(Request $request): Response
    {
        $form = $this->createForm(VehicleTypeFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicle = $form->getData();
            $this->em->persist($vehicle);
            $this->em->flush();
            return $this->redirectToRoute('vehicleType');
        }

        return $this->render('vehicle_type/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/vehicle/type/edit/{id}', name: 'editVehicleType')]
    public function edit(Request $request, $id): Response
    {
        $vehicleType = $this->vehicleTypeRepository->find($id);
        $form = $this->createForm(VehicleTypeFormType::class, $vehicleType, [
            'attr' => ['class' => 'flex flex-col gap-4']
        ]);

        return $this->render('vehicle_type/edit.html.twig', [
            'vehicleType' => $vehicleType,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/vehicle/type/update/{id}', name: 'updateVehicleType', methods: ['POST'])]
    public function update(Request $request, $id): Response
    {
        $vehicleType = $this->vehicleTypeRepository->find($id);
        $form = $this->createForm(VehicleTypeFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicleType->setName($form->get('name')->getData());
            $vehicleType->setDescription($form->get('description')->getData());
            $vehicleType->setStatus($form->get('status')->getData());
            $this->em->flush();
            return $this->redirectToRoute('vehicleType');
        }

        return $this->render('vehicle_type/edit.html.twig', [
            'vehicleType' => $vehicleType,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/vehicle/type/delete/{id}', name: 'deleteVehicleType', methods: ['DELETE', 'POST'])]
    public function delete($id): Response
    {
        $vehicleType = $this->vehicleTypeRepository->find($id);
        $this->em->remove($vehicleType);
        $this->em->flush();

        return $this->redirectToRoute('vehicleType');
    }
}
