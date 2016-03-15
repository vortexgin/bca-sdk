#SDK BCA for Symfony

## Registering Bundles
```
public function registerBundles()
{
  ...
  new Vortexgin\CoreBundle\VortexginCoreBundle(),
  new Vortexgin\BCA\OAuthBundle\VortexginBCAOAuthBundle(),
  new Vortexgin\BCA\eWallet\UserBundle\VortexginBCAeWalletUserBundle(),  
  ...
}
```

## Configuration
```
...
- { resource: "@VortexginBCAeWalletUserBundle/Resources/config/services.yml" }
...

vortexgin_bcao_auth:
    oauth:
        client_id: 'c0c0adb4-832d-4f17-8c15-6474ffd9fa93'
        client_secret: '8e3059ce-84cf-40ec-9cc2-039d073e505c'
    api:
        host: 'https://api.finhacks.id'
        api_id: 'f37d2c17-22e5-4ffd-ae51-0585c70d0343'
        api_secret: '22a2d25e-765d-41e1-8d29-da68dcb5698b'
        company_code: 80173
...
```

## How to Use
### Request Access Token
#### As a Service
```
/* @var $oAuthManager \Vortexgin\BCA\OAuthBundle\Manager\OAuthManager */
$oAuthManager = $container->get('vortexgin.bca.oauth');
$response = $oAuthManager->getAccessToken();
```

### Registering User
#### As a Service
```
/* @var $userManager \Vortexgin\BCA\UserBundle\Manager\UserManager */
$userManager = $container->get('vortexgin.bca.ewallet.user');
$response = $userManager->register('Tommy', '1988-08-31', '+6289631441712', '+6289631441712', 'vortexgin@gmail.com', '123');
```
