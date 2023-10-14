<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\MdlAdmin;
use App\Models\MdlUser;

class ResourceFile extends ResourceController
{
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
	
	// public function listImages()
	// {
	// 	$fileModel = new FileModel();
		
	// 	$response = [
	// 		'status' => 200,
	// 		"error" => false,
	// 		'messages' => 'Files list',
	// 		'data' => $fileModel->findAll()
	// 	];
		
	// 	return $this->respondCreated($response);
	// }
}