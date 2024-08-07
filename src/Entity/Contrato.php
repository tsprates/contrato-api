<?php

namespace App\Entity;

use App\Repository\ContratoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContratoRepository::class)]
class Contrato
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 30)]
    private ?string $data = null;

    #[ORM\Column(type: 'string')]
    private ?string $imagem = null;

    #[ORM\OneToOne(targetEntity: Contratante::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contratante $contratante = null;

    #[ORM\OneToOne(targetEntity: Contratado::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contratado $contratado = null;

    #[ORM\OneToMany(mappedBy: 'contrato', targetEntity: Clausula::class, orphanRemoval: true)]
    private Collection $clausulas;

    public function __construct()
    {
        $this->clausulas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(string $data): static
    {
        $this->data = $data;
        return $this;
    }

    public function getImagem(): ?string
    {
        return $this->imagem;
    }

    public function setImagem(string $imagem): static
    {
        $this->imagem = $imagem;
        return $this;
    }

    public function getContratante(): ?Contratante
    {
        return $this->contratante;
    }

    public function setContratante(?Contratante $contratante): static
    {
        $this->contratante = $contratante;
        return $this;
    }

    public function getContratado(): ?Contratado
    {
        return $this->contratado;
    }

    public function setContratado(?Contratado $contratado): static
    {
        $this->contratado = $contratado;
        return $this;
    }

    /**
     * @return Collection<int, Clausula>
     */
    public function getClausulas(): Collection
    {
        return $this->clausulas;
    }

    public function addClausula(Clausula $clausula): static
    {
        if (!$this->clausulas->contains($clausula)) {
            $this->clausulas->add($clausula);
            $clausula->setContrato($this);
        }

        return $this;
    }

    public function removeClausula(Clausula $clausula): static
    {
        if ($this->clausulas->removeElement($clausula)) {
            // set the owning side to null (unless already changed)
            if ($clausula->getContrato() === $this) {
                $clausula->setContrato(null);
            }
        }

        return $this;
    }
}
