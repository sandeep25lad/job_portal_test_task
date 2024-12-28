<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jobpostings extends Model
{
    protected $fillable = [
        'title', 'description', 'experience', 'salary', 'location', 'extra_info', 'company_name', 'company_logo', 'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skill');
    }
}
