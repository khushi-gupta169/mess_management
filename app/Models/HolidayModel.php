<?php

namespace App\Models;

use CodeIgniter\Model;

class HolidayModel extends Model
{
    protected $table            = 'holidays';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'holiday_date', 'title', 'description', 'meal_status', 'created_by'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'holiday_date' => 'required|valid_date',
        'title'        => 'required|min_length[3]|max_length[200]',
        'meal_status'  => 'in_list[closed,open]',
        'created_by'   => 'required|is_natural_no_zero'
    ];
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

    public function getUpcomingHolidays()
    {
        return $this->where('holiday_date >=', date('Y-m-d'))
                    ->orderBy('holiday_date', 'ASC')
                    ->findAll();
    }

    public function getHolidaysByMonth($month, $year)
    {
        return $this->where('MONTH(holiday_date)', $month)
                    ->where('YEAR(holiday_date)', $year)
                    ->orderBy('holiday_date', 'ASC')
                    ->findAll();
    }

    public function isHoliday($date)
    {
        return $this->where('holiday_date', $date)->first() !== null;
    }
}