<?php

namespace App\Livewire\Pages\Jobs;

use Livewire\Component;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use App\Models\Jobpostings;

class Create extends Component
{
    use WithFileUploads;
    public $title, $description, $experience, $salary, $location, $extra_info;
    public $company_name, $company_logo, $selected_skills = [];

    public function getSkills()
    {
        return Skill::all();
    }

    public function storeJob()
    {
        $this->validate([

            'title' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]+$/',
            'description' => 'required|string|regex:/^[a-zA-Z0-9\s,.-]+$/',
            'experience' => 'required|string|regex:/^[a-zA-Z0-9\s,.-]+$/',
            'salary' => 'required|string|regex:/^[a-zA-Z0-9\s,.-]+$/',
            'location' => 'required|string|regex:/^[a-zA-Z0-9\s]+$/',
            'extra_info' => 'nullable|string|regex:/^[a-zA-Z0-9\s,.-]*$/',
            'company_name' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]+$/',
            'company_logo' => 'nullable|image|max:2048',
            'selected_skills' => 'required|array',
            'selected_skills.*' => 'exists:skills,id', // Ensuring the selected skills exist
        ]);

        // Handle company logo file upload
        if ($this->company_logo) {
            $logoPath = $this->company_logo->store('company_logos', 'public');
        }

        // Store the job posting (adjust with your actual job model and relationships)
        $job = Jobpostings::create([
            'title' => $this->title,
            'description' => $this->description,
            'experience' => $this->experience,
            'salary' => $this->salary,
            'location' => $this->location,
            'extra_info' => $this->extra_info,
            'company_name' => $this->company_name,
            'company_logo' => $logoPath ?? null,
            'created_by' => Auth::id(),
        ]);

        // Attach selected skills to the job
        $job->skills()->sync($this->selected_skills);

        session()->flash('message', 'Job created successfully.');

        // Reset form fields
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->title = '';
        $this->description = '';
        $this->experience = '';
        $this->salary = '';
        $this->location = '';
        $this->extra_info = '';
        $this->company_name = '';
        $this->company_logo = null;
        $this->selected_skills = [];
    }

    public function render()
    {
        return view('livewire.pages.jobs.create', [
            'skills' => $this->getSkills()
        ]);
    }
}
