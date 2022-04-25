<template>
    <div class="flex w-screen h-screen flex-col md:flex-row">
        <div class="bg-white w-full md:w-1/3 p-5 h-2/3">
            <h1 class="text-3xl font-bold mb-4">Filters</h1>
            <form @submit.prevent="getDentistsByFilters">
                <div class="flex flex-col space-y-3">
                    <label class="block text-md font-semibold text-gray-700">
                        Name
                    </label>
                    <input
                        class="form-input rounded-md border-gray-300"
                        type="text"
                        v-model="name"
                        placeholder="Name"
                    />
                    <label class="block text-md font-semibold text-gray-700">
                        Surname
                    </label>
                    <input
                        class="form-input rounded-md border-gray-300"
                        type="text"
                        v-model="surname"
                        placeholder="Surname"
                    />
                    <label class="block text-md font-semibold text-gray-700">
                        Country
                    </label>
                    <select
                        class="form-select rounded-md border-gray-300"
                        v-model="country_id"
                    >
                        <option value="">Select Country</option>
                        <option
                            v-for="country in countries.value"
                            :key="country.id"
                            :value="country.id"
                        >
                            {{ country.name }}
                        </option>
                    </select>
                    <label class="block text-md font-semibold text-gray-700">
                        Created At
                    </label>
                    <input
                        class="form-input rounded-md border-gray-300"
                        type="date"
                        v-model="created_at"
                    />
                    <div class="flex flex-row justify-between pt-2">
                        <button
                            @click="clearFilters"
                            class="border p-2 rounded-md text-blue-600 border-blue-600"
                        >
                            Clear Filters
                        </button>
                        <button
                            class="border p-2 rounded-md bg-blue-600 text-white"
                        >
                            Apply filters
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="w-full p-2 pt-32 md:pt-5">
            <h1 class="text-3xl font-bold mb-1 text-center">Dentists</h1>
            <table class="min-w-full">
                <thead class="bg-white border-b">
                    <tr>
                        <th
                            scope="col"
                            class="text-sm font-bold text-gray-600 px-6 py-4 text-left"
                        >
                            ID
                        </th>
                        <th
                            scope="col"
                            class="text-sm font-bold text-gray-600 px-6 py-4 text-left"
                        >
                            Name
                        </th>
                        <th
                            scope="col"
                            class="text-sm font-bold text-gray-600 px-6 py-4 text-left"
                        >
                            Surname
                        </th>
                        <th
                            scope="col"
                            class="text-sm text-center font-bold text-gray-600 px-6 py-4 text-left"
                        >
                            Gender
                        </th>
                        <th
                            scope="col"
                            class="text-sm font-bold text-gray-600 px-6 py-4 text-left"
                        >
                            Email
                        </th>
                        <th
                            scope="col"
                            class="text-sm text-center font-bold text-gray-600 px-6 py-4 text-left"
                        >
                            Country Name
                        </th>
                        <th
                            scope="col"
                            class="text-sm font-bold text-gray-600 px-6 py-4 text-left"
                        >
                            Created At
                        </th>
                        <th
                            scope="col"
                            class="text-sm font-bold text-gray-600 px-6 py-4 text-left"
                        >
                            Updated At
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="dentist in dentists.value"
                        :key="dentist.id"
                        class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100"
                    >
                        <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                        >
                            {{ dentist.id }}
                        </td>
                        <td
                            class="text-sm text-gray-900 px-6 py-4 whitespace-nowrap"
                        >
                            {{ dentist.name }}
                        </td>
                        <td
                            class="text-sm text-gray-900 px-6 py-4 whitespace-nowrap"
                        >
                            {{ dentist.surname }}
                        </td>
                        <td
                            class="text-sm text-center text-gray-900 px-6 py-4 whitespace-nowrap"
                        >
                            {{ dentist.gender }}
                        </td>
                        <td
                            class="text-sm text-gray-900 px-6 py-4 whitespace-nowrap"
                        >
                            {{ dentist.email }}
                        </td>
                        <td
                            class="text-sm text-center text-gray-900 px-6 py-4 whitespace-nowrap"
                        >
                            {{ dentist.country.name }}
                        </td>
                        <td
                            class="text-sm text-gray-900 px-6 py-4 whitespace-nowrap"
                        >
                            {{ dentist.created_at }}
                        </td>
                        <td
                            class="text-sm text-gray-900 px-6 py-4 whitespace-nowrap"
                        >
                            {{ dentist.updated_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import axiosClient from "../axios";
import { reactive, ref } from "vue";

const dentists = reactive({});
const countries = reactive({});
const name = ref("");
const surname = ref("");
const country_id = ref("");
const created_at = ref("");

name.value = localStorage.getItem("name");
surname.value = localStorage.getItem("surname");
country_id.value = localStorage.getItem("country_id");
created_at.value = localStorage.getItem("created_at");

getDentistsByFilters();

axiosClient
    .get("/countries")
    .then(({ data }) => {
        countries.value = data;
    })
    .catch((error) => {
        console.log(error);
    });

function getDentistsByFilters() {
    localStorage.setItem("name", name.value);
    localStorage.setItem("surname", surname.value);
    localStorage.setItem("country_id", country_id.value);
    localStorage.setItem("created_at", created_at.value);
    axiosClient
        .get(
            `/filter-dentists?name=${name.value}&surname=${surname.value}&country_id=${country_id.value}&created_at=${created_at.value}`
        )
        .then(({ data }) => {
            dentists.value = data;
        })
        .catch((error) => {
            console.log(error);
        });
}
function clearFilters() {
    name.value = "";
    surname.value = "";
    country_id.value = "";
    created_at.value = "";
}
</script>
