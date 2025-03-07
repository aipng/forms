<?php

declare(strict_types = 1);

namespace AipNg\Latte;

use AipNg\Latte\Node\InputDescriptionNode;
use Latte\Engine;
use Latte\Extension;

final class FormInputDescriptionExtension extends Extension
{

	/**
	 * @return array<string, \Closure>
	 */
	public function getTags(): array
	{
		return [
			'inputDescription' => InputDescriptionNode::create(...),
		];
	}


	public function getCacheKey(Engine $engine): int
	{
		return 1;
	}

}
