<?php

declare(strict_types=1);

namespace App\Services;

use Nette;
use Nette\Security\SimpleIdentity;

class Authenticator implements Nette\Security\Authenticator
{
	public function __construct(
		private Nette\Database\Explorer $database,
		private Nette\Security\Passwords $passwords
	) {}

	public function authenticate(string $email, string $password): SimpleIdentity
	{
		$row = $this->database->table('user')
			->where('email', $email)
			->fetch();

		if (!$row) {
			throw new Nette\Security\AuthenticationException('User not found.');
		}

		if (!$this->passwords->verify($password, $row->password)) {
			throw new Nette\Security\AuthenticationException('Invalid password.');
		}

		return new SimpleIdentity(
			$row->id,
			[],
			['name' => $row->name, 'surname' => $row->surname]
		);
	}
}