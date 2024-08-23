<?php

require 'airtable_api.php'; // Include the class file

// Execute the main function if this file is run from the command line
if (php_sapi_name() === 'cli') {
    // Update records filtered by "PO / Customer Reference" and "SKU"
    $PO = '2229129754';
    $SKU = 'MF7701';
    $UpdatedQty = 10;  // Example: Set QTY to 10
    syncRecords($PO, $SKU,  $UpdatedQty);
}

function syncRecords($PO, $SKU, $UpdatedQty) {
    try {
        $apiKey = 'patuv90tEuNkcD9mX.da75df37cc1f5df917c60bd5e52893e97066bd29fe50712c4ac8d31c34c59c8b';
        $baseId = 'app6UbINpKWSU7FsR';
        $tableName = 'All Retailers';

        $airtable = new AirtableAPI($apiKey, $baseId, $tableName);
        
        
        // Fetch records filtered by "PO / Customer Reference" and "SKU"
        $records = $airtable->getRecords($PO, $SKU);

        print_r($records);

        // Uncomment this when you want to update the records
        // foreach ($records as $record) {
        //     $recordId = $record['id'];
        //     $updatedFields = ['QTY' => $UpdatedQty];  // Example: Set QTY to 10
        
        //     $airtable->updateRecord($recordId, $updatedFields);
        // }

        // echo "Records updated successfully.\n";

    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage() . "\n";
    }
}