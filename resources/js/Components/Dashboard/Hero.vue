<script setup lang="ts">
import { ref, onMounted } from "vue";
import axios from "axios";
import Icon from "../Icon.vue";

// Define a reactive variable to store jobs data
const jobs = ref();
const BASE_URL = 'http://127.0.0.1:8000';

const filters = ref({
  title: "",
  location: "",
});

const filterJobs = async () => {
  try {
    const response = await axios.get("/api/jobs", {
      params: {
        title: filters.value.title,
        location: filters.value.location,
      },
    });
    jobs.value = response.data;
  } catch (error) {
    console.error("Error filtering job postings:", error);
  }
};

// Fetch jobs from the API when the component is mounted
onMounted(async () => {
  try {
    // Ensure the API call is correct and accessible
    const response = await axios.get("/api/jobs");
    jobs.value = response.data;
  } catch (error) {
    console.error("Error fetching job postings:", error);
  }
});

const formatDateTime = (createdAt: string) => {
  const date = new Date(createdAt);
  return `${date.getFullYear()}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getDate().toString().padStart(2, '0')} ${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`;
};

</script>

<template>
  <div class="container">
    <div class="bg-slate-100 relative">
      <div class="container py-32 text-center flex flex-col gap-8 relative">
        <div class="space-y-4">
          <h1 class="text-3xl lg:text-6xl font-bold">Find your dream job</h1>
          <p class="text-sm lg:text-base text-slate-600">
            Looking for jobs? Browse our latest job openings to
            view & apply to
            the best jobs today!
          </p>
        </div>
        <!-- Search -->
        <div>
          <div
            class="bg-white w-full border rounded-full overflow-hidden border-gray-200 max-w-3xl mx-auto flex items-center justify-center"
          >
            <div class="flex-1 flex items-center border-r">
              <span class="pl-5">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="w-6 h-6"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
                  />
                </svg>
              </span>
              <input
                placeholder="Job title or keyword"
                class="py-4 shadow-none border-none focus:outline-none focus:ring-0 outline-none ring-0"
                type="text"
                v-model="filters.title"
              />
            </div>
            <div class="flex-1 flex items-center">
              <span class="pl-5">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="w-6 h-6"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"
                  />
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"
                  />
                </svg>
              </span>
              <input
                placeholder="Location"
                class="py-4 shadow-none border-none focus:outline-none focus:ring-0 outline-none ring-0"
                type="text"
                v-model="filters.location"
              />
            </div>
            <button @click="filterJobs" class="bg-brand px-6 text-sm font-medium py-2 rounded-full text-white mr-3">
              Find
              jobs
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-5">
      <!-- Example Job Cards Loop -->
      <div
        v-for="(job, index) in jobs"
        :key="index"
        class="bg-white border border-gray-200 rounded-lg shadow-md p-6 relative"
      >
        <div class="relative">
          <!-- Top Section -->
          <div class="flex items-start justify-between">
            <!-- Logo and Title -->
            <div class="flex items-start">
              <img
                :src="`${BASE_URL}/storage/${job.company_logo}`"
                alt="Company Logo"
                class="h-12 w-auto rounded-full shadow-sm"
              />
              <div class="ml-4">
                <h6 class="text-md font-bold text-gray-800">{{ job.title }}</h6>
                <p class="text-sm text-gray-500">{{ job.company_name }}</p>
              </div>
            </div>

            <!-- Extra Info Tags -->
            <div class="flex flex-wrap gap-2">
              <span
                v-for="(info, index) in job.extra_info.split(',')"
                :key="index"
                class="bg-amber-100 text-amber-800 text-xs font-medium px-2 py-1 rounded-full"
              >{{ info.trim() }}</span>
            </div>
          </div>

          <!-- Details Section -->
          <div class="mt-4 space-y-2">
            <!-- Experience | Salary | Location -->
            <div class="flex items-center space-x-4 text-xs text-gray-700">
              <div class="flex items-center space-x-1">
                <Icon name="briefcase" class="w-4 h-4 text-gray-600" />
                <span>{{ job.experience }}</span>
              </div>
              <span>|</span>
              <div class="flex items-center space-x-1">
                <Icon name="rupee" class="w-4 h-4 text-gray-600" />
                <span>{{ job.salary }}</span>
              </div>
              <span>|</span>
              <div class="flex items-center space-x-1">
                <Icon name="location" class="w-4 h-4 text-gray-600" />
                <span>{{ job.location }}</span>
              </div>
            </div>

            <!-- Full Description -->
            <p class="text-xs text-gray-600 mt-2">{{ job.description }}</p>
          </div>

          <!-- Selected Skills -->
          <div class="mt-4">
            <div class="text-xs text-gray-600 flex items-center space-x-2">
              <span
                v-for="(skill, index) in job.skills"
                :key="index"
                class="after:content-['•'] after:mx-1 last:after:content-none"
              >{{ skill.name }}</span>
            </div>
          </div>
          <!-- Bottom Section -->
          <div class="absolute right-1 text-xs text-gray-500">
            {{ job.relative_time }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
