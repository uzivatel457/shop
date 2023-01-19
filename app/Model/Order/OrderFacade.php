<?php

declare(strict_types=1);

namespace App\Model\Order;

use App\Exceptions\EmptyOrderException;
use App\Exceptions\ProductNotFoundException;
use App\Model\OrderItem\OrderItemFacade;
use App\Model\Product\ProductFacade;
use Nette;
use Nette\Security\User;

final class OrderFacade
{
	use Nette\SmartObject;

	public function __construct(
		private Nette\Database\Explorer $database,
		private OrderItemFacade $orderItemFacade,
		private ProductFacade $productFacade,
		private User $user
	) {}


	public function getOrders($userId)
	{
		$query = $this->database
			->table('order')
			->order('created_at DESC');

		if ($userId) {
			$query->where('user_id', $userId);
		}

		return $query;
	}

	public function createOrder(OrderInput $order)
	{
		$totalPrice = 0;

		foreach ($order->orderItems as $productId => $quantity) {
			$product = $this->productFacade->getProductById($productId)->fetch();

			if (!$product) {
				throw new ProductNotFoundException($productId);
			}

			$totalPrice += $product->price * $quantity;
		};

		if (!$totalPrice) {
			throw new EmptyOrderException();
		}

		$insertedOrder = $this->database
			->table('order')->insert([
				'user_id' => $this->user->id,
				'total_price' => $totalPrice,
			]);

		foreach ($order->orderItems as $productId => $quantity) {
			if ($quantity) {
				$this->orderItemFacade->createOrderItem($insertedOrder->id, $productId, $quantity);
			}
		}
	}
}