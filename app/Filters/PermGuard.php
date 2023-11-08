<?php 
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PermGuard implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $router = service('router');
        $controller = $router->controllerName();
        $controller = explode("\\", $controller);
        $controller = end($controller);
        $method = $router->methodName();

        $cm = $controller."/".$method;
        $permission_set = session()->get('permission_set');

        if($permission_set == null)
        {
            echo "Permission Denied.";
            exit;
        }

        if( !in_array($cm, $permission_set) ){
            echo "Permission Denied.";
            exit;
        }

        if (!session()->get('logged_in'))
        {
            return redirect()->to('I2r0J2r2RjW1sJ0r2L9m');
        }
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}