<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DepartmentStorage;

class DepartmentStorageView extends Component
{
    public $sortColumnCreated_At = 'created_at';
    public $sortDirection = 'asc';

    public function sortBy($columnCreated_At)
    {
        if($this->sortColumnCreated_At == $columnCreated_At){
            $this->sortDirection = $this->swapSortDirection();
        }else {
            $this->sortDirection = 'asc';
        }
        $this->sortColumnCreated_At == $columnCreated_At;
    }

    public function swapSortDirection()
    {
        return $this->sortDirection == 'asc' ? 'desc' : 'asc';
    }

    public function render()
    {
        $currentUserDepartment = auth()->user()->Depatrment_id;
        $departmentStorages = DepartmentStorage::where('department_id', $currentUserDepartment)
                            ->where('user_id', auth()->id())
                            ->orderBy($this->sortColumnCreated_At, $this->sortDirection)
                            ->get();
        $userfirstName = auth()->user()->first_name;

        return view('livewire.department-storage', [
            'departmentStorages' => $departmentStorages,
            'userName' => $userfirstName,
        ]);
    }

}
