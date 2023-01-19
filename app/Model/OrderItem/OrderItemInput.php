<?php

declare(strict_types=1);

namespace App\Model\OrderItem;

final class OrderItemInput
{

	public int $orderId;

	public int $productId;

	public float $buyPrice;

	public int $quantity;

	public function __constructor(int $orderId, int $productId, float $buyPrice, int $quantity) {
		$this->orderId = $orderId;
		$this->productId = $productId;
		$this->buyPrice = $buyPrice;
		$this->quantity = $quantity;
	}
}