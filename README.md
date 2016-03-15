# BCA eWallet SDK (Unofficial)
SDK untuk mengkoneksikan ke API BCA produk eWallet.

## Contributor
* [Yosef](mailto:yosef@dailysocial.id)

## Install
```
composer require vortexgin/bca-sdk:1.2
```

## Symfony Configuration
### Registering Bundles
```
public function registerBundles()
{
  ...
  new Vortexgin\CoreBundle\VortexginCoreBundle(),
  new Vortexgin\BCA\OAuthBundle\VortexginBCAOAuthBundle(),
  new Vortexgin\BCA\eWallet\UserBundle\VortexginBCAeWalletUserBundle(),
  new Vortexgin\BCA\eWallet\PaymentBundle\VortexginBCAeWalletPaymentBundle(),
  ...
}
```

### Configuration
```
...
- { resource: "@VortexginBCAeWalletUserBundle/Resources/config/services.yml" }
- { resource: "@VortexginBCAeWalletPaymentBundle/Resources/config/services.yml" }
...

vortexgin_bcao_auth:
    oauth:
        client_id: 'YOUR_CLIENT_ID'
        client_secret: 'YOUR_CLIENT_SECRET'
    api:
        host: 'https://api.finhacks.id'
        api_id: 'YOUR_API_ID'
        api_secret: 'YOUR_API_SECRET'
        company_code: YOUR_COMPANY_CODE
...
```

## How to Use
### Request Access Token
#### As a Service (Symfony)
```
/* @var $oAuthManager \Vortexgin\BCA\OAuthBundle\Manager\OAuthManager */
$oAuthManager = $container->get('vortexgin.bca.oauth');
$response = $oAuthManager->getAccessToken();
```
#### As a Constructor
```
/* @var $oAuthManager \Vortexgin\BCA\OAuthBundle\Manager\OAuthManager */
$oAuthManager = new OAuthManager('https://api.finhacks.id', 'YOUR_CLIENT_ID', 'YOUR_CLIENT_SECRET');
$response = $oAuthManager->getAccessToken();

```

### Registering User
#### As a Service (Symfony)
```
/* @var $userManager \Vortexgin\BCA\UserBundle\Manager\UserManager */
$userManager = $container->get('vortexgin.bca.ewallet.user');
$response = $userManager->register('Gin Vortex', '1988-08-31', '+6280000000000', '+6280000000000', 'vortexgin@gmail.com', '123');
```
#### As a Constructor
```
/* @var $oAuthManager \Vortexgin\BCA\OAuthBundle\Manager\OAuthManager */
$oAuthManager = new OAuthManager('https://api.finhacks.id', 'YOUR_CLIENT_ID', 'YOUR_CLIENT_SECRET');

/* @var $userManager \Vortexgin\BCA\UserBundle\Manager\UserManager */
$userManager = new UserManager('https://api.finhacks.id', 'YOUR_API_ID', 'YOUR_API_SECRET', YOUR_COMPANY_CODE, $oAuthManager);
$response = $userManager->register('Gin Vortex', '1988-08-31', '+6280000000000', '+6280000000000', 'vortexgin@gmail.com', '123');
```

### Inquiry User
#### As a Service (Symfony)
```
/* @var $userManager \Vortexgin\BCA\UserBundle\Manager\UserManager */
$userManager = $container->get('vortexgin.bca.ewallet.user');
$response = $userManager->detail('+6280000000000');
```
#### As a Constructor
```
/* @var $oAuthManager \Vortexgin\BCA\OAuthBundle\Manager\OAuthManager */
$oAuthManager = new OAuthManager('https://api.finhacks.id', 'YOUR_CLIENT_ID', 'YOUR_CLIENT_SECRET');

/* @var $userManager \Vortexgin\BCA\UserBundle\Manager\UserManager */
$userManager = new UserManager('https://api.finhacks.id', 'YOUR_API_ID', 'YOUR_API_SECRET', YOUR_COMPANY_CODE, $oAuthManager);
$response = $userManager->detail('+6280000000000');

```

### Update User
#### As a Service (Symfony)
```
/* @var $userManager \Vortexgin\BCA\UserBundle\Manager\UserManager */
$userManager = $container->get('vortexgin.bca.ewallet.user');
$response = $userManager->update('+6280000000000', 'Yosef', null, null, null, null);
```
#### As a Constructor
```
/* @var $oAuthManager \Vortexgin\BCA\OAuthBundle\Manager\OAuthManager */
$oAuthManager = new OAuthManager('https://api.finhacks.id', 'YOUR_CLIENT_ID', 'YOUR_CLIENT_SECRET');

/* @var $userManager \Vortexgin\BCA\UserBundle\Manager\UserManager */
$userManager = new UserManager('https://api.finhacks.id', 'YOUR_API_ID', 'YOUR_API_SECRET', YOUR_COMPANY_CODE, $oAuthManager);
$response = $userManager->update('+6280000000000', 'Yosef', null, null, null, null);
```
### Topup Payment
#### As a Service (Symfony)
```
/* @var $userManager \Vortexgin\BCA\PaymentBundle\Manager\PaymentManager */
$paymentManager = $container->get('vortexgin.bca.ewallet.payment');
$response = $paymentManager->topup("124","TR001","2016-03-15T10:00:00.000+07:00","5000","IDR");
```

#### As a Constructor
```
/* @var $oAuthManager \Vortexgin\BCA\OAuthBundle\Manager\OAuthManager */
$oAuthManager = new OAuthManager('https://api.finhacks.id', 'YOUR_CLIENT_ID', 'YOUR_CLIENT_SECRET');

/* @var $userManager \Vortexgin\BCA\PaymentBundle\Manager\PaymentManager */
$paymentManager = new PaymentManager('https://api.finhacks.id', 'YOUR_API_ID', 'YOUR_API_SECRET', YOUR_COMPANY_CODE, $oAuthManager);
$response = $paymentManager->topup("124","TR001","2016-03-15T10:00:00.000+07:00","5000","IDR");
```

### Payment
#### As a Service (Symfony)
```
/* @var $userManager \Vortexgin\BCA\PaymentBundle\Manager\PaymentManager */
$paymentManager = $container->get('vortexgin.bca.ewallet.payment');
$response = $paymentManager->payment("1111222233334445","TRX9876543210","111222333444","2016-03-15T10:00:00.000+07:00","10000.00","IDR");
```

#### As a Constructor
```
/* @var $oAuthManager \Vortexgin\BCA\OAuthBundle\Manager\OAuthManager */
$oAuthManager = new OAuthManager('https://api.finhacks.id', 'YOUR_CLIENT_ID', 'YOUR_CLIENT_SECRET');

/* @var $userManager \Vortexgin\BCA\PaymentBundle\Manager\PaymentManager */
$paymentManager = new PaymentManager('https://api.finhacks.id', 'YOUR_API_ID', 'YOUR_API_SECRET', YOUR_COMPANY_CODE, $oAuthManager);
$response = $paymentManager->payment("1111222233334445","TRX9876543210","111222333444","2016-03-15T10:00:00.000+07:00","10000.00","IDR");
```

### Payment Status
#### As a Service (Symfony)
```
/* @var $userManager \Vortexgin\BCA\PaymentBundle\Manager\PaymentManager */
$paymentManager = $container->get('vortexgin.bca.ewallet.payment');
$response = $paymentManager->paymentStatus("+628996506531","TRX00000001","REF00000001","2016-03-15T10:00:00.000+07:00");
```

#### As a Constructor
```
/* @var $oAuthManager \Vortexgin\BCA\OAuthBundle\Manager\OAuthManager */
$oAuthManager = new OAuthManager('https://api.finhacks.id', 'YOUR_CLIENT_ID', 'YOUR_CLIENT_SECRET');

/* @var $userManager \Vortexgin\BCA\PaymentBundle\Manager\PaymentManager */
$paymentManager = new PaymentManager('https://api.finhacks.id', 'YOUR_API_ID', 'YOUR_API_SECRET', YOUR_COMPANY_CODE, $oAuthManager);
$response = $paymentManager->paymentStatus("+628996506531","TRX00000001","REF00000001","2016-03-15T10:00:00.000+07:00");
```


### Transaction Inquiry
#### As a Service (Symfony)
```
/* @var $userManager \Vortexgin\BCA\PaymentBundle\Manager\PaymentManager */
$paymentManager = $container->get('vortexgin.bca.ewallet.payment');
$response = $paymentManager->transactionInquiry(PRIMARY_ID,START_DATE,END_DATE,REFERENCE_ID,LAST_ACCOUNT_STATEMENT_ID);
```

#### As a Constructor
```
/* @var $oAuthManager \Vortexgin\BCA\OAuthBundle\Manager\OAuthManager */
$oAuthManager = new OAuthManager('https://api.finhacks.id', 'YOUR_CLIENT_ID', 'YOUR_CLIENT_SECRET');

/* @var $userManager \Vortexgin\BCA\PaymentBundle\Manager\PaymentManager */
$paymentManager = new PaymentManager('https://api.finhacks.id', 'YOUR_API_ID', 'YOUR_API_SECRET', YOUR_COMPANY_CODE, $oAuthManager);
$response = $paymentManager->transactionInquiry("+628996506531","2016-03-01","2016-03-15","TRX00000001");
```
