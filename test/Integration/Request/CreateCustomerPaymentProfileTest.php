<?php

namespace Pmclain\Authnet\Test\Integration\Request;

use PHPUnit\Framework\TestCase;
use Pmclain\Authnet\MerchantAuthentication;
use Pmclain\Authnet\Request\DeleteCustomerProfile;
use Pmclain\Authnet\Request\CreateCustomerProfile;
use Pmclain\Authnet\CustomerProfile;
use Pmclain\Authnet\PaymentProfile;
use Pmclain\Authnet\PaymentProfile\Payment\CreditCard;
use Pmclain\Authnet\Request\CreateCustomerPaymentProfile;

class CreateCustomerPaymentProfileTest extends TestCase
{
    const CARD_VISA = '4111111111111111';
    const CARD_DISCOVER = '6011000000000012';
    const CARD_MASTERCARD = '5424000000000015';
    const CARD_AMEX = '370000000000002';

    /**
     * @var MerchantAuthentication
     */
    private $merchantAuth;

    /**
     * @var string
     */
    private $customerProfileId;

    protected function setUp()
    {
        $this->merchantAuth = new MerchantAuthentication(
            AUTHORIZENET_API_LOGIN_ID,
            AUTHORIZENET_TRANSACTION_KEY
        );

        $createCustomerRequest = new CreateCustomerProfile(true);
        $createCustomerRequest->setMerchantAuthentication($this->merchantAuth);

        $customerProfile = new CustomerProfile();
        $customerProfile->setEmail($this->createEmail());
        $createCustomerRequest->setProfile($customerProfile);

        $result = $createCustomerRequest->submit();
        $this->customerProfileId = $result['customerProfileId'];
    }

    protected function tearDown()
    {
        $deleteCustomerRequest = new DeleteCustomerProfile(true);
        $deleteCustomerRequest->setMerchantAuthentication($this->merchantAuth);
        $deleteCustomerRequest->setCustomerProfileId($this->customerProfileId);
        $deleteCustomerRequest->submit();
    }

    /**
     * @param string|int $cardNumber
     * @dataProvider cardNumberDataProvider
     */
    public function testSubmit($cardNumber)
    {
        $request = new CreateCustomerPaymentProfile(true);
        $request->setMerchantAuthentication($this->merchantAuth);

        $payment = new CreditCard();
        $payment->setCardNumber($cardNumber);
        $payment->setExpirationDate($this->getExpiration());

        $paymentProfile = new PaymentProfile();
        $paymentProfile->setPayment($payment);

        $request->setPaymentProfile($paymentProfile);
        $request->setCustomerProfileId($this->customerProfileId);

        $result = $request->submit();
        $this->assertTrue(isset($result['customerPaymentProfileId']));
    }

    public function cardNumberDataProvider()
    {
        return [
            'visa' => [
                self::CARD_VISA,
            ],
            'mastercard' => [
                self::CARD_MASTERCARD,
            ],
            'discover' => [
                self::CARD_DISCOVER,
            ],
            'amex' => [
                self::CARD_AMEX,
            ],
        ];
    }

    /**
     * @return string
     */
    private function createEmail()
    {
        return sprintf('user_%s@example.com', (string)mt_rand());
    }

    /**
     * @return string
     */
    private function getExpiration()
    {
        return date('Y-m', strtotime('+1 year'));
    }
}
