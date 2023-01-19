<?php

declare(strict_types=1);

namespace App\Components\RegisterControl;

use App\Model\User\UserFacade;
use App\Model\User\UserInput;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;


final class RegisterControl extends Control
{
	public function __construct(private UserFacade $userFacade) {}

	public function render() {
		$this->template->render(__DIR__ . '/template.latte');
	}

	protected function createComponentRegisterForm(): Form
	{
		$form = new Form;
		$form->setMappedType(UserInput::class);

		$form->addText('name', 'Name:')
			->setRequired('Please enter your name.');

		$form->addText('surname', 'Surname:')
			->setRequired('Please enter your surname.');

		$form->addEmail('email', 'Email:')
			->setRequired('Please enter your email.');

		$form->addPassword('password', 'Password:')
			->setRequired('Please enter your password.');

		$form->addSubmit('send', 'Register');

		$form->onSuccess[] = [$this, 'registerFormSucceeded'];
		return $form;
	}


	public function registerFormSucceeded(Form $form, UserInput $userInput): void
	{
		$this->userFacade->register($userInput);
		$this->presenter->flashMessage('You have been registered. Now you can log in.');
		$this->redirect('this');
	}
}