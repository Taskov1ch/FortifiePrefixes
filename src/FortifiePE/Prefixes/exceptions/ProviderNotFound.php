<?php

namespace FortifiePE\Prefixes\exceptions;

use Exception;

class ProviderNotFound extends Exception {
	public function __construct($message) {
		parent::__construct($message);
	}
}
