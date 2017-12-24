<?php

namespace Pmclain\Authnet;

class CustomerProfile
{
    const FIELD_CUSTOMER_ID = 'merchantCustomerId';
    const FIELD_DESCRIPTION = 'description';
    const FIELD_EMAIL = 'email';
    const FIELD_PAYMENT_PROFILES = 'paymentProfiles';

    /**
     * @var string
     */
    private $merchantCustomerId;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $email;

    /**
     * @var PaymentProfile
     */
    private $paymentProfile;

    /**
     * @param string $merchantCustomerId
     * @return $this
     */
    public function setCustomerId($merchantCustomerId)
    {
        $this->merchantCustomerId = $merchantCustomerId;
        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param PaymentProfile $paymentProfile
     * @return $this
     */
    public function setPaymentProfile(PaymentProfile $paymentProfile)
    {
        $this->paymentProfile = $paymentProfile;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];
        if (isset($this->email)) {
            $result[self::FIELD_EMAIL] = $this->email;
        }
        if (isset($this->description)) {
            $result[self::FIELD_DESCRIPTION] = $this->description;
        }
        if (isset($this->paymentProfile)) {
            $result[self::FIELD_PAYMENT_PROFILES] = $this->paymentProfile->toArray();
        }

        return $result;
    }
}
