<?php

namespace App\Livewire\Pages\Jobs;

use Livewire\Component;
use App\Models\Jobpostings;

class Index extends Component
{
    public $showDeleteModal = false;
    public array $jobs = [];
    public $selectedJobId = null;

    public function mount()
    {
        $this->loadJobs();
    }

    public function loadJobs()
    {
        $this->jobs = Jobpostings::with('skills')->get()->toArray();
    }

    public function confirmDelete($jobId)
    {
        $this->selectedJobId = $jobId;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        if ($this->selectedJobId) {
            $job = Jobpostings::find($this->selectedJobId);

            if ($job) {
                $job->delete();
                $this->loadJobs();
                session()->flash('message', 'Job deleted successfully.');
            } else {
                session()->flash('error', 'Job not found.');
            }
        }

        $this->showDeleteModal = false;
    }

    public function closeModal()
    {
        $this->showDeleteModal = false;
    }

    public function render()
    {
        return view('livewire.pages.jobs.index', [
            'jobs' => $this->jobs,
        ]);
    }
}
