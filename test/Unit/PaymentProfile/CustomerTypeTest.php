<?php

namespace Pmclain\Authnet\Test\Unit\PaymentProfile;

use PHPUnit\Framework\TestCase;
use Pmclain\Authnet\PaymentProfile\CustomerType;

class CustomerTypeTest extends TestCase
{
    public function testValidate()
    {
        $this->assertTrue(CustomerType::validate(CustomerType::INDIVIDUAL));
    }

    /**
     * @expectedException \Pmclain\Authnet\Exception\InputException
     */
    public function testValidateException()
    {
        CustomerType::validate('invalid string');
    }
}
