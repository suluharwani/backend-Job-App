<?php

namespace App\Models;

use CodeIgniter\Model;

class MdlApply extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'apply';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ["id","id_user","id_job","created_at","deleted_at","updated_at"];
    
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    
    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
    public function getApplyAll()
    {
        $table = $this->table;
        $data = $this->db->table($table)
            ->select(
                "
            {$table}.id,
            {$table}.id_user,
            {$table}.id_job,
            {$table}.updated_at,
            {$table}.deleted_at,
            {$table}.created_at,
            
            job.company_id,
            job.cat_id,
            job.subcat_id,
            job.prov_id,
            job.city_id,
            job.address,
            job.postal_code,
            job.job,
            job.job_desc,
            job.benefits,
            job.minimum_qualification,
            job.facility,
            job.open_for,
            job.salary_start,
            job.salary_end,
            job.status,
            job.start,
            job.due,
            
            user.firstname,
            user.lastname,
            user.email,
            user.level,
            user.status,
            "
            )
            ->join('job', "{$table}.id_job = job.id ", 'left')
            ->join('user', "{$table}.id_user = user.id ", 'left')
            ->where("{$table}.deleted_at",null)
            ->get()
            ->getResult();
        return $data;
    }
    public function getApplyDetail($id=null)
    {
        $table = $this->table;
        $data = $this->db->table($table)
            ->select(
                "
            {$table}.id,
            {$table}.id_user,
            {$table}.id_job,
            {$table}.updated_at,
            {$table}.deleted_at,
            {$table}.created_at,
            
            job.company_id,
            job.cat_id,
            job.subcat_id,
            job.prov_id,
            job.city_id,
            job.address,
            job.postal_code,
            job.job,
            job.job_desc,
            job.benefits,
            job.minimum_qualification,
            job.facility,
            job.open_for,
            job.salary_start,
            job.salary_end,
            job.status,
            job.start,
            job.due,
            
            user.firstname,
            user.lastname,
            user.email,
            user.level,
            user.status,
            "
            )
            ->join('job', "{$table}.id_job = job.id ", 'left')
            ->join('user', "{$table}.id_user = user.id ", 'left')
            ->where(array("{$table}.id"=> $id, "{$table}.deleted_at"=>null))
            ->get()
            ->getResult();
        return $data;
    }
}
