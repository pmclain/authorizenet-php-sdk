<?php

namespace Pmclain\Authnet\Test\Unit;

use PHPUnit\Framework\TestCase;
use Pmclain\Authnet\MerchantAuthentication;

class MerchantAuthenticationTest extends TestCase
{
    public function testToArray()
    {
        $loginId = 'test';
        $transactionKey = 'ing';
        $expected = [
            MerchantAuthentication::FIELD_NAME => $loginId,
            MerchantAuthentication::FIELD_TRANSACTION_KEY => $transactionKey,
        ];

        $merchantAuth = new MerchantAuthentication($loginId, $transactionKey);

        $this->assertEquals($expected, $merchantAuth->toArray());
    }

    /**
     * @expectedException \Pmclain\Authnet\Exception\MissingAuthException
     */
    public function testToArrayException()
    {
        $merchantAuth = new MerchantAuthentication();

        $merchantAuth->toArray();
    }
}
