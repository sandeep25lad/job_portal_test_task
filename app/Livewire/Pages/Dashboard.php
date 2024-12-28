<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Skill;
use App\Models\Jobpostings;
use App\Models\User;

class Dashboard extends Component
{
    public $jobCount;
    public $userCount;
    public $skillCount;
    public $uniqueCompanyCount;

    public function mount()
    {
        $this->jobCount = Jobpostings::count();
        $this->userCount = User::count();
        $this->skillCount = Skill::count();
        $this->uniqueCompanyCount = Jobpostings::distinct('company_name')->count();
    }

    public function render()
    {
        return view('livewire.pages.dashboard', [
            'jobCount' => $this->jobCount,
            'userCount' => $this->userCount,
            'skillCount' => $this->skillCount,
            'uniqueCompanyCount' => $this->uniqueCompanyCount
        ]);
    }
}
