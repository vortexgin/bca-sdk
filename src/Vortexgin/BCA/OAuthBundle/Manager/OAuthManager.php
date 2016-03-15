<?php

namespace Vortexgin\BCA\OAuthBundle\Manager;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Vortexgin\CoreBundle\Manager\ConnectionManager;
use Vortexgin\CoreBundle\Util\HttpStatusHelper;

class OAuthManager
{
    /* @var $clientId string */
    private $clientId;

    /* @var $clientSecret string */
    private $clientSecret;
    
    /* @var $connectionManager \Vortexgin\CoreBundle\Manager\ConnectionManager */
    private $connectionManager;

    public function __construct($host, $clientId, $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->connectionManager = new ConnectionManager($host);
    }

    public function getAccessToken()
    {
        try {
            $response = $this->connectionManager->stream('/api/oauth/token', 'POST', array('grant_type' => 'client_credentials'), array(
                'Authorization' => 'Basic '.base64_encode($this->clientId.':'.$this->clientSecret),
                'Content-Type' => 'application/x-www-form-urlencoded',
            ));

            if (!$response instanceof JsonResponse || $response->getStatusCode() != HttpStatusHelper::HTTP_OK) {
                throw new AccessDeniedException("Invalid token response");
            }

            return json_decode($response->getContent(), true);
        } catch (\Exception $e) {
            throw new BadCredentialsException($e->getMessage());
        }
    }
}
