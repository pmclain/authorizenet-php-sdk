<?php

namespace Pmclain\Authnet\Test\Integration\Request;

use PHPUnit\Framework\TestCase;
use Pmclain\Authnet\MerchantAuthentication;
use Pmclain\Authnet\Request\DeleteCustomerProfile;
use Pmclain\Authnet\Request\CreateCustomerProfile;
use Pmclain\Authnet\CustomerProfile;

class DeleteCustomerProfileTest extends TestCase
{
    /**
     * @var MerchantAuthentication
     */
    private $merchantAuth;

    /**
     * @var string
     */
    private $profileId;

    protected function setUp()
    {
        $this->merchantAuth = new MerchantAuthentication(
            AUTHORIZENET_API_LOGIN_ID,
            AUTHORIZENET_TRANSACTION_KEY
        );

        $createCustomerRequest = new CreateCustomerProfile(true);
        $createCustomerRequest->setMerchantAuthentication($this->merchantAuth);

        $customerProfile = new CustomerProfile();
        $customerProfile->setEmail(sprintf('user_%s@example.com', (string)mt_rand()));
        $createCustomerRequest->setProfile($customerProfile);

        $result = $createCustomerRequest->submit();
        $this->profileId = $result['customerProfileId'];
    }

    public function testSubmit()
    {
        $request = new DeleteCustomerProfile(true);
        $request->setMerchantAuthentication($this->merchantAuth);
        $request->setCustomerProfileId($this->profileId);

        $result = $request->submit();
        $this->assertEquals('Ok', $result['messages']['resultCode']);
    }
}
