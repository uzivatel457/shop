<?php

declare(strict_types=1);

namespace App\Model\User;

use Nette;
use Nette\Security\Passwords;
use Nette\Utils\Random;

final class UserFacade
{
	use Nette\SmartObject;

	public function __construct(private Nette\Database\Explorer $database, private Passwords $passwords) {}

	public function register(UserInput $userInput): string {
		$registerData = (array) $userInput;
		$registerData['code'] = Random::generate(7);
		$registerData['password'] = $this->passwords->hash($userInput->password);;

		$user = $this->database->table('user')->insert($registerData);
		return $user->code;
	}


	public function getUsers()
	{
		return $this->database
			->table('user')
			->order('created_at DESC');
	}
}