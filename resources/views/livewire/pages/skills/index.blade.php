<div class="container mx-auto py-6 px-4">
    <!-- Flash Messages -->
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

    <!-- Page Title -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Skills</h1>
    </div>

    <!-- Main Content Section -->
    <div class="flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-6">
        <!-- Table Section (Left Side) -->
        <div class="w-full lg:w-7/12 bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th colspan="2" class="border border-gray-200 px-4 py-2">Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($skills as $skill)
                        <tr>
                            <td class="border-b border-gray-200 px-4 py-2">{{ $skill->name }}</td>
                            <td class="border-b border-gray-200 px-4 py-2 flex justify-end space-x-2">
                                <button wire:click="edit({{$skill->id}})" class="text-blue-500 hover:underline text-sm">
                                    Edit
                                </button>
                                <button wire:click="confirmDelete({{$skill->id}})" class="text-red-500 hover:underline text-sm">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        @if(count($skills) === 0)
                        <tr>
                            <td class="border-b border-gray-200 px-4 py-2 text-center" colspan="2">No skills found.</td>    
                        </tr>
                        @endif
                    </tbody>
                </table>
                
            </div>
        </div>

        <!-- Form Section (Right Side) -->
        <div class="w-full lg:w-5/12 bg-white shadow-lg rounded-lg p-4 border-t border-gray-150">
            <h2 class="text-xl font-semibold mb-4">{{ $skillId && !$showDeleteModal ? 'Edit Skill' : 'Add New Skill' }}</h2>

            <div>
                <form wire:submit.prevent="store" class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input
                            type="text"
                            id="name"
                            wire:model="name"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Skill name"
                        >
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="mt-4 px-4 py-2 {{ $skillId && !$showDeleteModal ? 'bg-yellow-500' : 'bg-indigo-600' }} text-white rounded hover:{{ $skillId ? 'bg-yellow-600' : 'bg-indigo-700' }}"
                    >
                        {{ $skillId && !$showDeleteModal ? 'Update' : 'Save' }}
                    </button>

                    @if($skillId && !$showDeleteModal)
                        <button
                            type="button"
                            wire:click="resetInput"
                            class="mt-2 px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500"
                        >
                            Cancel
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full">
            <h3 class="text-lg font-bold text-center mb-4">Are you sure you want to delete this skill?</h3>
            <div class="flex justify-between">
                <button wire:click="delete" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete</button>
                <button wire:click="closeDeleteModal" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
            </div>
        </div>
    </div>
    @endif
</div>