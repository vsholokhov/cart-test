<?php
namespace Cart;

require __DIR__ . '../../../vendor/autoload.php';

use Interfaces\DeliveryCart;
use Offers\DefaultOffer;
use Offers\RedWidgetOffer;

class DefaultDeliveryCart implements DeliveryCart
{
    public function getShippingCharge($total)
    {
        if ($total < 50) {
            return 4.95;
        } else if ($total < 90) {
            return 2.95;
        } else {
            return 0;
        }
    }
}

class Cart
{
    private $cart = [];
    private $catalogue = [];
    private $deliveryCart;
    private $offer = [];

    public function __construct($catalogue, DeliveryCart $deliveryCart, $offer)
    {
        $this->catalogue = $catalogue;
        $this->deliveryCart = $deliveryCart;
        $this->offer = $offer;
    }

    public function add($productCode) {
        if(!isset($this->cart[$productCode])) {
            $this->cart[$productCode] = 1;
        } else {
            $this->cart[$productCode]++;
        }
    }

    public function total()
    {
        $total = 0;

        foreach ($this->cart as $productCode => $quantity) {
            $offerCart = $this->offer[$productCode] ?? new DefaultOffer();
            $total += $offerCart->applyOffer($quantity, $this->catalogue[$productCode]);
        }

        $total += $this->deliveryCart->getShippingCharge($total);

        return $total;
    }

    public function clearCart() {
        $this->cart = [];
    }
}

$productCatalogue = ["R01" => 32.95, "G01" => 24.95, "B01" => 7.95];
$cart = new cart($productCatalogue, new DefaultDeliveryCart(), ["R01" => new RedWidgetOffer()]);
$cart->add("B01");
$cart->add("G01");

echo $cart->total();