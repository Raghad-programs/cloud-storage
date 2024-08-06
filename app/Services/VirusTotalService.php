<?php

namespace App\Services;

use GuzzleHttp\Client;

class VirusTotalService
{
    protected $apiKey;
    protected $client;

    public function __construct()
    {
        $this->apiKey = 'cbdcd11036505b454a806464a94a8870213b85d1a121f3f21696955954288807';
        $this->client = new Client([
            'base_uri' => 'https://www.virustotal.com/vtapi/v2/',
        ]);
    }

    public function scanFile($filePath)
    {
        $response = $this->client->post('file/scan', [
            'multipart' => [
                [
                    'name' => 'apikey',
                    'contents' => $this->apiKey,
                ],
                [
                    'name' => 'file',
                    'contents' => fopen($filePath, 'r'),
                ],
            ],
        ]);

        // Parse the JSON response from VirusTotal API
        $scanResult = json_decode($response->getBody()->getContents(), true);

        // Check if response is valid and handle accordingly
        if ($this->isValidScanResponse($scanResult)) {
            return $scanResult;
        } else {
            return [
                'response_code' => -1, // Example for handling invalid responses
                'positives' => 0,      // Example for handling invalid responses
                // Handle other VirusTotal scan results
            ];
        }
    }

    protected function isValidScanResponse($scanResult)
    {
        return isset($scanResult['response_code']) && isset($scanResult['positives']);
        // Add more checks if necessary based on VirusTotal API documentation
    }
}

