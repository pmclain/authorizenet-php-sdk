<?php

namespace Pmclain\Authnet\Test\Unit\PaymentProfile;

use PHPUnit\Framework\TestCase;
use Pmclain\Authnet\PaymentProfile\Address;

class AddressTest extends TestCase
{
    public function testToArray()
    {
        $firstname = 'John';
        $lastname = 'Doe';
        $company = 'Not Evil Co.';
        $street = '123 Abc St';
        $city = 'Nowhere';
        $state = 'MI';
        $zip = '12345';
        $country = 'US';
        $phone = '(555) 555-5555';
        $fax = '(555) 555-1234';

        $address = new Address();
        $address->setFirstname($firstname);
        $address->setLastname($lastname);
        $address->setCompany($company);
        $address->setAddress($street);
        $address->setCity($city);
        $address->setState($state);
        $address->setZip($zip);
        $address->setCountry($country);
        $address->setPhoneNumber($phone);
        $address->setFaxNumber($fax);

        $out = $address->toArray();
        $this->assertEquals($firstname, $out[Address::FIELD_FIRSTNAME]);
        $this->assertEquals($lastname, $out[Address::FIELD_LASTNAME]);
        $this->assertEquals($company, $out[Address::FIELD_COMPANY]);
        $this->assertEquals($street, $out[Address::FIELD_ADDRESS]);
        $this->assertEquals($city, $out[Address::FIELD_CITY]);
        $this->assertEquals($state, $out[Address::FIELD_STATE]);
        $this->assertEquals($zip, $out[Address::FIELD_ZIP]);
        $this->assertEquals($country, $out[Address::FIELD_COUNTRY]);
        $this->assertEquals($phone, $out[Address::FIELD_PHONE_NUMBER]);
        $this->assertEquals($fax, $out[Address::FIELD_FAX_NUMBER]);
    }
}
