<?php
return array(
    'authorizationRequestUrl' => 'https://appcenter.intuit.com/connect/oauth2',
    'tokenEndPointUrl' => 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer',
    'client_id' => 'YOUR CLIENT ID',
    'client_secret' => 'YOUR CLIENT SECRET',
    'oauth_scope' => 'com.intuit.quickbooks.accounting openid profile email phone address',
    'oauth_redirect_uri' => 'http://localhost:3000/callback.php',
    'base_url' => 'development' // Use the 'base_url' (e.g., "development" or "production")
)
?>
