<?
namespace Paa\App;

class ApplicationController
{
    public $defaultAction = 'index';
    
    public function __construct(string $module = '', string $page = '') 
    {
	$this->module = $module;
	$this->page = $page;
    }

    public function run()
    {
	(new ViewController)->render($this->module, $this->page);
    }

}