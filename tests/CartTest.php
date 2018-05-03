<?php

use App\Models\Cart;
use App\Models\Item;

class CartTest extends \PHPUnit\Framework\TestCase

{
    public function testIsEmpty()
    {
        $cart = new App\Models\Cart;
        $this->assertEquals(true, $cart->isEmpty());
    }

    public function testIsNotEmpty()
    {
        $cart = new App\Models\Cart;
        $cart = $this->addTestItems($cart, 1);
        $this->assertEquals(false, $cart->isEmpty());
    }

    public function testAddItem()
    {
        $cart = new App\Models\Cart;
        $cart = $this->addTestItems($cart, 1);

        $i = 1;
        foreach ($cart as $item) {
            $this->assertEquals("SKU_$i", $item['item']->getSku());
            $this->assertEquals("Apple $i", $item['item']->getName());
            $this->assertEquals("4.95$i", $item['item']->getPrice());
            $i++;
        }
        
    }

    public function testAddAnotherItem()
    {
        $cart = new App\Models\Cart;
        $cart = $this->addAnotherTestItems($cart, 1);

        $k = 1;
        foreach ($cart as $item) {
            $this->assertEquals("SKU_$k", $item['item']->getSku());
            $this->assertEquals("Orange $k", $item['item']->getName());
            $this->assertEquals("3.99$k", $item['item']->getPrice());
            $k++;
        }
    }

    public function testfirstTotal()
    {
        $cart = new App\Models\Cart;

        $cart = $this->addTestItems($cart, 2);
        $this->assertEquals('9.90', $cart->total());

        $cart = $this->addAnotherTestItems($cart, 1);
        $this->assertEquals('13.89', $cart->total());
        
    }

    public function testsecondTotalAfterRemovingItems()
    {
        $cart = new App\Models\Cart;

        $cart = $this->addTestItems($cart, 3);
        $this->assertEquals('14.85', $cart->total());
        
        $cart->deleteItem($cart->getItem('SKU_1')['item']);
        $this->assertEquals([], $cart->getItem('SKU_1'));

        $i = 0;
        foreach ($cart as $key => $item) {
            $this->assertEquals($i, $key);
            $i++;
        }
        $this->assertEquals(2, $i);
        $this->assertEquals('9.90', $cart->total());
    }    
   
    private function addTestItems(Cart $cart, $num, $unique = true)
    {
        $first = count($cart) + 1;
        for ($i = 1, $id = $first; $i <= $num; $i++, $id++) {
            $id = $unique ? $id : 0;
            $cart->addItem(new Item("SKU_$id", "Apple $id", "4.95$id"));
            
        }
        return $cart;
    }

    private function addAnotherTestItems(Cart $cart, $num, $unique = true)
    {
        $second = count($cart) + 1;
        for ($k = 1, $id = $second; $k <= $num; $k++, $id++) {
            $id = $unique ? $id : 0;
            $cart->addItem(new Item("SKU_$id", "Orange $id", "3.99$id"));
            
        }
        return $cart;
    }

}
