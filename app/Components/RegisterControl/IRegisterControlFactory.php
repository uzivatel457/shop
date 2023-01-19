<?php

declare(strict_types=1);

namespace App\Components\RegisterControl;

interface IRegisterControlFactory {
	public function create(): RegisterControl;
}