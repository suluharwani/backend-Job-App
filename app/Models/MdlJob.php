<?php

namespace App\Models;

use CodeIgniter\Model;

class MdlJob extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'job';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = ['id', 'company_id', 'cat_id', 'subcat_id', 'prov_id', 'city_id', 'address', 'postal_code', 'job', 'job_desc', 'benefits', 'minimum_qualification', 'facility', 'open_for', 'salary_start', 'salary_end', 'status', 'start', 'due', 'updated_at', 'deleted_at', 'created_at'];
    
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
    public function getJobDetail($id)
    {
        $table = $this->table;
        $data = $this->db->table($table)
            ->select(
                "
            {$table}.id,
            {$table}.company_id,
            {$table}.cat_id,
            {$table}.subcat_id,
            {$table}.prov_id,
            {$table}.city_id,
            {$table}.address,
            {$table}.postal_code,
            {$table}.job,
            {$table}.job_desc,
            {$table}.benefits,
            {$table}.minimum_qualification,
            {$table}.facility,
            {$table}.open_for,
            {$table}.salary_start,
            {$table}.salary_end,
            {$table}.status,
            {$table}.start,
            {$table}.due,
            {$table}.updated_at,
            {$table}.deleted_at,
            {$table}.created_at,
            category.category,
            sub_category.sub_category,
            cities.city_name,
            provinces.prov_name,
            company.company_name,
            company.company_desc,
            company.company_logo,
            "
            )
            ->join('category', "{$table}.cat_id = category.id ", 'left')
            ->join('sub_category', "{$table}.subcat_id = sub_category.id ", 'left')
            ->join('cities', "{$table}.city_id = cities.city_id ", 'left')
            ->join('provinces', "{$table}.prov_id = provinces.prov_id ", 'left')
            ->join('company', "{$table}.company_id = company.id ", 'left')
            ->where("{$table}.id", $id)
            ->get()
            ->getResult();
        return $data;
    }

}