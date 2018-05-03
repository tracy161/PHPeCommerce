<?php

namespace App\Models;

use Countable;
use Iterator;

class Cart implements Iterator, Countable

{
    /**
     * Array stores the list of items in the cart
     *
     * @var array $items
     */
    protected $items = [];

    /**
     * For tracking iterations
     *
     * @var int $position
     */
    protected $position = 0;

    /**
     * For storing the Stock Keeping Units, as a convenience
     *
     * @var array $skus
     */
    protected $skus = [];
    

    /**
     * Returns a Boolean indicating if the cart is empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * Gets an item with given SKU from the cart
     *
     * @param string $sku
     *
     * @return array
     */
    public function getItem($sku)
    {
        if (isset($this->items[$sku])) {
            $item = $this->items[$sku];
        } else {
            $item = [];
        }

        return $item;
    }

    /**
     * Adds a new item to the cart
     *
     * @param Item $item
     */
    public function addItem(Item $item)
    {
        $sku = $item->getSku();

        if (isset($this->items[$sku])) {
            $this->updateItem($item, $this->items[$sku]['qty'] + 1);
        } else {
            $this->items[$sku] = array('item' => $item, 'qty' => 1);
            $this->skus[] = $sku;
        }
    }
    /**
     * Removes an item from the cart
     *
     * @param Item $item
     */
    public function deleteItem(Item $item)
    {
        $sku = $item->getSku();

        if (isset($this->items[$sku])) {
            unset($this->items[$sku]);

            $index = array_search($sku, $this->skus);
            unset($this->skus[$index]);

            // Recreate array to prevent holes:
            $this->skus = array_values($this->skus);
        }
    }

    /**
     * Get the total price of all the cart items
     *
     * @return string
     */
    public function total()
    {
        $sum = '0.00';
        foreach ($this->items as $item) {
            $price = bcmul($item['item']->getPrice(), (string)$item['qty'], 2);
            $sum = bcadd($sum, $price, 2);
        }
        return $sum;
    }
    /**
     * Count all items; required by Countable
     *
     * @return int
     */
    public function count()
    {
        $num = 0;
        foreach ($this->items as $item) {
            $num += $item['qty'];
        }

        return $num;
    }


    /**
     * Required by Iterator; returns the current value
     *
     * @return array
     */
    public function current()
    {
        $index = $this->skus[$this->position];

        return $this->items[$index];
    }

    /**
     * Required by Iterator; returns the current key
     *
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Required by Iterator; increments the position
     */
    public function next()
    {
        $this->position++;
    }

    /**
     * Required by Iterator; returns the position to the first spot
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Required by Iterator; returns a Boolean indiating if a value is indexed at this position
     *
     * @return bool
     */
    public function valid()
    {
        return (isset($this->skus[$this->position]));
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
