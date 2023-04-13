<?php

namespace App\Models;

class Cart
{
    public $products = null;
    public $totalMoney = 0;
    public $totalQuantity = 0;
    public function __construct($cart)
    {
        if ($cart) {
            $this->products = $cart->products;
            $this->totalMoney = $cart->totalMoney;
            $this->totalQuantity = $cart->totalQuantity;
        }
    }
    public function AddCart($product, $id, $quantity, $isImport = 0)
    {
        if ($quantity > 0) {
            // $oldquantity = 0;
            $newProduct = ['productInfo' => $product, 'price' => 0, 'quantity' => 0, 'inventoryNumber' => $product['quantity']];
            if ($this->products) {
                if (array_key_exists($id . '_' . $product['idsize'], $this->products)) {
                    $newProduct = $this->products[$id . '_' . $product['idsize']];
                    $this->totalMoney -= floatval($this->products[$id . '_' . $product['idsize']]['price']);
                    $this->totalQuantity -= floatval($this->products[$id . '_' . $product['idsize']]['quantity']);
                    //$oldquantity = floatval($this->products[$id . '_' . $product['idsize']]['quantity']);
                }
            }
            $newProduct['quantity'] += $quantity;
            if (floatval($newProduct['quantity']) > floatval($product['quantity']) && $isImport == 0) {
                $newProduct['quantity'] = floatval($product['quantity']);
            }
            $newProduct['price'] = $newProduct['quantity'] * $product['price'];
            $this->products[$id . '_' . $product['idsize']] = $newProduct;
            $this->totalMoney += floatval($newProduct['price']);
            $this->totalQuantity += floatval($newProduct['quantity']);
            // $this->products[$id . '_' . $product['idsize']]['inventoryNumber'] = $this->products[$id . '_' . $product['idsize']]['inventoryNumber'] + $oldquantity - $newProduct['quantity'];
            return $this->products[$id . '_' . $product['idsize']]['inventoryNumber'] - $this->products[$id . '_' . $product['idsize']]['quantity'];
        }
    }
    public function ChangeProduct($id, $quantity, $size, $isImport = 0)
    {
        if ($this->products) {
            if (array_key_exists($id . '_' . $size, $this->products)) {
                // $oldquantity = 0;
                $this->totalMoney = $this->totalMoney - floatval($this->products[$id . '_' . $size]['price']);
                $this->totalQuantity = $this->totalQuantity - floatval($this->products[$id . '_' . $size]['quantity']);
                //$oldquantity = $this->products[$id . '_' . $size]['quantity'];
                $this->products[$id . '_' . $size]['quantity'] += floatval($quantity);
                if (floatval($this->products[$id . '_' . $size]['quantity']) <= 0) {
                    unset($this->products[$id . '_' . $size]);
                    return 0;
                } else {
                    if (floatval($this->products[$id . '_' . $size]['quantity']) > floatval($this->products[$id . '_' . $size]['inventoryNumber']) && $isImport == 0) {
                        $this->products[$id . '_' . $size]['quantity'] = floatval($this->products[$id . '_' . $size]['inventoryNumber']);
                    }

                    $this->products[$id . '_' . $size]['price'] = floatval($this->products[$id . '_' . $size]['quantity']) * floatval($this->products[$id . '_' . $size]['productInfo']['price']);
                    $this->totalMoney += floatval($this->products[$id . '_' . $size]['price']);
                    $this->totalQuantity += floatval($this->products[$id . '_' . $size]['quantity']);
                    // $this->products[$id . '_' . $size]['inventoryNumber'] = $this->products[$id . '_' . $size]['inventoryNumber'] + $oldquantity - $this->products[$id . '_' . $size]['quantity'];
                    return $this->products[$id . '_' . $size]['inventoryNumber'] - $this->products[$id . '_' . $size]['quantity'];
                }
            }
        }
    }
    public function changeQuantityProduct($id, $quantity, $size, $isImport = 0)
    {

        if ($this->products) {
            if (array_key_exists($id . '_' . $size, $this->products)) {
                // $oldquantity = 0;
                $this->totalMoney -= floatval($this->products[$id . '_' . $size]['price']);
                $this->totalQuantity -= floatval($this->products[$id . '_' . $size]['quantity']);
                //$oldquantity = $this->products[$id . '_' . $size]['quantity'];
                $this->products[$id . '_' . $size]['quantity'] = floatval($quantity);
                if (floatval($this->products[$id . '_' . $size]['quantity']) <= 0) {
                    unset($this->products[$id . '_' . $size]);
                    return 0;
                } else {
                    if (floatval($this->products[$id . '_' . $size]['quantity']) > floatval($this->products[$id . '_' . $size]['inventoryNumber']) && $isImport == 0) {
                        $this->products[$id . '_' . $size]['quantity'] = floatval($this->products[$id . '_' . $size]['inventoryNumber']);
                    }
                    $this->products[$id . '_' . $size]['price'] = floatval($this->products[$id . '_' . $size]['quantity']) * floatval($this->products[$id . '_' . $size]['productInfo']['price']);
                    $this->totalMoney += floatval($this->products[$id . '_' . $size]['price']);
                    $this->totalQuantity += floatval($this->products[$id . '_' . $size]['quantity']);
                    //$this->products[$id . '_' . $size]['inventoryNumber'] = $this->products[$id . '_' . $size]['inventoryNumber'] + $oldquantity - $this->products[$id . '_' . $size]['quantity'];
                    return $this->products[$id . '_' . $size]['inventoryNumber'] - $this->products[$id . '_' . $size]['quantity'];
                }
                //dd($this->totalMoney); //, $this->products[$id . '_' . $size]['price']);
            }
        }
    }
    public function removeProductInCart($id, $size)
    {
        if ($this->products[$id . '_' . $size]) {
            $this->totalMoney -= floatval($this->products[$id . '_' . $size]['price']);
            $this->totalQuantity -= floatval($this->products[$id . '_' . $size]['quantity']);
            //$quantity = $this->updateQuantity($this->products[$id . '_' . $size]['quantity'], 0, $id, $size);
            unset($this->products[$id . '_' . $size]);
            // return $quantity;
        }
    }
    public function removeCart()
    {
        foreach ($this->products as $item) {
            $this->updateQuantity($item['quantity'], 0, $item['productInfo']['idProductDetail'], $item['productInfo']['idsize']);
        }
    }
    public function updateQuantity($oldquantity, $newquanity, $id, $size)
    {
        $product = ProductSize::where('id_productdetail', $id)->where('size', $size)->first();
        ProductSize::where('id_productdetail', $id)->where('size', $size)->update(['quantity' => $product->quantity + $oldquantity - $newquanity]);
        return  ProductSize::where('id_productdetail', $id)->where('size', $size)->first()->quantity;
        //dd($product);
    }
    public function getTotalMoney()
    {
        return $this->totalMoney;
    }
    public function getTotalQuantity()
    {
        return $this->totalQuantity;
    }
    public function getProductInCart()
    {
        return $this->products;
    }
}
