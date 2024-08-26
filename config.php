<?php
return array(
    'authorizationRequestUrl' => 'https://appcenter.intuit.com/connect/oauth2',
    'tokenEndPointUrl' => 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer',
    //Prod
    'client_id' => 'AB0gtS3oa2j29MA6ghNj5NAIZYdp3iNpNDiqip9rieNxmKbVtu', 
    'client_secret' => 'YeTgyYJGxw4cRgWNgqzUMivZBUkaJf7z8pscNzYf', 
    //Dev
    // 'client_id' => 'ABYfsripvv37sgqjd9aLEvIsotv21J18umRjZlO8DkJReW4lNV',
    // 'client_secret' => 'pBqwnVPpdHlQQ9Mk2OXCLf8tJKsBKUusVl3ugb6o',
    'oauth_scope' => 'com.intuit.quickbooks.accounting openid profile email phone address',
    'oauth_redirect_uri' => 'https://api.prodjex.com/qbo/prd/callback.php',
    'base_url' => 'production' // Use the 'base_url' (e.g., "development" or "production")
)
?>
