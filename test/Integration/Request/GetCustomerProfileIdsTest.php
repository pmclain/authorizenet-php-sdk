<?php

namespace Pmclain\Authnet\Test\Integration\Request;

use PHPUnit\Framework\TestCase;
use Pmclain\Authnet\MerchantAuthentication;
use Pmclain\Authnet\Request\GetCustomerProfileIds;

class GetCustomerProfileIdsTest extends TestCase
{
    public function testSubmit()
    {
        $request = new GetCustomerProfileIds(true);

        $merchantAuth = new MerchantAuthentication(
            AUTHORIZENET_API_LOGIN_ID,
            AUTHORIZENET_TRANSACTION_KEY
        );

        $request->setMerchantAuthentication($merchantAuth);

        $result = $request->submit();
        $this->assertTrue(isset($result['ids']));
    }
}
