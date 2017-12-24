<?php

namespace Pmclain\Authnet\Test\Unit\TransactionRequest;

use PHPUnit\Framework\TestCase;
use Pmclain\Authnet\TransactionRequest\LineItem;

class LineItemTest extends TestCase
{
    public function testToArray()
    {
        $id = '1';
        $unitPrice = 5;
        $qty = 2;
        $name = 'Item';
        $description = 'Newest Widget';
        $taxable = false;

        $item = new LineItem();
        $item->setItemId($id);
        $item->setUnitPrice($unitPrice);
        $item->setQuantity($qty);
        $item->setName($name);
        $item->setDescription($description);
        $item->setTaxable($taxable);

        $output = $item->toArray();
        $this->assertEquals($id, $output[LineItem::FIELD_ITEM_ID]);
        $this->assertEquals($unitPrice, $output[LineItem::FIELD_UNIT_PRICE]);
        $this->assertEquals($qty, $output[LineItem::FIELD_QUANTITY]);
        $this->assertEquals($name, $output[LineItem::FIELD_NAME]);
        $this->assertEquals($description, $output[LineItem::FIELD_DESCRIPTION]);
        $this->assertEquals($taxable, $output[LineItem::FIELD_TAXABLE]);
    }
}
