<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\MdlAdmin;
use App\Models\MdlUser;
use App\Models\MdlFilecv;

class ResourceFile extends ResourceController
{
	    public function show($id_user=null)
    {
    	$db = new MdlFilecv();
    	$filename = $db->where('id_user', $id_user)->get()->getResultArray();
    	if (count($filename)==0) {
    		return $this->response->setStatusCode(404, 'File not found');

    	}
        $path = ROOTPATH . 'public/file/user/' . $filename[0]['name'];
        //     var_dump($path);
        // die();
        if ( is_file($path) && file_exists($path)) {
            $file = file_get_contents($path);

            return $this->response->setContentType('application/pdf')->setBody($file);
        } else {
        	 return $this->response->setStatusCode(404, 'File not found');
        }
    }
	public function updateImageUser($id)
	{
		$file = $this->request->getFile('profile_picture');
		
		$profile_image = $file->getName();
		
		// Renaming file before upload
		$temp = explode(".",$profile_image);
		$newfilename = rand().round(microtime(true)) . '.' . end($temp);
		
		if ($file->move("images/user", $newfilename)) {
			
			$fileModel = new MdlUser();
			
			$data = [
				"profile_picture" => $newfilename
			];
			$oldfile = $fileModel->where('id',$id)->get()->getResultArray()[0]['profile_picture'];

			if ($fileModel->set($data)->where('id',$id)->update()) {
				if (file_exists("images/user/{$oldfile}")) {
					unlink("images/user/".$oldfile);
				}
				$response = [
					'status' => 200,
					'error' => false,
					'message' => 'File updated successfully',
					'data' => []
				];
			} else {

				$response = [
					'status' => 500,
					'error' => true,
					'message' => 'Failed to update image',
					'data' => []
				];
			}
		} else {
			
			$response = [
				'status' => 500,
				'error' => true,
				'message' => 'Failed to update image',
				'data' => []
			];
		}

		return $this->respondCreated($response);
	}
	public function updateImageAdmin($id)
	{
		$file = $this->request->getFile('profile_picture');
		
		$profile_image = $file->getName();
		
		// Renaming file before upload
		$temp = explode(".",$profile_image);
		$newfilename = rand().round(microtime(true)) . '.' . end($temp);
		
		if ($file->move("images/admin", $newfilename)) {
			
			$fileModel = new MdlAdmin();
			
			$data = [
				"profile_picture" => $newfilename
			];
			$oldfile = $fileModel->where('id',$id)->get()->getResultArray()[0]['profile_picture'];
			if ($fileModel->set($data)->where('id',$id)->update()) {
				if (file_exists("images/admin/{$oldfile}")) {
					unlink("images/admin/".$oldfile);
				}
				$response = [
					'status' => 200,
					'error' => false,
					'message' => 'File updated successfully',
					'data' => []
				];
			} else {

				$response = [
					'status' => 500,
					'error' => true,
					'message' => 'Failed to update image',
					'data' => []
				];
			}
		} else {
			
			$response = [
				'status' => 500,
				'error' => true,
				'message' => 'Failed to update image',
				'data' => []
			];
		}
		
		return $this->respondCreated($response);
	}
	
	public function updateCvUser($id)
	{
		$file = $this->request->getFile('file_cv');
		
		$profile_image = $file->getName();
		
		// Renaming file before upload
		$temp = explode(".",$profile_image);
		$newfilename = rand().round(microtime(true)) . '.' . end($temp);
		
		if ($file->move("file/user", $newfilename)) {
			
			$fileModel = new MdlFilecv();
			
			$data = [
				"name" => $newfilename
			];
			$newdata = [
				'id_user'=>$id,
				"name" => $newfilename
			];
			if ($fileModel->where('id_user',$id)->get()->getNumRows() >0) {
				$oldfile = $fileModel->where('id_user',$id)->get()->getResultArray()[0]['name'];

				if ($fileModel->set($data)->where('id_user',$id)->update()) {
					if (file_exists("file/user/{$oldfile}")) {
						unlink("file/user/".$oldfile);
					}
					$response = [
						'status' => 200,
						'error' => false,
						'message' => 'File updated successfully',
						'data' => []
					];
				} else {

					$response = [
						'status' => 500,
						'error' => true,
						'message' => 'Failed to update file',
						'data' => []
					];
				}
			} else {
				if ($fileModel->insert($newdata)) {
			
					$response = [
						'status' => 200,
						'error' => false,
						'message' => 'File uploaded successfully',
						'data' => []
					];
				} else {

					$response = [
						'status' => 500,
						'error' => true,
						'message' => 'Failed to upload file',
						'data' => []
					];
				}
			}
			
			
		} else {
			
			$response = [
				'status' => 500,
				'error' => true,
				'message' => 'Failed to upload file',
				'data' => []
			];
		}

		return $this->respondCreated($response);
	}
	public function updateCvAdmin($id)
	{
		$file = $this->request->getFile('profile_picture');
		
		$profile_image = $file->getName();
		
		// Renaming file before upload
		$temp = explode(".",$profile_image);
		$newfilename = rand().round(microtime(true)) . '.' . end($temp);
		
		if ($file->move("images/admin", $newfilename)) {
			
			$fileModel = new MdlAdmin();
			
			$data = [
				"profile_picture" => $newfilename
			];
			$oldfile = $fileModel->where('id',$id)->get()->getResultArray()[0]['profile_picture'];
			if ($fileModel->set($data)->where('id',$id)->update()) {
				if (file_exists("images/admin/{$oldfile}")) {
					unlink("images/admin/".$oldfile);
				}
				$response = [
					'status' => 200,
					'error' => false,
					'message' => 'File updated successfully',
					'data' => []
				];
			} else {

				$response = [
					'status' => 500,
					'error' => true,
					'message' => 'Failed to update image',
					'data' => []
				];
			}
		} else {
			
			$response = [
				'status' => 500,
				'error' => true,
				'message' => 'Failed to update image',
				'data' => []
			];
		}
		
		return $this->respondCreated($response);
	}
}