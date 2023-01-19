<?php

declare(strict_types=1);

namespace App\Components\OrderControl;

use App\Exceptions\EmptyOrderException;
use App\Exceptions\ProductNotFoundException;
use App\Model\Order\OrderFacade;
use App\Model\Order\OrderInput;
use App\Model\Product\ProductFacade;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

final class OrderControl extends Control
{
	public function __construct(private ProductFacade $productFacade, private OrderFacade $orderFacade) {}

	public function render() {
		$this->template->render(__DIR__ . '/template.latte');
	}

	protected function createComponentOrderForm(): Form
	{
		$form = new Form;
		$form->setMappedType(OrderInput::class);

		$products = $this->productFacade->getProducts();
		$container = $form->addContainer('orderItems');
		foreach ($products as $product) {
			$container->addInteger("{$product->id}", $product->name)
				->addRule($form::RANGE, 'Quantity must be between %d and %d.', [0, 10]);
		}

		$form->addSubmit('send', 'Send order');

		$form->onSuccess[] = [$this, 'recordFormSucceeded'];
		return $form;
	}

	public function recordFormSucceeded(Form $form, OrderInput $data): void
	{
		try {
			$this->orderFacade->createOrder($data);
			$this->flashMessage('Successfully ordered');
		} catch (EmptyOrderException) {
			$this->flashMessage('Order must not be empty.', 'danger');
		} catch (ProductNotFoundException) {
			$this->flashMessage('Invalid product in order', 'warning');
		}

		$this->redirect('this');
	}
}
