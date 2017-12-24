<?php

namespace Pmclain\Authnet\Test\Unit\PaymentProfile;

use PHPUnit\Framework\TestCase;
use Pmclain\Authnet\ValidationMode;

class ValidationModeTest extends TestCase
{
    public function testGet()
    {
        $validationMode = new ValidationMode();
        $validationMode->set(ValidationMode::TEST);

        $this->assertEquals(ValidationMode::TEST, $validationMode->get());
    }

    /**
     * @covers \Pmclain\Authnet\PaymentProfile\ValidationMode::set()
     * @expectedException \Pmclain\Authnet\Exception\InputException
     */
    public function testSetException()
    {
        $validationMode = new ValidationMode();
        $validationMode->set('invalid value');
    }
}
