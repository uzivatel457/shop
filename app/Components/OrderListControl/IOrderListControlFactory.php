<?php

declare(strict_types=1);

namespace App\Components\OrderListControl;

interface IOrderListControlFactory {
	public function create(): OrderListControl;
}