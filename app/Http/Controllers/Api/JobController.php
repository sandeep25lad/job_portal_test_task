<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jobpostings;
use Carbon\Carbon;

class JobController extends Controller
{
    public function index(Request $request)
    {

        $query = Jobpostings::query();

        // Filter by title, skills, and extra_info
        if ($request->has('title') && !empty($request->title)) {
            $query->where(function ($subQuery) use ($request) {
                $subQuery->where('title', 'like', '%' . $request->title . '%')
                        ->orWhere('extra_info', 'like', '%' . $request->title . '%')
                        ->orWhereHas('skills', function ($skillQuery) use ($request) {
                            $skillQuery->where('name', 'like', '%' . $request->title . '%');
                        });
            });
        }

        // Filter by location
        if ($request->has('location') && !empty($request->location)) {
            $query->where(function ($subQuery) use ($request) {
                $subQuery->where('location', 'like', '%' . $request->location . '%')
                         ->orWhere('extra_info', 'like', '%' . $request->location . '%');
            });
        }

        $jobs = $query->with('skills')->get();

        $jobs->transform(function ($job) {
            $job->relative_time = Carbon::parse($job->created_at)->diffForHumans();
            return $job;
        });

        return response()->json($jobs);

    }
}
