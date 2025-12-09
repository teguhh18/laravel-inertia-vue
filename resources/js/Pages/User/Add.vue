<script setup>
import { Head,Link, router, useForm } from "@inertiajs/vue3";

const user = useForm({
    name: null,
    email: null,
    password: null,
    image: null,
});

function submit() {
    user.post("/user/add");
}
</script>
<template>
    <Head title="Add User" />
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Add User</h2>
            </div>
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="user.name"
                                placeholder="Enter name"
                            />
                            <div class="text-danger" v-if="user.errors.name">
                                {{ user.errors.name }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input
                                type="email"
                                class="form-control"
                                v-model="user.email"
                                placeholder="Enter email"
                            />
                            <div class="text-danger" v-if="user.errors.email">
                                {{ user.errors.email }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input
                                type="password"
                                class="form-control"
                                v-model="user.password"
                                placeholder="Enter password"
                            />
                            <div
                                class="text-danger"
                                v-if="user.errors.password"
                            >
                                {{ user.errors.password }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pilih File</label>
                            <input
                                class="form-control"
                                type="file"
                                @input="user.image = $event.target.files[0]"
                            />
                            <progress
                                v-if="user.progress"
                                :value="file.progress.percentage"
                                max="100"
                            >
                                {{ user.progress.percentage }}%
                            </progress>
                            <div class="text-danger" v-if="user.errors.image">
                                {{ user.errors.image }}
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                    <Link :href="route('user.index')" class="btn btn-secondary ms-2">Back</Link>
                </form>
            </div>
        </div>
    </div>
</template>
