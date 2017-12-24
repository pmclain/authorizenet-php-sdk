<?php

namespace Pmclain\Authnet\Test\Unit\TransactionRequest;

use PHPUnit\Framework\TestCase;
use Pmclain\Authnet\TransactionRequest\TransactionType;

class TransactionTypeTest extends TestCase
{
    public function testValidate()
    {
        $this->assertTrue(TransactionType::validate(TransactionType::TYPE_AUTH_CAPTURE));
    }

    /**
     * @expectedException \Pmclain\Authnet\Exception\InputException
     */
    public function testValidateException()
    {
        TransactionType::validate('invalid string');
    }
}
