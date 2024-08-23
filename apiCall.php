<?php

require_once(__DIR__ . '/vendor/autoload.php');
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Facades\Estimate;

session_start();

function getEstimates()
{

    // // Create SDK instance
    // $config = include('config.php');
    // $dataService = DataService::Configure(array(
    //     'auth_mode' => 'oauth2',
    //     'ClientID' => $config['client_id'],
    //     'ClientSecret' =>  $config['client_secret'],
    //     'RedirectURI' => $config['oauth_redirect_uri'],
    //     'scope' => $config['oauth_scope'],
    //     'baseUrl' => "development"
    // ));

    // /*
    //  * Retrieve the accessToken value from session variable
    //  */
    // $accessToken = $_SESSION['sessionAccessToken'];

    // /*
    //  * Update the OAuth2Token of the dataService object
    //  */
    // $dataService->updateOAuth2Token($accessToken);
    // $companyInfo = $dataService->getCompanyInfo();
    // $address = "QBO API call Successful!! Response Company name: " . $companyInfo->CompanyName . " Company Address: " . $companyInfo->CompanyAddr->Line1 . " " . $companyInfo->CompanyAddr->City . " " . $companyInfo->CompanyAddr->PostalCode;
    // print_r($address);
    // return $companyInfo;


    $config = include('config.php');

    $dataService = DataService::Configure(array(
        'auth_mode' => 'oauth2',
        'ClientID' => $config['client_id'],
        'ClientSecret' => $config['client_secret'],
        'RedirectURI' => $config['oauth_redirect_uri'],
        'scope' => $config['oauth_scope'],
        'accessTokenKey' => $_SESSION['sessionAccessToken']->getAccessToken(),
        'refreshTokenKey' => $_SESSION['sessionAccessToken']->getRefreshToken(),
        'QBORealmID' => $_SESSION['realm_id'],
        'baseUrl' => "development",
    ));
    
    $estimates = $dataService->Query("SELECT * FROM Estimate");
     // Check if estimates array is not empty
     if (!empty($estimates)) {
        // Convert estimate to a JSON string for easier reading
        $estimatesJson = json_encode($estimates[0], JSON_PRETTY_PRINT);
        $address = "QBO API call Successful!! Response Estimates: " . $estimatesJson;

         // Iterate over each estimate TODO
        // foreach ($estimates as $estimate) {
        //     // Iterate over each line in the estimate
        //     foreach ($estimate->Line as $line) {
        //         // Check if DetailType is "SalesItemLineDetail"
        //         if ($line->DetailType === "SalesItemLineDetail") {
        //             // Extract parameters from the line
        //             $PO = $estimate->PONumber ?? ''; // Handle if PONumber is null
        //             $SKU = $line->Id ?? ''; // Handle if Id is null
        //             $UpdatedQty = ''; // Define how to get or calculate UpdatedQty if needed

        //             // Call the syncRecords method
        //             $airtableApiExecutor->syncRecords($PO, $SKU, $UpdatedQty);
        //         }
        //     }
        // }
    } else {
        $address = "No estimates found.";
    }
    print_r($address);

}

$result = getEstimates();

?>

