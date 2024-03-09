<?php

namespace  App\DataFixtures;

use App\Entity\Vehicle;
use App\Entity\VehicleType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class  AppFixtures extends Fixture
{
    public  function  load(ObjectManager $manager): void
    {
        $vehicleType = new VehicleType();
        $vehicleType->setName('Jenis Mobil');
        $vehicleType->setDescription('Ini adalah jenis mobil');
        $vehicleType->setStatus(true);
        $manager->persist($vehicleType);

        $vehicle = new Vehicle();
        $vehicle->setName('Mobil');
        $vehicle->setVehicleType($vehicleType);
        $vehicle->setDescription('Ini adalah mobil');
        $vehicle->setStatus(true);
        $manager->persist($vehicle);

        $manager->flush();
    }
}