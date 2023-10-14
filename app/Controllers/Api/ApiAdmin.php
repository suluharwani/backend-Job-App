<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\MdlAdmin;
use CodeIgniter\API\ResponseTrait;

class ApiAdmin extends BaseController
{
	use ResponseTrait;
	
	public function index()
	{
		$db = new MdlAdmin;
		$data = $db->get()->getResult();
		return $this->response->setJSON( ['sucess'=> true, 'mesage' => 'OK', 'data' => $data] );
	}
	public function page(){
		$db = new MdlAdmin;
		$page = $_GET['page']??1;
		$size = $_GET['size']??3;
		
		$offset = ($page -1)*$size;
		
		$data = $db->orderBy('id','DESC')->paginate($size,'default',$offset);
		$totalElements = $db->countAll();
		
		$number = ($page <= 0)?null: $page;
		$totalPages = ($size <= 0 )? null: ceil($totalElements/$size);
		$firstPage = ($number ===1);
		$lastPage = ($number ===$totalPages);
		 //json response
		 $response = [
			'data'=> $data,
			'pagination'=>[
				'page'=>$page,
				'size'=>$size,
				'totalElements'=>$totalElements,
				'number'=>$number,
				'firstPage'=>$firstPage,
				'lastPage'=>$lastPage
				]
			];
		 return $this->respond(json_encode($response));
	}

	public function create()
	{
		if( !$this->validate([
			'email' 	=> 'required|is_unique[admin.email]',
			'password' 	=> 'required|min_length[6]',
			'firstname'	   	=> 'required',
			'lastname'	=> 'required',
		]))
		{
			return $this->response->setJSON(['success' => false, 'data' => null, "message" => \Config\Services::validation()->getErrors()]);
		}

		$insert = [
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
			'firstname' => $this->request->getVar('firstname'),
			'lastname' => $this->request->getVar('lastname'),
			'level' => 1,
			'status' => 1,
        ];
		
		$db = new MdlAdmin;
		$save  = $db->insert($insert);
		
		return $this->setResponseFormat('json')->respondCreated( ['sucess'=> true, 'mesage' => 'OK'] );
	}
	
	public function show($id)
	{
		$db = new MdlAdmin;
		$data = $db->where('id', $id)->first();
		
		return $this->response->setJSON( ['sucess'=> true, 'mesage' => 'OK', 'data' => $data] );
	}

	public function update($id)
	{
		if (! $this->validate([
            'email' => 'permit_empty|is_unique[admin.email,id,'.$id.']',
            'password' => 'permit_empty|min_length[6]',
			'firstname' => 'permit_empty',
			'lastname' => 'permit_empty',
        ])) {
            return $this->response->setJSON(['success' => false, "message" => \Config\Services::validation()->getErrors()]);
        }
		
		$db = new MdlAdmin;
		$exist = $db->where('id', $id)->first();

		if( !$exist )
		{
			return $this->response->setJSON(['success' => false, "message" => 'User not found']);
		}
		
        $update = [
            'email' => $this->request->getVar('email') ? $this->request->getVar('email') : $exist['email'],
            'password' => $this->request->getVar('password') ? password_hash($this->request->getVar('password'), PASSWORD_DEFAULT) : $exist['password'],
			'firstname' => $this->request->getVar('firstname') ? $this->request->getVar('firstname') : $exist['firstname'],
			'lastname' => $this->request->getVar('lastname')  ? $this->request->getVar('lastname') : $exist['lastname'],
        ];
        
        $db = new MdlAdmin;
        $save  = $db->update( $id, $update);
        
        return $this->response->setJSON(['success' => true,'message' => 'OK']);
	}

	public function delete($id)
	{
		$db = new MdlAdmin;
		$db->where('id', $id);
		$db->delete();
		
		return $this->response->setJSON( ['sucess'=> true, 'mesage' => 'OK'] );
	}

}