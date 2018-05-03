<?php

use App\Models\Item;

class ItemTest extends \PHPUnit\Framework\TestCase

{
    public function testNewInstance()
    {
        $item = new Item('SKU', 'Apple', '4.95');

        $this->assertEquals('SKU', $item->getSku());
        $this->assertEquals('Apple', $item->getName());
        $this->assertEquals('4.95', $item->getPrice());
        
    }
    
}
