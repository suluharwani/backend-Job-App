<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\MdlApply;
use CodeIgniter\API\ResponseTrait;

class ApiApplyJob extends BaseController
{
	use ResponseTrait;
	
	public function index()
	{
		$db = new MdlApply;
		$user = $db->getApplyAll();
		return $this->response->setJSON( ['sucess'=> true, 'mesage' => 'OK', 'data' => $user] );
	}
	public function page(){
		$db = new MdlApply;
		$page = $_GET['page']??1;
		$size = $_GET['size']??3;
		
		$offset = ($page -1)*$size;
		
		$users = $db->orderBy('id','DESC')->paginate($size,'default',$offset);
		$totalElements = $db->countAll();
		
		$number = ($page <= 0)?null: $page;
		$totalPages = ($size <= 0 )? null: ceil($totalElements/$size);
		$firstPage = ($number ===1);
		$lastPage = ($number ===$totalPages);
		 //json response
		 $response = [
			'data'=> $users,
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

			'id_user' 	=> 'required',
			'id_job'	   	=> 'required',
		]))
		{
			return $this->response->setJSON(['success' => false, 'data' => null, "message" => \Config\Services::validation()->getErrors()]);
		}

		$insert = $this->request->getVar();
		
		$db = new MdlApply;
		$save  = $db->insert($insert);
		
		return $this->setResponseFormat('json')->respondCreated( ['sucess'=> true, 'mesage' => 'OK'] );
	}
		public function updateStatus()
	{
		if( !$this->validate([

			'id_user' 	=> 'required',
			'id_job'	   	=> 'required',
			'status_lamaran'	   	=> 'required',
		]))
		{
			return $this->response->setJSON(['success' => false, 'data' => null, "message" => \Config\Services::validation()->getErrors()]);
		}
		$where['id_job'] = $this->request->getVar('id_job');
		$where['id_user'] = $this->request->getVar('id_user');
		$data['status_lamaran'] = $this->request->getVar('status_lamaran');
		
		$db = new MdlApply;
		$update  = $db->where($where)->set($data)->update();
		if ($db->affectedRows()!=0) {
			return $this->response->setJSON( ['success'=> true, 'mesage' => 'OK'] );
		}
	}
	
	public function show($id)
	{
		$db = new MdlApply;
		$data = $db->getApplyDetail($id);
		
		return $this->response->setJSON( ['success'=> true, 'mesage' => 'OK', 'data' => $data] );
	}
	public function showUserApply($id)
	{
		$db = new MdlApply;
		$data = $db->getApplyUser($id);
		
		return $this->response->setJSON( ['success'=> true, 'mesage' => 'OK', 'data' => json_encode($data)] );
	}
		public function showApplicant($id_job)
	{
		$db = new MdlApply;
		$data = $db->getApplicant($id_job);
		
		return $this->response->setJSON( ['success'=> true, 'mesage' => 'OK', 'data' => json_encode($data)] );
	}
	public function check($idUser, $idJob)
	{
		$db = new MdlApply;
		$data = $db->where(array('id_user'=>$idUser, 'id_job'=> $idJob))->get()->getResult();

		
		if ($data) {
		return $this->response->setJSON( ['success'=> true, 'mesage' => 'OK', 'data' => $data] );
		}else{
		return $this->response->setJSON(['success' => false, 'data' => null, "message" => \Config\Services::validation()->getErrors()]);
		}
	}
	public function update($id)
	{
		if (! $this->validate([
            'id_user' 	=> 'required',
			'id_job'	   	=> 'required',
        ])) {
            return $this->response->setJSON(['success' => false, "message" => \Config\Services::validation()->getErrors()]);
        }
		
		$db = new MdlApply;
		$exist = $db->where('id', $id)->first();
		
		if( !$exist )
		{
			return $this->response->setJSON(['success' => false, "message" => 'User not found']);
		}
		
        $update = $this->request->getVar();

        $db = new MdlApply;
        $save  = $db->update( $id, $update);
        
        return $this->response->setJSON(['success' => true,'message' => 'OK']);
	}

	public function delete($id)
	{
		$db = new MdlApply;
		$db->where('id', $id);
		$db->delete();
		
		return $this->response->setJSON( ['sucess'=> true, 'mesage' => 'OK'] );
	}

}