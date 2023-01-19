<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Components\OrderControl\IOrderControlFactory;
use App\Components\OrderControl\OrderControl;

final class HomepagePresenter extends BasePresenter
{
	/** @inject */
	public IOrderControlFactory $orderControlFactory;

	protected function createComponentOrderControl(): OrderControl
	{
		return $this->orderControlFactory->create();
	}
}
