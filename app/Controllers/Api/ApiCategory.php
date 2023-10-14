<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\MdlCategory;
use CodeIgniter\API\ResponseTrait;

class ApiCategory extends BaseController
{
	use ResponseTrait;
	
	public function index()
	{
		$db = new MdlCategory;
		$data = $db->get()->getResult();
		return $this->response->setJSON( ['sucess'=> true, 'message' => 'OK', 'data' => $data] );
	}


	public function create()
	{
		if( !$this->validate([
			'category' 	=> 'required|is_unique[category.category]',
		]))
		{
			return $this->response->setJSON(['success' => false, 'data' => null, "message" => \Config\Services::validation()->getErrors()]);
		}

		$insert = [
            'category' => $this->request->getVar('category'),
	
        ];
		
		$db = new MdlCategory;
		$save  = $db->insert($insert);
		
		return $this->setResponseFormat('json')->respondCreated( ['sucess'=> true, 'message' => 'OK'] );
	}
	
	public function show($id)
	{
		$db = new MdlCategory;
		$data = $db->where('id', $id)->first();
		
		return $this->response->setJSON( ['sucess'=> true, 'message' => 'OK', 'data' => $data] );
	}

	public function update($id)
	{
		if (! $this->validate([
            'category' 	=> 'required',
        ])) {
            return $this->response->setJSON(['success' => false, "message" => \Config\Services::validation()->getErrors()]);
        }
		
		$db = new MdlCategory;
		$exist = $db->where('id', $id)->first();

		if( !$exist )
		{
			return $this->response->setJSON(['success' => false, "message" => 'User not found']);
		}
		
        $update = [
            'company_name' => $this->request->getVar('company_name') ? $this->request->getVar('company_name') : $exist['company_name'],
			'company_desc' => $this->request->getVar('company_desc') ? $this->request->getVar('company_desc') : $exist['company_desc'],
        ];

        $db = new MdlCategory;
        $save  = $db->update( $id, $update);
        
        return $this->response->setJSON(['success' => true,'message' => 'OK']);
	}

	public function delete($id)
	{
		$db = new MdlCategory;
		$db->where('id', $id);
		$db->delete();
		
		return $this->response->setJSON( ['sucess'=> true, 'message' => 'OK'] );
	}

}