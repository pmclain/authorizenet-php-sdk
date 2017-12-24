<?php

namespace Pmclain\Authnet\Test\Unit;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject;
use Pmclain\Authnet\CustomerProfile;
use Pmclain\Authnet\PaymentProfile;

class CustomerProfileTest extends TestCase
{
    public function testToArray()
    {
        $email = 'test@test.com';
        $customerId = '1234';
        $description = 'Customer Description';
        $payment = $this->getMockBuilder(PaymentProfile::class)->getMock();

        $payment->expects($this->once())
            ->method('toArray')
            ->willReturn([]);

        $profile = new CustomerProfile();
        $profile->setEmail($email);
        $profile->setCustomerId($customerId);
        $profile->setDescription($description);
        $profile->setPaymentProfile($payment);

        $out = $profile->toArray();
        $this->assertEquals($email, $out[CustomerProfile::FIELD_EMAIL]);
        $this->assertEquals($customerId, $out[CustomerProfile::FIELD_CUSTOMER_ID]);
        $this->assertEquals($description, $out[CustomerProfile::FIELD_DESCRIPTION]);
        $this->assertEquals([], $out[CustomerProfile::FIELD_PAYMENT_PROFILES]);
    }
}
