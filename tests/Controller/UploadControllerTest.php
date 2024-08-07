<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UploadControllerTest extends WebTestCase
{
    public function testUploadDocument()
    {
        $client = static::createClient();

        $filePath = __DIR__ . '/../../public/uploads/exemplo.png';

        $this->assertFileExists($filePath);

        $crawler = $client->request('POST', '/api/upload', [], [
            'documento' => [
                'name' => 'exemplo.png',
                'type' => 'image/png',
                'tmp_name' => $filePath,
                'error' => 0,
                'size' => filesize($filePath),
            ],
        ]);

        $responseContent = $client->getResponse()->getContent();
        $responseData = json_decode($responseContent, true);

        $this->assertArrayHasKey('status', $responseData);
        $this->assertEquals('Documento enviado com sucesso', $responseData['status']);
    }
}
