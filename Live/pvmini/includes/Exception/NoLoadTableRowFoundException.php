<?php

namespace Schletter\GroundMount\Exception;

class NoLoadTableRowFoundException extends \Exception {

    protected $message = 'No load table data found! Please try different parameters.';
}
