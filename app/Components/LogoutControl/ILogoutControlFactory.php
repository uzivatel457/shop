<?php

declare(strict_types=1);

namespace App\Components\LogoutControl;

interface ILogoutControlFactory {
	public function create(): LogoutControl;
}