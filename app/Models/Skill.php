<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'created_by'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function jobPostings()
    {
        return $this->belongsToMany(Jobpostings::class, 'job_skill', 'skill_id', 'jobpostings_id');
    }
}
