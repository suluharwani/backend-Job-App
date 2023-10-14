<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Libraries\JWTCI4;
use App\Models\MdlUser;

class AuthController extends BaseController
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
		
		$db = new MdlUser;
		$user  = $db->where('email', $this->request->getVar('email'))->first();
		if( $user )
		{
			if( password_verify($this->request->getVar('password'), $user['password']) )
			{
				$jwt = new JWTCI4;
				$token = $jwt->token();
				
				return $this->response->setJSON( ['token'=> $token, 'data'=> $user] );
			}
		}else{
			
			return $this->response->setJSON( ['success'=> false, 'message' => 'User not found' ] )->setStatusCode(409);
		}
		
		
	}
}