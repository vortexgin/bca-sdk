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
        client_id: 'xxx'
        client_secret: 'yyy'
    api:
        host: 'https://api.finhacks.id'
        api_id: 'zzz'
        api_secret: 'iii'
        company_code: 12345
...
```

## How to Use
### Request Access Token
```
/* @var $oAuthManager \Vortexgin\BCA\OAuthBundle\Manager\OAuthManager */
$oAuthManager = $container->get('vortexgin.bca.oauth');
$response = $oAuthManager->getAccessToken();
```

### Registering User
```
/* @var $userManager \Vortexgin\BCA\UserBundle\Manager\UserManager */
$userManager = $container->get('vortexgin.bca.ewallet.user');
$response = $userManager->register('Tommy', '1988-08-31', '+6289631441712', '+6289631441712', 'vortexgin@gmail.com', '123');
```
