<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table            = 'menus';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['menu_date', 'day', 'status'];

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
        'menu_date' => 'required|valid_date',
        'day'       => 'required|in_list[monday,tuesday,wednesday,thursday,friday,saturday,sunday]',
        'status'    => 'in_list[active,inactive]'
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

    public function getMenuWithItems($id)
    {
        $menu = $this->find($id);
        if ($menu) {
            $menuItemModel = new MenuItemModel();
            $menu['items'] = $menuItemModel->where('menu_id', $id)->findAll();
        }
        return $menu;
    }

    public function getWeeklyMenu()
    {
        $menus = $this->where('status', 'active')
                     ->orderBy('menu_date', 'ASC')
                     ->limit(7)
                     ->findAll();
        
        $menuItemModel = new MenuItemModel();
        foreach ($menus as &$menu) {
            $menu['items'] = $menuItemModel->where('menu_id', $menu['id'])->findAll();
        }
        
        return $menus;
    }

    public function getTodayMenu()
    {
        $today = date('Y-m-d');
        $menu = $this->where('menu_date', $today)->where('status', 'active')->first();
        
        if ($menu) {
            $menuItemModel = new MenuItemModel();
            $menu['items'] = $menuItemModel->where('menu_id', $menu['id'])->findAll();
        }
        
        return $menu;
    }
}