<?php

namespace App\Models;

class Item

{
    /**
     * Item Stock Keeping Unit
     *
     * @var string $sku
     */
    protected $sku;

    /**
     * Item name
     *
     * @var string $name
     */
    protected $name;

    /**
     * Item price
     *
     * @var string $price
     */
    protected $price;

    /**
     * @param string $sku Item Stock Keeping Unit
     * @param string $name Item name
     * @param string $price Item price 
     *
     */
    public function __construct($sku, $name, $price)
    {
        $this->setSku($sku);
        $this->setName($name);
        $this->setPrice($price);
        
    }

    // Set Variables

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = (string)$name;
    }

    /**
     * @param string $sku
     */
    public function setSku($sku)
    {
        $this->sku = (string)$sku;
    }

    /**
     * @param string $price 

     */
    public function setPrice($price)
    {
        $this->price = (string)$price;
    }   

    // Get Variables

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return string
     */
   
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
