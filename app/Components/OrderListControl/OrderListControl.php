<?php

declare(strict_types=1);

namespace App\Components\OrderListControl;

use App\Model\Order\OrderFacade;
use Nette\Application\UI\Control;
use Nette\Security\User;

final class OrderListControl extends Control
{
	public function __construct(private User $user, private OrderFacade $orderFacade) {}

	public function render() {
		$this->template->lastOrders = $this->orderFacade->getOrders($this->user->id, null, 3);
		$pendingOrders = $this->orderFacade->getOrders($this->user->id, false);

		$totalPendingPrice = 0;
		foreach ($pendingOrders as $order) {
			$totalPendingPrice += $order->total_price;
		}

		$this->template->totalPendingPrice = $totalPendingPrice;
		$this->template->render(__DIR__ . '/template.latte');
	}
}
