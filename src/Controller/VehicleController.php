<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Entity\VehicleType;
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
    private EntityManagerInterface $em;
    private VehicleRepository $vehicleRepository;
    private VehicleTypeRepository $vehicleTypeRepository;

    public function __construct(VehicleRepository $vehicleRepository, VehicleTypeRepository $vehicleTypeRepository, EntityManagerInterface $em)
    {
        $this->vehicleRepository = $vehicleRepository;
        $this->vehicleTypeRepository = $vehicleTypeRepository;
        $this->em = $em;
    }

    #[Route('/', name: 'vehicle')]
    public function index(): Response
    {
        $vehicles = $this->vehicleRepository->findAll();
        return $this->render('index.html.twig', [
            'vehicles' => $vehicles,
        ]);
    }

    #[Route('/create', name: 'createVehicle')]
    public function create(): Response
    {
        $form = $this->createForm(VehicleFormType::class, null, [
            'attr' => ['class' => 'flex flex-col gap-4']
        ]);
        $vehicleTypes = $this->vehicleTypeRepository->findAll();
        return $this->render('create.html.twig', [
            'vehicleTypes' => $vehicleTypes,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/store', name: 'storeVehicle', methods: ['POST'])]
    public function store(Request $request): Response
    {
        $form = $this->createForm(VehicleFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicle = $form->getData();
            $this->em->persist($vehicle);
            $this->em->flush();
            return $this->redirectToRoute('vehicle');
        }

        return $this->render('create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'editVehicle')]
    public function edit(Request $request, $id): Response
    {
        $vehicle = $this->vehicleRepository->find($id);
        $form = $this->createForm(VehicleFormType::class, $vehicle, [
            'attr' => ['class' => 'flex flex-col gap-4']
        ]);
        $vehicleTypes = $this->vehicleTypeRepository->findAll();
        return $this->render('edit.html.twig', [
            'vehicle' => $vehicle,
            'vehicleTypes' => $vehicleTypes,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/update/{id}', name: 'updateVehicle', methods: ['POST'])]
    public function update(Request $request, $id): Response
    {
        $vehicle = $this->vehicleRepository->find($id);
        $form = $this->createForm(VehicleFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicle->setName($form->get('name')->getData());
            $vehicle->setVehicleType($form->get('vehicleType')->getData());
            $vehicle->setDescription($form->get('description')->getData());
            $vehicle->setStatus($form->get('status')->getData());
            $this->em->flush();
            return $this->redirectToRoute('vehicle');
        }

        $vehicleTypes = $this->vehicleTypeRepository->findAll();
        return $this->render('edit.html.twig', [
            'vehicle' => $vehicle,
            'vehicleTypes' => $vehicleTypes,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'deleteVehicle', methods: ['DELETE', 'POST'])]
    public function delete($id): Response
    {
        $vehicle = $this->vehicleRepository->find($id);
        $this->em->remove($vehicle);
        $this->em->flush();

        return $this->redirectToRoute('vehicle');
    }
}
