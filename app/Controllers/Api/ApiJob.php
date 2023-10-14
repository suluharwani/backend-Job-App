<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\MdlJob;
use CodeIgniter\API\ResponseTrait;

class ApiJob extends BaseController
{
	use ResponseTrait;

	public function index()
	{
		$db = new MdlJob;
		$data = $db->get()->getResult();
		return $this->response->setJSON(['sucess' => true, 'mesage' => 'OK', 'data' => $data]);
	}
	public function page()
	{
		$db = new MdlJob;
		$page = $_GET['page'] ?? 1;
		$size = $_GET['size'] ?? 3;

		$offset = ($page - 1) * $size;

		$data = $db->orderBy('id', 'DESC')->paginate($size, 'default', $offset);
		$totalElements = $db->countAll();

		$number = ($page <= 0) ? null : $page;
		$totalPages = ($size <= 0) ? null : ceil($totalElements / $size);
		$firstPage = ($number === 1);
		$lastPage = ($number === $totalPages);
		//json response
		$response = [
			'data' => $data,
			'pagination' => [
				'page' => $page,
				'size' => $size,
				'totalElements' => $totalElements,
				'number' => $number,
				'firstPage' => $firstPage,
				'lastPage' => $lastPage
			]
		];
		return $this->respond(json_encode($response));
	}

	public function create()
	{
		if (
			!$this->validate([
				'company_id' => 'required',
				'cat_id' => 'required',
				'subcat_id' => 'required',
				'prov_id' => 'required',
				'city_id' => 'required',
				'address' => 'required',
				'postal_code' => 'required',
				'job' => 'required',
				'job_desc' => 'required',
				'benefits' => 'required',
				'minimum_qualification' => 'required',
				'facility' => 'required',
				'open_for' => 'required',
				'salary_start' => 'required',
				'salary_end' => 'required',
				'status' => 'required',
				'start' => 'required',
				'due' => 'required',
		
			])
		) {
			return $this->response->setJSON(['success' => false, 'data' => null, "message" => \Config\Services::validation()->getErrors()]);
		}
		
		$insert = $this->request->getVar();
	
		$db = new MdlJob;
		$save = $db->insert($insert);
		
		return $this->setResponseFormat('json')->respondCreated(['sucess' => true, 'mesage' => 'OK']);
	}
	
	public function show($id)
	{
		$db = new MdlJob;
		// $data = $db->where('id', $id)->first();
		$data = $db->getJobDetail($id);
		return $this->response->setJSON(['sucess' => true, 'mesage' => 'OK', 'data' => $data]);
	}
	
	public function update($id)
	{
		if (
			!$this->validate([
				'company_name' => 'required',
				'company_desc' => 'required',
			])
		) {
			return $this->response->setJSON(['success' => false, "message" => \Config\Services::validation()->getErrors()]);
		}

		$db = new MdlJob;
		$exist = $db->where('id', $id)->first();

		if (!$exist) {
			return $this->response->setJSON(['success' => false, "message" => 'User not found']);
		}

		$update = [
			'company_name' => $this->request->getVar('company_name') ? $this->request->getVar('company_name') : $exist['company_name'],
			'company_desc' => $this->request->getVar('company_desc') ? $this->request->getVar('company_desc') : $exist['company_desc'],
		];

		$db = new MdlJob;
		$save = $db->update($id, $update);

		return $this->response->setJSON(['success' => true, 'message' => 'OK']);
	}

	public function delete($id)
	{
		$db = new MdlJob;
		$db->where('id', $id);
		$db->delete();

		return $this->response->setJSON(['sucess' => true, 'message' => 'OK']);
	}

}