<?php

declare(strict_types=1);

namespace App\Components\LogoutControl;

use Nette\Application\UI\Control;
use Nette\Security\User;

final class LogoutControl extends Control
{
	private User $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function render() {
		$this->template->render(__DIR__ . '/template.latte');
	}

	public function handleOut(): void
	{
		$this->user->logout();
		$this->presenter->flashMessage('You have been signed out.');
		$this->redirect('this');
	}
}