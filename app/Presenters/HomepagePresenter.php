<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Components\OrderControl\IOrderControlFactory;
use App\Components\OrderControl\OrderControl;
use App\Components\OrderListControl\IOrderListControlFactory;
use App\Components\OrderListControl\OrderListControl;

final class HomepagePresenter extends BasePresenter
{
	/** @inject */
	public IOrderControlFactory $orderControlFactory;

	/** @inject */
	public IOrderListControlFactory $orderHistoryControlFactory;

	protected function createComponentOrderControl(): OrderControl
	{
		return $this->orderControlFactory->create();
	}

	protected function createComponentOrderListControl(): OrderListControl
	{
		return $this->orderHistoryControlFactory->create();
	}
}
