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
	protected $request;
	public function __construct(\AppKernel $app){
		$this->app = $app;
		$this->request = $this->app['request'];
	}
}
