<?php

declare(strict_types = 1);

namespace AipNg\Forms;

class MethodNotImplementedException extends \RuntimeException
{

	public function __construct(string $methodName)
	{
		parent::__construct(
			\sprintf("Method '%s' is not implemented!", $methodName)
		);
	}

}
