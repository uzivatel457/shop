<?php

declare(strict_types=1);

namespace App\Model\Order;

use App\Exceptions\EmptyOrderException;
use App\Exceptions\ProductNotFoundException;
use App\Model\OrderItem\OrderItemFacade;
use App\Model\Product\ProductFacade;
use Nette;
use Nette\Database\Table\ActiveRow;
use Nette\Security\User;
use Nette\Utils\DateTime;

final class OrderFacade
{
	use Nette\SmartObject;

	public function __construct(
		private Nette\Database\Explorer $database,
		private OrderItemFacade $orderItemFacade,
		private ProductFacade $productFacade,
		private User $user
	) {}


	public function getOrder(int $id)
	{
		return $this->database
			->table('order')
			->get($id);
	}


	public function getOrders(?int $userId = null, ?bool $processed = null, ?int $limit = null)
	{
		$query = $this->database
			->table('order')
			->order('created_at DESC');

		if ($userId) {
			$query->where('user_id', $userId);
		}

		if (!is_null($processed)) {
			if ($processed) {
				$query->where('processed_at NOT', null);
			} else {
				$query->where('processed_at', null);
			}
		}

		if ($limit) {
			$query->limit($limit);
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

	public function setOrderProcessed(int $id) {
		$this->database->table('order')
			->where('id', $id)
			->update([
				'processed_at' => new DateTime()
			]);
	}

	public function convertOrderToArray(ActiveRow $order): array
	{
		$orderArray = $order->toArray();
		$userArray = $order->user->toArray();
		unset($userArray['password']);
		unset($userArray['email']);

		$orderArray['user'] = $userArray;
		unset($orderArray['user_id']);

		$finalOrderArray = $orderArray;

		foreach ($order->related('order_item') as $orderItem) {
			$orderItemArray = $orderItem->toArray();
			$orderItemArray['product'] = $orderItem->product->toArray();
			unset($orderItemArray['order_id']);
			unset($orderItemArray['product_id']);
			$finalOrderArray['items'][] = $orderItemArray;
		}

		return $finalOrderArray;
	}
}