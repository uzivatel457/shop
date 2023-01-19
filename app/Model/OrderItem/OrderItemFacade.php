<?php

declare(strict_types=1);

namespace App\Model\OrderItem;

use App\Model\Product\ProductFacade;
use Nette;

final class OrderItemFacade
{
	use Nette\SmartObject;

	public function __construct(
		private Nette\Database\Explorer $database,
		private ProductFacade $productFacade
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

	public function createOrderItem(int $orderId, int $productId, int $quantity)
	{
		$product = $this->productFacade->getProductById($productId)->fetch();

		return $this->database
			->table('order_item')->insert([
				'order_id' => $orderId,
				'product_id' => $productId,
				'buy_price' => $product->price,
				'quantity' => $quantity,
			]);
	}
}