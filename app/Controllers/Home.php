<?php 
	namespace App\Controllers;
	use App\Models\UserModel;

class Home extends BaseController
{
	public function index()
	{
		return view('welcome_message');
	}

	public function login()
	{
		$users = new UserModel();
		$data['users'] 		= $users->orderBy('id_user', 'DESC')->findAll();
		$data['path']  		= $this->path != '/' ? $this->path : '/login';
		$data['title'] 		= 'Login';
		$data['cookies']	= $_COOKIE;
		$data['remenber'] 	= $_COOKIE['cook-remember'];
		
		return view('login', $data);
		
	}

	public function dashboard()
	{
		$users = new UserModel();
		$data['user']  = reset($users->where('id_user', $this->session)->find());
		$data['path']  = $this->path;
		$data['title'] = 'Dashboard';

		return view('dashboard', $data);
		
	}

}
