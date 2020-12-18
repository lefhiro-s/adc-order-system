<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Session implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
		$this->path 	= $_SERVER['REQUEST_URI'];
		$this->session	= $_COOKIE['cook-login'];
		if($this->session){
			if( $this->path == '/' || $this->path == '/index.php/login' || 
				$this->path == '/index.php/' || $this->path == '/index.php'){
				return redirect()->to(base_url('/index.php/dashboard'));
			}
		}else{
			if( $this->path != '/' && $this->path != '/index.php/login' && $this->path != '/index.php/'	&&
				$this->path != '/index.php' && $this->path != '/index.php/services/user/validation' ){
				return redirect()->to(base_url(''));
			}
		}

    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}