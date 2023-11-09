<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\MdlDataPelamar;
use CodeIgniter\API\ResponseTrait;

class ApiDataPelamar extends BaseController
{
	use ResponseTrait;
	
	public function index()
	{
		$db = new MdlDataPelamar;
		$data = $db->get()->getResult();
		return $this->response->setJSON( ['sucess'=> true, 'mesage' => 'OK', 'data' => $data] );
	}
	public function page(){
		$db = new MdlDataPelamar;
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
			'alamat' 	=> 'required',
			'telepon' 	=> 'required',
			'id_user'	   	=> 'required',
			'tanggal_lahir'	   	=> 'required',
		
		]))
		{
			return $this->response->setJSON(['success' => false, 'data' => null, "message" => \Config\Services::validation()->getErrors()]);
		}
		$id =  $this->request->getVar('id_user');
		$insert = [
            'alamat' => $this->request->getVar('alamat'),
			'telepon' => $this->request->getVar('telepon'),
			'id_user' => $id,
			'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
	
        ];
		
		$db = new MdlDataPelamar;
			$messages = "Gagal";

		if ($db->where('id_user',$id)->countAll() >0 ) {
			$save  = $db->where('id_user',$id)->set($insert)->update();
			$messages = "Data berhasil diupdate";
		}else{
			$save  = $db->insert($insert);
			$messages = "Data berhasil ditambahkan";

		}
		return $this->response->setJSON( ['success'=> $save, 'message' => $messages, 'data' => $insert] );
		// return $this->setResponseFormat('json')->respondCreated( ['sucess'=> $save, 'mesage' => $messages] );
	}
	
	public function show($id)
	{
		$db = new MdlDataPelamar;
		$data = $db->where('id_user', $id)->first();
		
		return $this->response->setJSON( ['success'=> true, 'mesage' => 'OK', 'data' => $data] );
	}

	public function update($id)
	{
		if (! $this->validate([
            'alamat' 	=> 'required',
			'telepon' 	=> 'required',
			'tanggal_lahir'	   	=> 'required',

        ])) {
            return $this->response->setJSON(['success' => false, "message" => \Config\Services::validation()->getErrors()]);
        }
		
		$db = new MdlDataPelamar;
		$exist = $db->where('id_user', $id)->first();

		if( !$exist )
		{
			return $this->response->setJSON(['success' => false, "message" => 'User not found']);
		}
		
        $update = [
            'alamat' => $this->request->getVar('alamat') ? $this->request->getVar('alamat') : $exist['alamat'],
			'telepon' => $this->request->getVar('telepon') ? $this->request->getVar('telepon') : $exist['telepon'],
			'tanggal_lahir' => $this->request->getVar('tanggal_lahir') ? $this->request->getVar('tanggal_lahir') : $exist['tanggal_lahir'],
        ];

        $db = new MdlDataPelamar;
        $save  = $db->update( $id, $update);
        
        return $this->response->setJSON(['success' => true,'message' => 'OK']);
	}

	public function delete($id)
	{
		$db = new MdlDataPelamar;
		$db->where('id', $id);
		$db->delete();
		
		return $this->response->setJSON( ['sucess'=> true, 'message' => 'OK'] );
	}

}