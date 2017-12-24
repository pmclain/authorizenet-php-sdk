<?php

namespace Pmclain\Authnet\Test\Unit\PaymentProfile\Payment;

use PHPUnit\Framework\TestCase;
use Pmclain\Authnet\PaymentProfile\Payment\OpaqueData;

class OpaqueDataTest extends TestCase
{
    public function testToArray()
    {
        $descriptor = 'tokenDataDescriptor';
        $value = 'tokenizedValue';
        $expected = [
            OpaqueData::FIELD_DATA_DESCRIPTOR => $descriptor,
            OpaqueData::FIELD_DATA_VALUE => $value,
        ];

        $opaqueData = new OpaqueData();
        $opaqueData->setDataDescriptor($descriptor);
        $opaqueData->setDataValue($value);

        $this->assertEquals($expected, $opaqueData->toArray());
    }

    public function testGetKey()
    {
        $opaqueData = new OpaqueData();

        $this->assertEquals(OpaqueData::KEY, $opaqueData->getKey());
    }

    /**
     * @expectedException \Pmclain\Authnet\Exception\OpaqueDataInformationException
     */
    public function testToArrayException()
    {
        $opaqueData = new OpaqueData();
        $opaqueData->toArray();
    }
}
