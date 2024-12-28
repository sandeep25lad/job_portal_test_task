<?php

namespace App\Livewire\Pages\Skills;

use Livewire\Component;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;
use Log;
class Index extends Component
{
    public $name, $skills, $skillId, $showDeleteModal = false;

    protected $rules = [
        'name' => 'required|string|max:255|unique:skills,name',
    ];

    public function mount()
    {
        $this->refreshSkills();
    }

    public function store()
    {
        try {
            $this->validate([
                'name' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]+$/',
            ]);
            
            if ($this->skillId) {
                $skill = Skill::findOrFail($this->skillId);
                $skill->update(['name' => $this->name]);
                $this->flashMessage('message','Skill updated successfully');
            } else {
                Skill::create(['name' => $this->name, 'created_by' => Auth::id()]);
                $this->name = '';
                $this->flashMessage('message','Skill created successfully');
            }

            $this->resetInput();
            $this->refreshSkills();
        } 
        catch (\Exception $e) {
            Log::info($e->getMessage());
            $this->flashMessage('error',$e->getMessage());
        }
    }

    public function edit($id)
    {
        $skill = Skill::findOrFail($id);
        $this->skillId = $skill->id;
        $this->name = $skill->name;
    }

    public function confirmDelete($id)
    {
        $this->skillId = $id;
        $this->showDeleteModal = true; // Show the delete confirmation modal
    }

    public function delete()
    {
        try {
            $skill = Skill::findOrFail($this->skillId);
            $checkProject = $skill->jobPostings()->exists();
            if($checkProject){
                $this->closeDeleteModal();
                throw new \Exception('Skill is associated with project(s). Please remove the association before deleting.');
            }
            else{   
            $skill->delete();
            $this->refreshSkills();
            $this->closeDeleteModal();
            $this->flashMessage('message','Skill deleted successfully');
            }
        } catch (\Exception $e) {
            $this->flashMessage('error',$e->getMessage());
        }
    }

    public function closeDeleteModal()
    {
        $this->resetInput();
        $this->showDeleteModal = false; // Hide the modal
    }

    public function resetInput()
    {
        $this->name = '';
        $this->skillId = null;
        $this->showDeleteModal = false;
    }

    public function refreshSkills()
    {
        $this->skills = Skill::all();
    }

    // Helper function to handle session flash messages
    public function flashMessage($type = 'message', $message)
    {
        session()->flash($type, $message);
    }

    public function render()
    {
        return view('livewire.pages.skills.index', ['skills' => $this->skills]);
    }
}
