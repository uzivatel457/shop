<?php

declare(strict_types=1);

namespace App\Components\OrderControl;

interface IOrderControlFactory {
	public function create(): OrderControl;
}