<?php

class AirtableAPI {
    private $apiKey;
    private $endpoint;

    public function __construct($apiKey, $baseId, $tableName) {
        $this->apiKey = $apiKey;
        // Use rawurlencode to encode the table name properly
        $tableName = rawurlencode($tableName);
        $this->endpoint = "https://api.airtable.com/v0/{$baseId}/{$tableName}";
    }

    public function getRecords($filterValue1, $filterValue2, $maxRecords = 10) {
        $records = [];
        $offset = null;

        $filterByFormula = urlencode("AND({PO / Customer Reference} = '{$filterValue1}', {SKU} = '{$filterValue2}')");

        do {
            $url = $this->endpoint . "?pageSize=100&filterByFormula={$filterByFormula}" . ($offset ? '&offset=' . urlencode($offset) : '');

            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer {$this->apiKey}",
                    "Content-Type: application/json"
                ],
                CURLOPT_CAINFO => 'assets/cacert.pem',
            ]);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                throw new Exception("cURL Error: " . curl_error($ch));
            }

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200) {
                throw new Exception("Error fetching records from Airtable: HTTP Code $httpCode");
            }

            $data = json_decode($response, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("JSON Decode Error: " . json_last_error_msg());
            }

            $records = array_merge($records, $data['records']);
            $offset = $data['offset'] ?? null;

        } while ($offset && count($records) < $maxRecords);

        // Trim the result if more records were fetched than needed
        $filteredRecords = array_slice($records, 0, $maxRecords);

        // Convert the filtered records to JSON
        return json_encode($filteredRecords, JSON_PRETTY_PRINT);
    }

    public function updateRecord($recordId, $updatedFields) {
        $url = $this->endpoint . '/' . $recordId;

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PATCH',
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$this->apiKey}",
                "Content-Type: application/json"
            ],
            CURLOPT_POSTFIELDS => json_encode(['fields' => $updatedFields]),
            CURLOPT_CAINFO => 'assets/cacert.pem',
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception("cURL Error: " . curl_error($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new Exception("Error updating record in Airtable: HTTP Code $httpCode");
        }

        return json_decode($response, true);
    }
}

?>

