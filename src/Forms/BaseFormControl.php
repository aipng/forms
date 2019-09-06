<?php

declare(strict_types = 1);

namespace AipNg\Forms;

use Nette\Application\UI\Control;

/**
 * @property \Nette\Bridges\ApplicationLatte\Template $template
 */
abstract class BaseFormControl extends Control
{

	/**
	 * @param mixed[] $defaults
	 *
	 * @throws \AipNg\Forms\MethodNotImplementedException
	 */
	public function setDefaults(array $defaults): void
	{
		if (!method_exists($this, 'createComponentForm')) {
			throw new MethodNotImplementedException(__METHOD__);
		}

		/** @var \Nette\Application\UI\Form $componentForm */
		$componentForm = $this->getComponent('form');

		$componentForm->setDefaults($defaults);
	}


	public function beforeRender(): void
	{
	}


	public function render(): void
	{
		$this->beforeRender();
		$this->template->render($this->getTemplateFile());
	}


	protected function getTemplateFile(): string
	{
		$shortName = $this->getReflection()->getShortName();
		/** @var string $fileName */
		$fileName = $this->getReflection()->getFileName();
		$dir = dirname($fileName);

		$files = [
			sprintf('%s/templates/%s.latte', $dir, $shortName),
			sprintf('%s/%s.latte', $dir, $shortName),
		];

		foreach ($files as $file) {
			if (is_file($file)) {
				return $file;
				break;
			}
		}

		return __DIR__ . '/BaseFormControl.latte';
	}

}
