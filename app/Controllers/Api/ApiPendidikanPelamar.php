<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\MdlDataPendidikanPelamar;
use CodeIgniter\API\ResponseTrait;

class ApiPendidikanPelamar extends BaseController
{
	use ResponseTrait;
	
	public function index()
	{
		$db = new MdlDataPendidikanPelamar;
		$data = $db->get()->getResult();
		return $this->response->setJSON( ['sucess'=> true, 'mesage' => 'OK', 'data' => $data] );
	}
	public function page(){
		$db = new MdlDataPendidikanPelamar;
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
			'jenjang' 	=> 'required',
			'lembaga' 	=> 'required',
			'tahun_lulus' 	=> 'required',
			'id_user'	   	=> 'required',
		
		]))
		{
			return $this->response->setJSON(['success' => false, 'data' => null, "message" => \Config\Services::validation()->getErrors()]);
		}

		$id = $this->request->getVar('id_user');
		$jenjang = $this->request->getVar('jenjang');
		$insert = [
            'jenjang' => $jenjang,
			'lembaga' => $this->request->getVar('lembaga'),
			'tahun_lulus' => $this->request->getVar('tahun_lulus'),
			'id_user' => $id,
	
        ];
		
		$db = new MdlDataPendidikanPelamar;
		// $save  = $db->insert($insert);
		
		$messages = "Gagal";
		
		if ($db->where(array('id_user'=>$id, 'jenjang'=>$jenjang))->countAllResults() >0 ) {
			$save  = $db->where(array('id_user'=>$id, 'jenjang'=>$jenjang))->set($insert)->update();

			$messages = "Data berhasil diupdate";
		}else{

			$save  = $db->insert($insert);
			$messages = "Data berhasil ditambahkan";

		}
		return $this->response->setJSON( ['success'=> $save, 'message' => $messages, 'data' => $insert] );
	}
	
	public function show($id)
	{
		$db = new MdlDataPendidikanPelamar;
		$data = json_encode($db->where('id_user', $id)->get()->getResultArray());
		
		return $this->response->setJSON( ['success'=> true, 'mesage' => 'OK', 'data' => $data] );
	}

	public function update($id)
	{
		if (! $this->validate([
            'jenjang' 	=> 'required',
			'lembaga' 	=> 'required',
			'tahun_lulus' 	=> 'required',
        ])) {
            return $this->response->setJSON(['success' => false, "message" => \Config\Services::validation()->getErrors()]);
        }
		
		$db = new MdlDataPendidikanPelamar;
		$exist = $db->where('id', $id)->first();

		if( !$exist )
		{
			return $this->response->setJSON(['success' => false, "message" => 'User not found']);
		}
		
        $update = [
            'jenjang' => $this->request->getVar('jenjang') ? $this->request->getVar('jenjang') : $exist['jenjang'],
			'lembaga' => $this->request->getVar('lembaga') ? $this->request->getVar('lembaga') : $exist['lembaga'],
			'tahun_lulus' => $this->request->getVar('tahun_lulus') ? $this->request->getVar('tahun_lulus') : $exist['tahun_lulus'],
        ];

        $db = new MdlDataPendidikanPelamar;
        $save  = $db->update( $id, $update);
        
        return $this->response->setJSON(['success' => true,'message' => 'OK']);
	}

	public function delete($id)
	{
		$db = new MdlDataPendidikanPelamar;
		$db->where('id', $id);
		$db->delete();
		
		return $this->response->setJSON( ['sucess'=> true, 'message' => 'OK'] );
	}

}