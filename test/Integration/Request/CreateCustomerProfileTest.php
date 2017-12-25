<?php

namespace Pmclain\Authnet\Test\Integration\Request;

use PHPUnit\Framework\TestCase;
use Pmclain\Authnet\CustomerProfile;
use Pmclain\Authnet\MerchantAuthentication;
use Pmclain\Authnet\Request\CreateCustomerProfile;
use Pmclain\Authnet\PaymentProfile;
use Pmclain\Authnet\Request\DeleteCustomerProfile;
use Pmclain\Authnet\PaymentProfile\Address;

class CreateCustomerProfileTest extends TestCase
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
    private $profileId;

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
        $customerProfile->setEmail($this->createEmail());
        $request->setProfile($customerProfile);

        $result = $request->submit();
        $this->assertTrue(isset($result['customerProfileId']));

        $this->profileId = $result['customerProfileId'];
    }

    /**
     * @param string $cardNumber
     * @param Address $billTo
     * @param Address $shipTo
     * @dataProvider cardNumberDataProvider
     */
    public function testSubmitCreateWithProfile($cardNumber, $billTo, $shipTo)
    {
        $request = new CreateCustomerProfile(true);
        $request->setMerchantAuthentication($this->merchantAuth);

        $customerProfile = new CustomerProfile();
        $customerProfile->setEmail($this->createEmail());
        $customerProfile->setDescription('Describe Customer');

        $payment = new PaymentProfile\Payment\CreditCard();
        $payment->setCardNumber($cardNumber);
        $payment->setExpirationDate($this->getExpiration());
        $payment->setCardCode(random_int(100, 999));

        $paymentProfile = new PaymentProfile();
        $paymentProfile->setPayment($payment);
        $customerProfile->setPaymentProfile($paymentProfile);

        $request->setProfile($customerProfile);

        $result = $request->submit();
        $this->assertTrue(isset($result['customerProfileId']));

        $this->profileId = $result['customerProfileId'];
    }

    /**
     * @param string $cardNumber
     * @param Address $billTo
     * @param Address $shipTo
     * @dataProvider cardNumberDataProvider
     */
    public function testSubmitCreateWithProfileBillTo($cardNumber, $billTo, $shipTo)
    {
        $request = new CreateCustomerProfile(true);
        $request->setMerchantAuthentication($this->merchantAuth);

        $customerProfile = new CustomerProfile();
        $customerProfile->setEmail($this->createEmail());
        $customerProfile->setDescription('Describe Customer');

        $payment = new PaymentProfile\Payment\CreditCard();
        $payment->setCardNumber($cardNumber);
        $payment->setExpirationDate($this->getExpiration());
        $payment->setCardCode(random_int(100, 999));

        $paymentProfile = new PaymentProfile();
        $paymentProfile->setPayment($payment);
        $paymentProfile->setBillTo($billTo);
        $customerProfile->setPaymentProfile($paymentProfile);

        $request->setProfile($customerProfile);

        $result = $request->submit();
        $this->assertTrue(isset($result['customerProfileId']));

        $this->profileId = $result['customerProfileId'];
    }

    /**
     * @param string $cardNumber
     * @param Address $billTo
     * @param Address $shipTo
     * @dataProvider cardNumberDataProvider
     */
    public function testSubmitCreateWithProfileBillToShipTo($cardNumber, $billTo, $shipTo)
    {
        $request = new CreateCustomerProfile(true);
        $request->setMerchantAuthentication($this->merchantAuth);

        $customerProfile = new CustomerProfile();
        $customerProfile->setEmail($this->createEmail());
        $customerProfile->setDescription('Describe Customer');
        $customerProfile->addShipTo($shipTo);

        $payment = new PaymentProfile\Payment\CreditCard();
        $payment->setCardNumber($cardNumber);
        $payment->setExpirationDate($this->getExpiration());
        $payment->setCardCode(random_int(100, 999));

        $paymentProfile = new PaymentProfile();
        $paymentProfile->setPayment($payment);
        $paymentProfile->setBillTo($billTo);
        $customerProfile->setPaymentProfile($paymentProfile);

        $request->setProfile($customerProfile);

        $result = $request->submit();
        $this->assertTrue(isset($result['customerProfileId']));

        $this->profileId = $result['customerProfileId'];
    }

    public function cardNumberDataProvider()
    {
        return [
            'visa' => [
                self::CARD_VISA,
                $this->getBillToAddress(),
                $this->getShipToAddress(),
            ],
            'mastercard' => [
                self::CARD_MASTERCARD,
                $this->getBillToAddress(),
                $this->getShipToAddress(),
            ],
            'discover' => [
                self::CARD_DISCOVER,
                $this->getBillToAddress(),
                $this->getShipToAddress(),
            ],
            'amex' => [
                self::CARD_AMEX,
                $this->getBillToAddress(),
                $this->getShipToAddress(),
            ],
        ];
    }

    private function getShipToAddress()
    {
        $address = new PaymentProfile\Address();
        $address->setLastname('John');
        $address->setLastname('Doe');
        $address->setCompany('Some Co.');
        $address->setAddress('123 ABC St');
        $address->setCity('Nowhere');
        $address->setState('MI');
        $address->setZip('12345');
        $address->setCountry('US');
        $address->setPhoneNumber('123-123-5555');
        $address->setFaxNumber('555-123-1234');

        return $address;
    }

    private function getBillToAddress()
    {
        $address = new PaymentProfile\Address();
        $address->setLastname('Jane');
        $address->setLastname('Doe');
        $address->setCompany('Some Co.');
        $address->setAddress('123 XYZ St');
        $address->setCity('Nowhere');
        $address->setState('RI');
        $address->setZip('98765');
        $address->setCountry('US');
        $address->setPhoneNumber('123-123-5555');
        $address->setFaxNumber('555-123-1234');

        return $address;
    }

    private function createEmail()
    {
        return sprintf('user_%s@example.com', (string)mt_rand());
    }

    private function getExpiration()
    {
        return date('Y-m', strtotime('+1 year'));
    }
}
