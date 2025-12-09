<script setup>
import { Head, router, useForm } from "@inertiajs/vue3";

const props = defineProps({
    user: Object,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: props.user.password,
    image: null,
});

function submit() {
    form.post(`/user/update/${props.user.id}`);
}
</script>
<template>
    <Head title="Edit User" />
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Edit User</h2>
            </div>
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="form.name"
                                placeholder="Enter name"
                            />
                            <div class="text-danger" v-if="form.errors.name">
                                {{ form.errors.name }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input
                                type="email"
                                class="form-control"
                                v-model="form.email"
                                placeholder="Enter email"
                            />
                            <div class="text-danger" v-if="form.errors.email">
                                {{ form.errors.email }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"
                                >Password (Kosongkan jika tidak ingin
                                mengubah)</label
                            >
                            <input
                                type="password"
                                class="form-control"
                                v-model="form.password"
                                placeholder="Enter password"
                            />
                            <div
                                class="text-danger"
                                v-if="form.errors.password"
                            >
                                {{ form.errors.password }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <div v-if="props.user.image">
                                <img
                                    :src="`/storage/${props.user.image}`"
                                    alt="User Image"
                                    class="img-thumbnail mb-2"
                                    style="max-width: 200px"
                                />
                            </div>
                            <input
                                class="form-control"
                                type="file"
                                @input="form.image = $event.target.files[0]"
                            />
                            <progress
                                v-if="form.progress"
                                :value="form.progress.percentage"
                                max="100"
                            >
                                {{ form.progress.percentage }}%
                            </progress>
                            <div class="text-danger" v-if="form.errors.image">
                                {{ form.errors.image }}
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
