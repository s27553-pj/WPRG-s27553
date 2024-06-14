<?php

class Product {
    private $name;
    private $price;
    private $quantity;

    public function __construct($name, $price, $quantity) {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price): void {
        $this->price = $price;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity): void {
        $this->quantity = $quantity;
    }

    public function __toString() {
        return "Product: $this->name, Price: $this->price, Quantity: $this->quantity";
    }
}

class Cart {
    private $products;

    public function __construct() {
        $this->products = [];
    }

    public function addProduct(Product $product): void {
        $this->products[] = $product;
    }

    public function removeProduct(Product $product): void {
        foreach ($this->products as $key => $p) {
            if ($p == $product) {
                unset($this->products[$key]);
                $this->products = array_values($this->products);
                break;
            }
        }
    }

    public function getTotal() {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->getPrice() * $product->getQuantity();
        }
        return $total;
    }

    public function __toString() {
        $result = "Products in cart:\n";
        foreach ($this->products as $product) {
            $result .= $product . "\n";
        }
        $result .= "Total price: " . $this->getTotal();
        return $result;
    }
}
?>
