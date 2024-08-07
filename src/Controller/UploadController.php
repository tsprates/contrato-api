<?php

namespace App\Controller;

use App\Repository\ContratoRepository;
use Exception;
use OpenApi\Attributes as OA;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[OA\Info(
    version: '1.0.0',
    title: 'Contrato API',
    description: 'Contrato API',
    contact: new OA\Contact(name: 'Contrato API Team')
)]
#[OA\Server(
    url: 'https://localhost/',
    description: 'API server'
)]
class UploadController
{
    private LoggerInterface $logger;
    private string $uploadDirectory;
    private ContratoRepository $contratoRepository;

    public function __construct(LoggerInterface $logger, ContratoRepository $contratoRepository)
    {
        $this->logger = $logger;
        $this->uploadDirectory = realpath(dirname(__DIR__) . '/../public/uploads/');
        $this->contratoRepository = $contratoRepository;
    }

    #[Route('/api/upload', methods: ['POST'], name: 'app_upload_upload')]
    #[OA\Post(
        path: '/api/upload',
        summary: 'Upload a document',
        tags: ['contrato'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    type: 'object',
                    properties: [
                        new OA\Property(
                            property: 'documento',
                            type: 'string',
                            format: 'binary'
                        )
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Documento enviado com sucesso',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'Documento enviado com sucesso'),
                        new OA\Property(property: 'documento', type: 'string', example: 'Texto do documento')
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Bad request',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'Falha ao enviar documento')
                    ]
                )
            )
        ]
    )]
    public function upload(Request $request): Response
    {
        $file = $request->files->get('documento');
        if (!$file || !$this->isValidFile($file)) {
            return $this->createErrorResponse('Falha ao enviar documento', Response::HTTP_BAD_REQUEST);
        }

        $fileName = $this->generateUniqueFileName($file->getClientOriginalName(), $file->guessExtension());

        try {
            $file->move($this->uploadDirectory, $fileName);
            $documento = $this->readImageText($fileName);
            $imagemUrl = $this->getBaseUrl($request) . '/uploads/' . $fileName;
            $this->contratoRepository->saveFromString($documento, $imagemUrl);
            return new JsonResponse(
                ['status' => 'Documento enviado com sucesso', 'imagemUrl' => $imagemUrl],
                Response::HTTP_CREATED
            );
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            return $this->createErrorResponse('Erro ao processar documento', Response::HTTP_BAD_REQUEST);
        }
    }

    private function createErrorResponse(string $message, int $statusCode): JsonResponse
    {
        return new JsonResponse(['status' => $message], $statusCode);
    }

    private function generateUniqueFileName(string $originalFilename, string $extension): string
    {
        $safeFilename = str_replace(' ', '_', strtolower(pathinfo($originalFilename, PATHINFO_FILENAME)));
        return $safeFilename . '_' . uniqid() . '.' . $extension;
    }

    private function readImageText(string $fileName): string
    {
        $process = new Process(['pytesseract', '-l', 'por', $this->uploadDirectory . DIRECTORY_SEPARATOR . $fileName]);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        return $process->getOutput();
    }

    private function isValidFile($file): bool
    {
        $validExtensions = ["png", "jpg", "jpeg"];
        return in_array($file->guessExtension(), $validExtensions, true);
    }

    private function getBaseUrl(Request $request): string
    {
        return $request->getSchemeAndHttpHost();
    }
}
