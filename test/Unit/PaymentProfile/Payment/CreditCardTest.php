<?php

namespace Pmclain\Authnet\Test\Unit\PaymentProfile\Payment;

use PHPUnit\Framework\TestCase;
use Pmclain\Authnet\PaymentProfile\Payment\CreditCard;

class CreditCardTest extends TestCase
{
    /**
     * @param $expected
     * @param $cardInfo
     * @dataProvider toArrayDataProvider
     */
    public function testToArray($expected, $cardInfo)
    {
        $creditCard = new CreditCard();
        $creditCard->setCardNumber($cardInfo[0]);
        $creditCard->setExpirationDate($cardInfo[1]);
        isset($cardInfo[2]) ? $creditCard->setCardCode($cardInfo[2]) : null ;

        $this->assertEquals($expected, $creditCard->toArray());
    }

    public function testGetKey()
    {
        $creditCard = new CreditCard();

        $this->assertEquals(CreditCard::KEY, $creditCard->getKey());
    }

    /**
     * @expectedException \Pmclain\Authnet\Exception\CardInformationException
     */
    public function testToArrayException()
    {
        $creditCard = new CreditCard();
        $creditCard->toArray();
    }

    public function toArrayDataProvider()
    {
        $cardNumber = 4111111111111111;
        $expiration = '2019-05';
        $cvv = 123;

        return [
            'card_with_cvv' => [
                [
                    CreditCard::FIELD_CARD_NUMBER => $cardNumber,
                    CreditCard::FIELD_EXPIRATION_DATE => $expiration,
                    CreditCard::FIELD_CARD_CODE => $cvv,
                ],
                [
                    $cardNumber,
                    $expiration,
                    $cvv,
                ],
            ],
            'card_without_cvv' => [
                [
                    CreditCard::FIELD_CARD_NUMBER => $cardNumber,
                    CreditCard::FIELD_EXPIRATION_DATE => $expiration,
                ],
                [
                    $cardNumber,
                    $expiration,
                ],
            ],
        ];
    }
}
