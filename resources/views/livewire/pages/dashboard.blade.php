<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto py-4 space-y-4">
        <div class="flex justify-between items-center py-8">
            <h1 class="text-2xl font-bold">Dashboard</h1>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white border rounded-lg border-gray-100 shadow-sm p-5 space-y-5">
                <h3>Total Job Postings</h3>
                <p class="text-5xl font-bold">{{ $jobCount }}</p>
            </div>
            <div class="bg-white border rounded-lg border-gray-100 shadow-sm p-5 space-y-5">
                <h3>Total Users</h3>
                <p class="text-5xl font-bold">{{ $userCount }}</p>
            </div>
            <div class="bg-white border rounded-lg border-gray-100 shadow-sm p-5 space-y-5">
                <h3>Total Skills</h3>
                <p class="text-5xl font-bold">{{ $skillCount }}</p>
            </div>
            <div class="bg-white border rounded-lg border-gray-100 shadow-sm p-5 space-y-5">
                <h3>Total Companies</h3>
                <p class="text-5xl font-bold">{{ $uniqueCompanyCount }}</p>
            </div>
        </div>
    </div>
</div>
