@extends('layouts.admin')

@section('title', 'Kelola User')

@section('content')
    <div class="table-container bg-white p-6 rounded-xl shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-700">Kelola User</h2>

            <form action="{{ route('users.index') }}" method="GET" class="flex items-center">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                    class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400 outline-none">
                <button type="submit"
                    class="ml-2 bg-indigo-600 text-white px-3 py-2 rounded-lg hover:bg-indigo-700 transition-all text-sm">
                    Cari
                </button>
            </form>
            <button data-modal-toggle="createUserModal"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-all">
                + Tambah User
            </button>
        </div>

        <table class="min-w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">#</th>
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Role</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $i => $user)
                    <tr class="border-t">
                        <td class="p-3">{{ $i + 1 }}</td>
                        <td class="p-3">{{ $user->name }}</td>
                        <td class="p-3">{{ $user->email }}</td>
                        <td class="p-3 capitalize">{{ $user->role }}</td>
                        <td class="p-3 text-center">
                            <button data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                data-email="{{ $user->email }}" data-role="{{ $user->role }}"
                                data-modal-target="editUserModal"
                                class="bg-yellow-400 px-3 py-1 rounded text-white hover:bg-yellow-500">
                                Edit
                            </button>

                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Hapus user ini?')"
                                    class="bg-red-500 px-3 py-1 rounded text-white hover:bg-red-600">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>

    @include('admin.users.create')
    @include('admin.users.edit')


@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const createModal = document.getElementById('createUserModal');
            const editModal = document.getElementById('editUserModal');
            const editForm = document.getElementById('editUserForm');
            const nameInput = document.getElementById('edit_name');
            const emailInput = document.getElementById('edit_email');
            const roleSelect = document.getElementById('edit_role');
            const passwordInput = document.getElementById('edit_password');

            // === Buka modal CREATE ===
            document.addEventListener('click', (e) => {
                const openCreate = e.target.closest('[data-modal-toggle="createUserModal"]');
                if (!openCreate) return;

                createModal.classList.remove('hidden');
                createModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });

            // === Buka modal EDIT ===
            document.addEventListener('click', (e) => {
                const btn = e.target.closest('[data-modal-target="editUserModal"]');
                if (!btn) return;

                const id = btn.dataset.id;
                const name = btn.dataset.name;
                const email = btn.dataset.email;
                const role = btn.dataset.role;

                nameInput.value = name;
                emailInput.value = email;
                roleSelect.value = role;
                passwordInput.value = '';

                editForm.action = `/users/${id}`;
                editModal.classList.remove('hidden');
                editModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });

            // === Tutup modal (semua) ===
            document.addEventListener('click', (e) => {
                const close = e.target.closest('[data-modal-hide]');
                if (!close) return;

                const target = document.getElementById(close.dataset.modalHide);
                if (target) {
                    target.classList.add('hidden');
                    target.style.display = 'none';
                    document.body.style.overflow = '';
                }
            });

            // === Klik di luar modal untuk menutup ===
            [createModal, editModal].forEach(modal => {
                modal?.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        modal.classList.add('hidden');
                        modal.style.display = 'none';
                        document.body.style.overflow = '';
                    }
                });
            });

            // === Submit Edit pakai AJAX ===
            editForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(editForm);
                const action = editForm.action;

                try {
                    const response = await fetch(action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    if (!response.ok) throw await response.json();

                    alert('Data user berhasil diperbarui!');
                    editModal.classList.add('hidden');
                    editModal.style.display = 'none';
                    document.body.style.overflow = '';
                    location.reload();
                } catch (error) {
                    console.error(error);
                    alert('Gagal memperbarui user.');
                }
            });
        });
    </script>
@endpush
