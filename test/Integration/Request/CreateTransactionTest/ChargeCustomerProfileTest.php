<?php

namespace Pmclain\Authnet\Test\Integration\Request\CreateTransactionTest;

use PHPUnit\Framework\TestCase;
use Pmclain\Authnet\CustomerProfile;
use Pmclain\Authnet\MerchantAuthentication;
use Pmclain\Authnet\Request\CreateCustomerProfile;
use Pmclain\Authnet\PaymentProfile;
use Pmclain\Authnet\Request\CreateTransaction;
use Pmclain\Authnet\Request\DeleteCustomerProfile;
use Pmclain\Authnet\PaymentProfile\Address;
use Pmclain\Authnet\TransactionRequest;

class ChargeCustomerProfileTest extends TestCase
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

    /**
     * @var string
     */
    private $paymentProfileId;

    protected function setUp()
    {
        $this->merchantAuth = new MerchantAuthentication(
            AUTHORIZENET_API_LOGIN_ID,
            AUTHORIZENET_TRANSACTION_KEY
        );

        $request = new CreateCustomerProfile(true);
        $request->setMerchantAuthentication($this->merchantAuth);

        $customerProfile = new CustomerProfile();
        $customerProfile->setEmail($this->createEmail());
        $customerProfile->setDescription('Describe Customer');
        $customerProfile->addShipTo($this->getShipToAddress());

        $payment = new PaymentProfile\Payment\CreditCard();
        $payment->setCardNumber(self::CARD_VISA);
        $payment->setExpirationDate($this->getExpiration());
        $payment->setCardCode(random_int(100, 999));

        $paymentProfile = new PaymentProfile();
        $paymentProfile->setPayment($payment);
        $paymentProfile->setBillTo($this->getBillToAddress());
        $customerProfile->setPaymentProfile($paymentProfile);

        $request->setProfile($customerProfile);

        $result = $request->submit();

        $this->profileId = $result['customerProfileId'];
        $this->paymentProfileId = $result['customerPaymentProfileIdList'][0];
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
        $transaction = new TransactionRequest();
        $transaction->setTransactionType(TransactionRequest\TransactionType::TYPE_AUTH_CAPTURE);
        $transaction->setAmount(mt_rand(1, 100));
        $transaction->setCustomerProfileId($this->profileId);
        $transaction->setPaymentProfileId($this->paymentProfileId);

        $request = new CreateTransaction(true);
        $request->setMerchantAuthentication($this->merchantAuth);
        $request->setTransactionRequest($transaction);

        $result = $request->submit();
        $this->assertEquals('Ok', $result['messages']['resultCode']);
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
