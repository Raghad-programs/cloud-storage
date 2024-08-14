<?php

namespace App\Services;

use GuzzleHttp\Client; //for making HTTP requests.

class VirusTotalService
{
    protected $client; // instance of the Guzzle HTTP client.
    protected $apiKey; //store the VirusTotal API key.

    public function __construct()
    {
        $this->client = new Client(); // Creates a new Guzzle HTTP client instance for making requests.
        $this->apiKey = env('VIRUS_TOTAL_API_KEY'); // Retrieves the API key from the .env file
    }


    //Uploads a file to VirusTotal for scanning and returns the response.
    public function scanFile($filePath)
    {
    try {
        //Sends a POST request to VirusTotal’s file scan endpoint.
        $response = $this->client->post('https://www.virustotal.com/vtapi/v2/file/scan', [
            'multipart' => [
        //multipart : format used to send files and form data together in a single request

        //1 - Text Data
                [
                    'name'     => 'apikey',
                    'contents' => $this->apiKey,
                ],
        //2-File Data
                [
                    'name'     => 'file',
                    'contents' => fopen($filePath, 'r'),
                    'filename' => basename($filePath),
                ],
            ],
        ]);

        return json_decode($response->getBody(), true);
    } catch (\Exception $e) {
        return [
            'response_code' => 0,
            'verbose_msg' => $e->getMessage(),
        ];
    }
}


    public function getReport($resource)
    {
        $response = $this->client->post('https://www.virustotal.com/vtapi/v2/file/report', [
            'form_params' => [
                'apikey' => $this->apiKey,
                'resource' => $resource,
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
