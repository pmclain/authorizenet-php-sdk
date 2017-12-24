<?php

namespace Pmclain\Authnet\Test\Unit\TransactionRequest;

use PHPUnit\Framework\TestCase;
use Pmclain\Authnet\TransactionRequest\TaxDutyShipping;

class TaxDutyShippingTest extends TestCase
{
    public function testToArrayWithoutDescription()
    {
        $amount = 5.01;
        $name = 'Sales Tax';

        $tax = new TaxDutyShipping();
        $tax->setAmount($amount);
        $tax->setName($name);

        $output = $tax->toArray();

        $this->assertEquals($amount, $output[TaxDutyShipping::FIELD_AMOUNT]);
        $this->assertEquals($name, $output[TaxDutyShipping::FIELD_NAME]);
    }

    public function testToArray()
    {
        $amount = 5.01;
        $name = 'Sales Tax';
        $description = 'For state locality.';

        $tax = new TaxDutyShipping();
        $tax->setAmount($amount);
        $tax->setName($name);
        $tax->setDescription($description);

        $output = $tax->toArray();

        $this->assertEquals($amount, $output[TaxDutyShipping::FIELD_AMOUNT]);
        $this->assertEquals($name, $output[TaxDutyShipping::FIELD_NAME]);
        $this->assertEquals($description, $output[TaxDutyShipping::FIELD_DESCRIPTION]);
    }
}
