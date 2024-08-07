<?php

namespace App\Repository;

use App\Entity\Clausula;
use App\Entity\Contratado;
use App\Entity\Contratante;
use App\Entity\Contrato;
use App\Services\DocumentoParser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

class ContratoRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Contrato::class);
        $this->entityManager = $entityManager;
    }

    public function saveFromString(string $text, string $imagem): void
    {
        $parser = new DocumentoParser($text);
        $contrato = new Contrato();
        $contrato->setData($parser->getData());
        $contrato->setImagem($imagem);

        $contratado = $this->createContratado($parser);
        $this->entityManager->persist($contratado);
        $contrato->setContratado($contratado);

        $contratante = $this->createContratante($parser);
        $this->entityManager->persist($contratante);
        $contrato->setContratante($contratante);

        $clausulas = $this->createClausulas($parser);
        foreach ($clausulas as $clausula) {
            $this->entityManager->persist($clausula);
            $contrato->addClausula($clausula);
        }

        $this->entityManager->persist($contrato);
        $this->entityManager->flush();
    }

    private function createContratado(DocumentoParser $parser): Contratado
    {
        $contratado = new Contratado();
        $contratado->setNome($parser->getContratado());
        $contratado->setRg($parser->getContratadoRg());
        $contratado->setCpfCnpj($parser->getContratadoCpfOuPj());
        $contratado->setCep($parser->getContratadoCep());
        $contratado->setRua($parser->getContratadoRua());
        $contratado->setBairro($parser->getContratadoBairro());
        $contratado->setCidade($parser->getContratadoCidade());
        $contratado->setEstado($parser->getContratadoEstado());

        return $contratado;
    }

    private function createContratante(DocumentoParser $parser): Contratante
    {
        $contratante = new Contratante();
        $contratante->setNome($parser->getContratante());
        $contratante->setRg($parser->getContratanteRg());
        $contratante->setCpfCnpj($parser->getContratanteCpfOuPj());
        $contratante->setCep($parser->getContratanteCep());
        $contratante->setRua($parser->getContratanteRua());
        $contratante->setBairro($parser->getContratanteBairro());
        $contratante->setCidade($parser->getContratanteCidade());
        $contratante->setEstado($parser->getContratanteEstado());

        return $contratante;
    }

    private function createClausulas(DocumentoParser $parser): array
    {
        $clausulas = [];
        foreach ($parser->getClausulas() as $textoClausula) {
            $clausula = new Clausula();
            $clausula->setTexto($textoClausula);
            $clausulas[] = $clausula;
        }

        return $clausulas;
    }
}
