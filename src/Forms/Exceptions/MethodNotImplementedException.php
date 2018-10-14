<?php

declare(strict_types = 1);

namespace AipNg\Forms;

final class MethodNotImplementedException extends \RuntimeException
{

	public function __construct(string $methodName, int $code = 0, ?\Throwable $previous = null)
	{
		$message = \sprintf(
			"Method '%s' is not implemented!",
			$methodName
		);

		parent::__construct($message, $code, $previous);
	}

}
