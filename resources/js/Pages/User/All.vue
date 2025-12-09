<script setup>
import { Head, Link, usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { router } from "@inertiajs/vue3";
import { watch } from "vue";

defineProps({
    users: Object,
});

const page = usePage();

watch(
    () => page.props.flash,
    (flash) => {
        if (flash.success) {
            Swal.fire({
                icon: "success",
                title: "Berhasil!",
                text: flash.success,
                timer: 1000,
                showConfirmButton: false,
            });
        }
        if (flash.error) {
            Swal.fire({
                icon: "error",
                title: "Gagal!",
                text: flash.error,
            });
        }
    },
    { deep: true, immediate: true }
);

const deleteUser = (user) => {
    Swal.fire({
        title: "Yakin?",
        text: "Data user akan dihapus permanen!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route("user.destroy", user.id), {
                preserveScroll: true,
            });
        }
    });
};
</script>

<template>
    <div>
        <Head title="User List" />
        <div class="container mt-2">
            <div class="card">
                <div
                    class="card-header d-flex justify-content-between align-items-center"
                >
                    <h2 class="card-title mb-0">Data User</h2>

                    <Link :href="route('user.add')" class="btn btn-primary btn-sm"
                        >Add User</Link
                    >
                </div>
                <div class="card-body">
                    <table
                        class="table table-striped table-hover table-bordered table-responsive"
                    >
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Image</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(user, index) in users" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>
                                    <img
                                        :src="[
                                            user.image
                                                ? `/storage/${user.image}`
                                                : 'https://placehold.co/600x400/png?text=No+Image',
                                        ]"
                                        :alt="user.name"
                                        class="img-thumbnail rounded"
                                        width="50"
                                        height="50"
                                    />
                                </td>
                                <td>
                                    <Link
                                        :href="route('user.edit', user.id)"
                                        class="btn btn-sm btn-warning me-1"
                                        >Edit</Link
                                    >
                                    <button
                                        @click="deleteUser(user)"
                                        class="btn btn-sm btn-danger"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
