<?php

namespace Offers;
use Interfaces\OfferCart;

class DefaultOffer implements OfferCart
{
    public function applyOffer($quantity, $price)
    {
        return $quantity * $price; // no offer by default
    }
}