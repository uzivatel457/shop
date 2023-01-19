<?php

declare(strict_types=1);

namespace App\Components\LoginControl;

use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;
use Nette\Security\User;

final class LoginControl extends Control
{
	private User $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function render() {
		$this->template->render(__DIR__ . '/template.latte');
	}

	protected function createComponentLoginForm(): Form
	{
		$form = new Form;
		$form->addText('email', 'Email:')
			->setRequired('Please enter your email.');

		$form->addPassword('password', 'Password:')
			->setRequired('Please enter your password.');

		$form->addSubmit('send', 'Log in');

		$form->onSuccess[] = [$this, 'loginFormSucceeded'];
		return $form;
	}


	public function loginFormSucceeded(Form $form, \stdClass $data): void
	{
		try {
			$this->user->login($data->email, $data->password);
			$this->presenter->flashMessage('You have been logged in.');
			$this->redirect('this');

		} catch (AuthenticationException $e) {
			$form->addError('Incorrect username or password.');
		}
	}
}