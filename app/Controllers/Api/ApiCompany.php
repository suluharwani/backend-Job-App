<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\MdlCompany;
use CodeIgniter\API\ResponseTrait;

class ApiCompany extends BaseController
{
	use ResponseTrait;
	
	public function index()
	{
		$db = new MdlCompany;
		$data = $db->get()->getResult();
		return $this->response->setJSON( ['sucess'=> true, 'mesage' => 'OK', 'data' => $data] );
	}
	public function page(){
		$db = new MdlCompany;
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
			'company_name' 	=> 'required',
			'company_desc' 	=> 'required',
			'user_id'	   	=> 'required',
		
		]))
		{
			return $this->response->setJSON(['success' => false, 'data' => null, "message" => \Config\Services::validation()->getErrors()]);
		}

		$insert = [
            'company_name' => $this->request->getVar('company_name'),
			'company_desc' => $this->request->getVar('company_desc'),
			'user_id' => $this->request->getVar('user_id'),
	
        ];
		
		$db = new MdlCompany;
		$save  = $db->insert($insert);
		
		return $this->setResponseFormat('json')->respondCreated( ['sucess'=> true, 'mesage' => 'OK'] );
	}
	
	public function show($id)
	{
		$db = new MdlCompany;
		$data = $db->where('id', $id)->first();
		
		return $this->response->setJSON( ['sucess'=> true, 'mesage' => 'OK', 'data' => $data] );
	}

	public function update($id)
	{
		if (! $this->validate([
            'company_name' 	=> 'required',
			'company_desc' 	=> 'required',
        ])) {
            return $this->response->setJSON(['success' => false, "message" => \Config\Services::validation()->getErrors()]);
        }
		
		$db = new MdlCompany;
		$exist = $db->where('id', $id)->first();

		if( !$exist )
		{
			return $this->response->setJSON(['success' => false, "message" => 'User not found']);
		}
		
        $update = [
            'company_name' => $this->request->getVar('company_name') ? $this->request->getVar('company_name') : $exist['company_name'],
			'company_desc' => $this->request->getVar('company_desc') ? $this->request->getVar('company_desc') : $exist['company_desc'],
        ];

        $db = new MdlCompany;
        $save  = $db->update( $id, $update);
        
        return $this->response->setJSON(['success' => true,'message' => 'OK']);
	}

	public function delete($id)
	{
		$db = new MdlCompany;
		$db->where('id', $id);
		$db->delete();
		
		return $this->response->setJSON( ['sucess'=> true, 'message' => 'OK'] );
	}

}