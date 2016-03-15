<?php
namespace Vortexgin\CoreBundle\Util;

/**
 * BCA Signature Generator
 *
 * @author Tommy Dian P
 * @license GPL
 */
abstract class BCASignature
{
  public static function generate($httpMethod, $relativeUrl, array $params = array(),
                                  $timestamp = '', $accessToken = '', $apiSecret = ''){
    if(empty($timestamp))$timestamp = date('Y-m-d\TH:i:s'.substr(microtime(), 1, 4).'O');

    $body = json_encode($params);
    $sha256 = hash('sha256', $body);

    $stringToSign = $httpMethod .':'. $relativeUrl .':'. $accessToken .':'.strtolower($sha256) .':'. $timestamp;

    return hash_hmac('sha256', $stringToSign, $apiSecret);
  }
}
