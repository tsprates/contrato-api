<?php

namespace App\Entity;

use App\Repository\ClausulaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClausulaRepository::class)]
class Clausula
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $texto = null;

    #[ORM\ManyToOne(targetEntity: Contrato::class, inversedBy: 'clausulas')]
    #[ORM\JoinColumn(name:"contrato_id", referencedColumnName:"id")]
    private ?Contrato $contrato = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTexto(): ?string
    {
        return $this->texto;
    }

    public function setTexto(string $texto): static
    {
        $this->texto = $texto;

        return $this;
    }

    public function getContrato(): ?Contrato
    {
        return $this->contrato;
    }

    public function setContrato(?Contrato $contrato): static
    {
        $this->contrato = $contrato;

        return $this;
    }
}
