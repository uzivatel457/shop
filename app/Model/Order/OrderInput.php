<?php

declare(strict_types=1);

namespace App\Model\Order;

use App\Model\OrderItem\OrderItemInput;

final class OrderInput
{
	/** @var array<string,OrderItemInput> */
	public array $orderItems;
}