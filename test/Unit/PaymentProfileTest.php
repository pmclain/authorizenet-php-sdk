<?php

namespace Pmclain\Authnet\Test\Unit;

use PHPUnit\Framework\TestCase;
use Pmclain\Authnet\PaymentProfile;

class PaymentProfileTest extends TestCase
{
    public function testToArray()
    {
        $paymentArray = [PaymentProfile\Payment\CreditCard::FIELD_CARD_NUMBER => 4111111111111111];
        $billToArray = [
            PaymentProfile\Address::FIELD_FIRSTNAME => 'John',
            PaymentProfile\Address::FIELD_LASTNAME => 'Doe',
        ];

        $payment = $this->getMockBuilder(PaymentProfile\Payment\PaymentInterface::class)->getMock();
        $payment->expects($this->once())
            ->method('getKey')
            ->willReturn(PaymentProfile\Payment\CreditCard::KEY);
        $payment->expects($this->once())
            ->method('toArray')
            ->willReturn($paymentArray);

        $billTo = $this->getMockBuilder(PaymentProfile\Address::class)->getMock();
        $billTo->expects($this->once())
            ->method('toArray')
            ->willReturn($billToArray);

        $profile = new PaymentProfile();
        $profile->setPayment($payment);
        $profile->setBillTo($billTo);
        $profile->setCustomerType(PaymentProfile\CustomerType::INDIVIDUAL);

        $out = $profile->toArray();
        $this->assertEquals(PaymentProfile\CustomerType::INDIVIDUAL, $out[PaymentProfile::FIELD_CUSTOMER_TYPE]);
        $this->assertEquals($billToArray, $out[PaymentProfile::FIELD_BILL_TO]);
        $this->assertEquals($paymentArray, $out[PaymentProfile::FIELD_PAYMENT][PaymentProfile\Payment\CreditCard::KEY]);
    }
}
