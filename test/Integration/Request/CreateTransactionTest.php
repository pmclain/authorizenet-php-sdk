<?php

namespace Pmclain\Authnet\Test\Integration\Request;

use PHPUnit\Framework\TestCase;
use Pmclain\Authnet\CustomerProfile;
use Pmclain\Authnet\MerchantAuthentication;
use Pmclain\Authnet\PaymentProfile\Payment\CreditCard;
use Pmclain\Authnet\Request\CreateTransaction;
use Pmclain\Authnet\Request\DeleteCustomerProfile;
use Pmclain\Authnet\TransactionRequest;

class CreateTransactionTest extends TestCase
{
    /**
     * @var CreateTransaction
     */
    private $request;

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

        $this->request = new CreateTransaction(true);
        $this->request->setMerchantAuthentication($this->merchantAuth);
    }

    protected function tearDown()
    {
        if (!isset($this->profileId)) {
            return;
        }

        $deleteRequest = new DeleteCustomerProfile(true);
        $deleteRequest->setMerchantAuthentication($this->merchantAuth);
        $deleteRequest->setCustomerProfileId($this->profileId);
        $deleteRequest->submit();
    }

    public function testSubmit()
    {
        $transaction = new TransactionRequest();
        $transaction->setTransactionType(TransactionRequest\TransactionType::TYPE_AUTH_CAPTURE);
        $transaction->setAmount(mt_rand(1, 100));

        $payment = new CreditCard();
        $payment->setCardNumber(4111111111111111);
        $payment->setExpirationDate('2022-03');
        $payment->setCardCode(123);
        $transaction->setPayment($payment);

        $this->request->setTransactionRequest($transaction);

        $result = json_decode($this->request->submit(), true);
        $this->assertEquals('Ok', $result['messages']['resultCode']);
    }

    public function testSubmitCreateProfile()
    {
        $transaction = new TransactionRequest();
        $transaction->setTransactionType(TransactionRequest\TransactionType::TYPE_AUTH_CAPTURE);
        $transaction->setAmount(mt_rand(1, 100));

        $payment = new CreditCard();
        $payment->setCardNumber(4111111111111111);
        $payment->setExpirationDate('2022-03');
        $payment->setCardCode(123);
        $transaction->setPayment($payment);

        $customer = new CustomerProfile();
        $customer->setEmail(sprintf('user_%s@example.com', (string)mt_rand()));
        $transaction->setCustomer($customer);
        $transaction->setCreateProfile(true);

        $this->request->setTransactionRequest($transaction);

        $result = json_decode($this->request->submit(), true);
        $this->assertEquals('Ok', $result['messages']['resultCode']);
        $this->assertTrue(isset($result['profileResponse']['customerProfileId']));

        $this->profileId = $result['profileResponse']['customerProfileId'];
    }
}
