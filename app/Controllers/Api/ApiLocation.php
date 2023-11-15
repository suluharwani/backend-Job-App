<?php
namespace App\Controllers\Api;
use App\Controllers\BaseController;
use App\Models\MdlProvinsi;
use App\Models\MdlKota;
class ApiLocation extends BaseController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        //
    }
    function prov()  {
        $db = new MdlProvinsi;
        // $data = $db->where('id', $id)->first();
        $data = $db->get()->getResultArray();
        return $this->response->setJSON(['sucess' => true, 'mesage' => 'OK', 'data' => json_encode($data)]);

    }
    function getcities($prov_id)  {
        $db = new MdlKota;
        // $data = $db->where('id', $id)->first();
        $data = $db->where('prov_id',$prov_id)->get()->getResultArray();
         return $this->response->setJSON(['sucess' => true, 'mesage' => 'OK', 'data' => json_encode($data)]);
        // return $this->response->setJSON(['sucess' => true, 'mesage' => 'OK', 'data' => $data]);
    }
    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}
