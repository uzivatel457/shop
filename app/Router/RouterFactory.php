<?php

declare(strict_types=1);

namespace App\Router;

use Contributte\ApiRouter\ApiRoute;
use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;

		$router[] = new ApiRoute('/api/orders/<id>', 'Api:Orders', [
			'methods' => ['GET' => 'detail'],
			'parameters' => ['id' => ['requirement' => '\d+']]
		]);

		$router[] = new ApiRoute('/api/orders/<id>/set-processed', 'Api:Orders', [
			'methods' => ['POST' => 'setProcessed', 'GET' => 'setProcessed'], // comment GET method
			'parameters' => ['id' => ['requirement' => '\d+']]
		]);

		$router->addRoute('<presenter>/<action>[/<id>]', 'Homepage:default');
		return $router;
	}
}
