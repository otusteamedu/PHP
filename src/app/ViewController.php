<?
namespace Paa\App;

class ViewController
{
    public function render($module, $page)
    {
	$route = $this->route();
	$module = ($route['module'] == '') ? 'site' : $route['module'];
	$page = ($route['page'] == '') ? 'index' : strtolower($route['page']);

	$file = './../views/' . $module . '/' . $page . '.php';
	$class = '\\Paa\\Controllers\\'. ucfirst($module).'Controller';

	if (class_exists($class)) {
	    $method = 'action'.ucfirst($page);
	    $classObj = new $class;
	    if (method_exists($class, $method)) { 
		$result = $classObj->$method();
		
		$type = ($result['type']) ? $result['type'] : '';
		$layout = ($result['layout']) ? $result['layout'] : '';
		
		// if need redirect
		if (isset($result['asset']['redirect'])) header("Location: " . $result['asset']['redirect']);
		
		// if need JSON 
		if ($type == 'json') {
		    echo json_encode($result['asset']);

		// if need HTML
		}  else {
		    $asset = $result['asset'];
		    // show page
		    if ($layout != 'no') require_once ('./../layout/header.php');
		    require_once ($file);
		    if ($layout != 'no') require_once ('./../layout/footer.php');
		}
		
	    } else {
		require_once ('./../views/404.php');
	    }
	} else {
	    require_once ('./../views/404.php');
        }
	
    }

    public function route()
    {
	$uri = (string)$_SERVER['REQUEST_URI'];
	$route = explode ('/', (explode ('?', $uri))[0]);
	$module = (isset($route[1])) ? $route[1] : '';
	$page = ($module != '' && isset($route[2])) ? $route[2] : '';
	return ['module' => $module, 'page' => $page];
    }

}