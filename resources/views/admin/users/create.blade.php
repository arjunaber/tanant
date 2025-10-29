<!-- Create User Modal -->
<div id="createUserModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl w-full max-w-md">
        <h3 class="text-lg font-semibold mb-4">Tambah User</h3>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <input name="name" type="text" placeholder="Nama" class="w-full mb-3 p-2 border rounded" required>
            <input name="email" type="email" placeholder="Email" class="w-full mb-3 p-2 border rounded" required>

            <select name="role" class="w-full mb-3 p-2 border rounded" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>

            <input name="password" type="password" placeholder="Password" class="w-full mb-3 p-2 border rounded"
                required>

            <div class="flex justify-end gap-2">
                <button type="button" data-modal-hide="createUserModal"
                    class="px-3 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-3 py-2 bg-indigo-600 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>
