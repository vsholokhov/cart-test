<?php
namespace Interfaces;

interface DeliveryCart{public function getShippingCharge($total);}
interface OfferCart{public function applyOffer($quantity, $price);}
