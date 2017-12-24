<?php

namespace Pmclain\Authnet\Test\Unit\TransactionRequest;

use PHPUnit\Framework\TestCase;
use Pmclain\Authnet\TransactionRequest\Order;

class OrderTest extends TestCase
{
    public function testToArray()
    {
        $invoiceNumber = '1234567';
        $description = 'Your order description';

        $order = new Order();
        $order->setInvoiceNumber($invoiceNumber);
        $order->setDescription($description);

        $output = $order->toArray();
        $this->assertEquals($invoiceNumber, $output[Order::FIELD_INVOICE_NUMBER]);
        $this->assertEquals($description, $output[Order::FIELD_DESCRIPTION]);
    }
}
