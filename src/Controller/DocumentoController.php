<?php

namespace App\Controller;

use App\Entity\Contrato;
use App\Entity\Contratante;
use App\Entity\Contratado;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class DocumentoController extends AbstractController
{
    #[Route('/', methods: ['GET'])]
    #[OA\Get(
        path: "/",
        summary: "Lista todos os contratos",
        description: "Retorna uma lista de todos os contratos no sistema.",
        tags: ["Contratos"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de contratos",
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(
                                type: 'object',
                                properties: [
                                    new OA\Property(property: 'id', type: 'integer'),
                                    new OA\Property(property: 'data', type: 'string'),
                                    new OA\Property(
                                        property: 'contratante',
                                        type: 'object',
                                        properties: [
                                            new OA\Property(property: 'id', type: 'integer'),
                                            new OA\Property(property: 'nome', type: 'string'),
                                            new OA\Property(property: 'cpf_cnpj', type: 'string'),
                                            new OA\Property(property: 'rg', type: 'string'),
                                            new OA\Property(property: 'cep', type: 'string'),
                                            new OA\Property(property: 'rua', type: 'string'),
                                            new OA\Property(property: 'bairro', type: 'string'),
                                            new OA\Property(property: 'cidade', type: 'string'),
                                            new OA\Property(property: 'estado', type: 'string')
                                        ]
                                    ),
                                    new OA\Property(
                                        property: 'contratado',
                                        type: 'object',
                                        properties: [
                                            new OA\Property(property: 'id', type: 'integer'),
                                            new OA\Property(property: 'nome', type: 'string'),
                                            new OA\Property(property: 'cpf_cnpj', type: 'string'),
                                            new OA\Property(property: 'rg', type: 'string'),
                                            new OA\Property(property: 'cep', type: 'string'),
                                            new OA\Property(property: 'rua', type: 'string'),
                                            new OA\Property(property: 'bairro', type: 'string'),
                                            new OA\Property(property: 'cidade', type: 'string'),
                                            new OA\Property(property: 'estado', type: 'string')
                                        ]
                                    ),
                                    new OA\Property(
                                        property: 'clausulas',
                                        type: 'array',
                                        items: new OA\Items(
                                            type: 'object',
                                            properties: [
                                                new OA\Property(property: 'id', type: 'integer'),
                                                new OA\Property(property: 'texto', type: 'string')
                                            ]
                                        )
                                    )
                                ]
                            )
                        )
                    ]
                )
            )
        ]
    )]
    public function index(EntityManagerInterface $manager): Response
    {
        $query = $manager
            ->getRepository(Contrato::class)
            ->createQueryBuilder('c')
            ->getQuery();
        $result = $query->getResult(Query::HYDRATE_ARRAY);
        return new JsonResponse(["data" => $result]);
    }

    #[Route('/contrato/{id}', methods: ['GET'])]
    #[OA\Get(
        path: "/contrato/{id}",
        summary: "Obtém um contrato pelo ID",
        description: "Retorna os detalhes de um contrato específico com base no ID fornecido.",
        tags: ["Contratos"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                description: "ID do contrato",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Detalhes do contrato",
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'id', type: 'integer'),
                        new OA\Property(property: 'data', type: 'string'),
                        new OA\Property(
                            property: 'contratante',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'integer'),
                                new OA\Property(property: 'nome', type: 'string'),
                                new OA\Property(property: 'cpf_cnpj', type: 'string'),
                                new OA\Property(property: 'rg', type: 'string'),
                                new OA\Property(property: 'cep', type: 'string'),
                                new OA\Property(property: 'rua', type: 'string'),
                                new OA\Property(property: 'bairro', type: 'string'),
                                new OA\Property(property: 'cidade', type: 'string'),
                                new OA\Property(property: 'estado', type: 'string')
                            ]
                        ),
                        new OA\Property(
                            property: 'contratado',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'integer'),
                                new OA\Property(property: 'nome', type: 'string'),
                                new OA\Property(property: 'cpf_cnpj', type: 'string'),
                                new OA\Property(property: 'rg', type: 'string'),
                                new OA\Property(property: 'cep', type: 'string'),
                                new OA\Property(property: 'rua', type: 'string'),
                                new OA\Property(property: 'bairro', type: 'string'),
                                new OA\Property(property: 'cidade', type: 'string'),
                                new OA\Property(property: 'estado', type: 'string')
                            ]
                        ),
                        new OA\Property(
                            property: 'clausulas',
                            type: 'array',
                            items: new OA\Items(
                                type: 'object',
                                properties: [
                                    new OA\Property(property: 'id', type: 'integer'),
                                    new OA\Property(property: 'texto', type: 'string')
                                ]
                            )
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Contrato não encontrado",
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'error', type: 'string', example: 'Contrato não encontrado')
                    ]
                )
            )
        ]
    )]
    public function show(int $id, EntityManagerInterface $manager): Response
    {
        $contrato = $manager->getRepository(Contrato::class)->find($id);

        if (!$contrato) {
            return new JsonResponse(["error" => "Contrato não encontrado"], Response::HTTP_NOT_FOUND);
        }

        $data = $this->formatContrato($contrato);

        return new JsonResponse($data);
    }

    private function formatContrato(Contrato $contrato): array
    {
        return [
            'id' => $contrato->getId(),
            'data' => $contrato->getData(),
            'contratante' => $this->formatContratante($contrato->getContratante()),
            'contratado' => $this->formatContratado($contrato->getContratado()),
            'clausulas' => $this->formatClausulas($contrato->getClausulas()->toArray())
        ];
    }

    private function formatContratante(?Contratante $contratante): ?array
    {
        if (!$contratante) {
            return null;
        }

        return [
            'id' => $contratante->getId(),
            'nome' => $contratante->getNome(),
            'cpf_cnpj' => $contratante->getCpfCnpj(),
            'rg' => $contratante->getRg(),
            'cep' => $contratante->getCep(),
            'rua' => $contratante->getRua(),
            'bairro' => $contratante->getBairro(),
            'cidade' => $contratante->getCidade(),
            'estado' => $contratante->getEstado()
        ];
    }

    private function formatContratado(?Contratado $contratado): ?array
    {
        if (!$contratado) {
            return null;
        }

        return [
            'id' => $contratado->getId(),
            'nome' => $contratado->getNome(),
            'cpf_cnpj' => $contratado->getCpfCnpj(),
            'rg' => $contratado->getRg(),
            'cep' => $contratado->getCep(),
            'rua' => $contratado->getRua(),
            'bairro' => $contratado->getBairro(),
            'cidade' => $contratado->getCidade(),
            'estado' => $contratado->getEstado()
        ];
    }

    private function formatClausulas(array $clausulas): array
    {
        return array_map(fn($clausula) => [
            'id' => $clausula->getId(),
            'texto' => $clausula->getTexto()
        ], $clausulas);
    }
}
