<?php

namespace Pmclain\Authnet\Test\Integration\Request;

use PHPUnit\Framework\TestCase;
use Pmclain\Authnet\CustomerProfile;
use Pmclain\Authnet\MerchantAuthentication;
use Pmclain\Authnet\Request\CreateCustomerProfile;
use Pmclain\Authnet\PaymentProfile;
use Pmclain\Authnet\Request\DeleteCustomerProfile;

class CreateCustomerProfileTest extends TestCase
{
    /**
     * @var MerchantAuthentication
     */
    private $merchantAuth;

    /**
     * @var string
     */
    private $profileId;

    /**
     * @var CustomerProfile
     */
    private $customerProfile;

    /**
     * @var PaymentProfile
     */
    private $paymentProfile;

    protected function setUp()
    {
        $this->merchantAuth = new MerchantAuthentication(
            AUTHORIZENET_API_LOGIN_ID,
            AUTHORIZENET_TRANSACTION_KEY
        );
    }

    protected function tearDown()
    {
        $deleteCustomerRequest = new DeleteCustomerProfile(true);
        $deleteCustomerRequest->setMerchantAuthentication($this->merchantAuth);
        $deleteCustomerRequest->setCustomerProfileId($this->profileId);
        $deleteCustomerRequest->submit();
    }

    public function testSubmit()
    {
        $request = new CreateCustomerProfile(true);
        $request->setMerchantAuthentication($this->merchantAuth);

        $customerProfile = new CustomerProfile();
        $customerProfile->setEmail(sprintf('user_%s@example.com', (string)mt_rand()));
        $request->setProfile($customerProfile);

        $result = $request->submit();
        $this->assertTrue(isset($result['customerProfileId']));

        $this->profileId = $result['customerProfileId'];
    }
}
