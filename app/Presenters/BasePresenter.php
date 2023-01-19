<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Components\LoginControl\ILoginControlFactory;
use App\Components\LoginControl\LoginControl;
use App\Components\LogoutControl\ILogoutControlFactory;
use App\Components\LogoutControl\LogoutControl;
use App\Components\RegisterControl\IRegisterControlFactory;
use App\Components\RegisterControl\RegisterControl;
use Nette;


abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	/** @inject */
	public IRegisterControlFactory $registerControlFactory;

	/** @inject */
	public ILoginControlFactory $loginControlFactory;

	/** @inject */
	public ILogoutControlFactory $logoutControlFactory;

	public function createComponentRegisterControl(): RegisterControl
	{
		return $this->registerControlFactory->create();
	}

	public function createComponentLoginControl(): LoginControl
	{
		return $this->loginControlFactory->create();
	}

	public function createComponentLogoutControl(): LogoutControl
	{
		return $this->logoutControlFactory->create();
	}
}
