<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\MdlAdmin;
use App\Libraries\JWTCI4ADMIN;

class AuthControllerAdmin extends BaseController
{
	public function login()
	{
		if( !$this->validate([
			'email' 	=> 'required',
			'password' 	=> 'required|min_length[6]',
		]))
		{
			return $this->response->setJSON(['success' => false, 'data' => null, "message" => \Config\Services::validation()->getErrors()]);
		}
		
		$db = new MdlAdmin;
		$admin  = $db->where('email', $this->request->getVar('email'))->first();
		if( $admin )
		{
			if( password_verify($this->request->getVar('password'), $admin['password']) )
			{
				$jwt = new JWTCI4ADMIN;
				$token = $jwt->token();
				
				return $this->response->setJSON( ['token'=> $token ] );
			}
		}else{
			
			return $this->response->setJSON( ['success'=> false, 'message' => 'Admin not found' ] )->setStatusCode(409);
		}
		
		
	}
}