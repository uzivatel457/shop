<?php

declare(strict_types=1);

namespace App\ApiModule\Presenters;

use App\Model\Order\OrderFacade;
use Nette\Application\Responses\JsonResponse;
use Nette\Application\UI\Presenter;

class OrdersPresenter extends Presenter
{
	/** @inject */
	public OrderFacade $orderFacade;

	public function actionDetail(int $id)
	{
		$order = $this->orderFacade->getOrder($id);

		if ($order) {
			$response = new JsonResponse($this->orderFacade->convertOrderToArray($order));
		} else {
			$response = new JsonResponse(['ok' => false, 'error' => 'order-not-found']);
		}

		$this->sendResponse($response);
	}

	public function actionSetProcessed(int $id)
	{
		$this->orderFacade->setOrderProcessed($id);
		$response = new JsonResponse(['ok' => true]);
		$this->sendResponse($response);
	}
}