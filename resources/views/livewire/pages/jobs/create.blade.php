<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">Create New Job Posting</h1>
    </div>

    <div 
        x-data="{ showMessage: false }" 
        x-init="$watch('showMessage', value => { if (value) setTimeout(() => showMessage = false, 3000); })"
        x-show="showMessage"
        class="transition-all duration-500 ease-in-out"
    >
        @if(session()->has('message'))
            <div 
                class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg mb-4"
                x-init="showMessage = true"
            >
                {{ session('message') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div 
                class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg mb-4"
                x-init="showMessage = true"
            >
                {{ session('error') }}
            </div>
        @endif
    </div>

    <form wire:submit.prevent="storeJob" class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Left Section -->
        <div class="space-y-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Job Title</label>
                <input type="text" id="title" wire:model="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Enter job title">
                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Job Description</label>
                <textarea id="description" wire:model="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Enter job description"></textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="experience" class="block text-sm font-medium text-gray-700">Experience</label>
                <input type="text" id="experience" wire:model="experience" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="e.g., 4-5 years">
                @error('experience') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="salary" class="block text-sm font-medium text-gray-700">Salary</label>
                <input type="text" id="salary" wire:model="salary" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="e.g., 3 to 4 LPA">
                @error('salary') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                <input type="text" id="location" wire:model="location" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="e.g., Remote / Pune">
                @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="extra_info" class="block text-sm font-medium text-gray-700">Extra Information</label>
                <input type="text" id="extra_info" wire:model="extra_info" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="e.g., Full time, Urgent">
                @error('extra_info') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                <p class="mt-1 text-sm text-gray-500">
                    Please use comma separated values.
                </p>
            </div>
        </div>

        <!-- Right Section -->
        <div class="space-y-6">
            <div>
                <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                <input type="text" id="company_name" wire:model="company_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Enter company name">
                @error('company_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="company_logo" class="block text-sm font-medium text-gray-700">Company Logo</label>
                <input type="file" id="company_logo" wire:model="company_logo" class="mt-1 block w-full text-sm">
                @error('company_logo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="skills" class="block text-sm font-medium text-gray-700">Skills</label>
                <select wire:model="selected_skills" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @foreach($skills as $skill)
                        <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                    @endforeach
                </select>
                @error('selected_skills') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
          <!-- Submit Button -->
          <div class="flex">
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Create Job Posting</button>
        </div>
    </form>
</div>
