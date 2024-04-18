<?php

use PHPUnit\Framework\TestCase;
use Cart\Cart;
use Cart\DefaultDeliveryCart;
use Offers\RedWidgetOffer;

class CartTest extends TestCase
{
    private $cart;
    private $catalogue;
    private $offer;

    protected function setUp(): void
    {
        $this->catalogue = ["R01" => 32.95, "G01" => 24.95, "B01" => 7.95];
        $this->offer = ["R01" => new RedWidgetOffer()];
        $this->cart = new Cart($this->catalogue, new DefaultDeliveryCart(), $this->offer);
    }

    public function testAddAndTotal()
    {
        // Test single product without offers
        $this->cart->add('B01');
        $this->assertEquals(7.95 + 4.95, $this->cart->total());

        // Test multiple similar products with offer
        $this->cart->add('R01');
        $this->cart->add('R01');
        $this->assertEquals((7.95 + 32.95 + (32.95 / 2) + 2.95), $this->cart->total());

        // Test multiple different products
        $this->cart->clearCart();
        $this->cart->add('G01');
        $this->cart->add('B01');
        $this->assertEquals((24.95 + 7.95 + 4.95), $this->cart->total());
    }
}