<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_kendaraan = null;

    #[ORM\Column]
    private ?int $id_jenis_kendaraan = null;

    #[ORM\Column(length: 255)]
    private ?string $nama = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $keterangan = null;

    #[ORM\Column(type: 'boolean')]
    private bool $active = false;

    public function getId(): ?int
    {
        return $this->id_kendaraan;
    }

    public function getIdJenisKendaraan(): ?int
    {
        return $this->id_jenis_kendaraan;
    }

    public function setIdJenisKendaraan(int $id_jenis_kendaraan): static
    {
        $this->id_jenis_kendaraan = $id_jenis_kendaraan;

        return $this;
    }

    public function getNama(): ?string
    {
        return $this->nama;
    }

    public function setNama(string $nama): static
    {
        $this->nama = $nama;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getKeterangan(): ?string
    {
        return $this->keterangan;
    }

    public function setKeterangan(?string $keterangan): static
    {
        $this->keterangan = $keterangan;

        return $this;
    }
}
