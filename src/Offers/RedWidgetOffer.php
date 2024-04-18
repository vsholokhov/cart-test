<?php
namespace Offers;
use Interfaces\OfferCart;

class RedWidgetOffer implements OfferCart
{
    public function applyOffer($quantity, $price)
    {
        $fullPriceQuantity = ceil($quantity / 2);
        $halfPriceQuantity = floor($quantity / 2);
        return $fullPriceQuantity * $price + $halfPriceQuantity * $price / 2;
    }
}