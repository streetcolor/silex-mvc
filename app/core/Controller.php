<?php
namespace Core;
use Silex\Application;

/**
 * Controller
 *
 * @package default
 */
class Controller
{
	protected $app;

	public function __construct(\AppKernel $app){
		$this->app = $app;
	}
}
