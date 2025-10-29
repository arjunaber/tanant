<!-- Edit User Modal -->
<div id="editUserModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl w-full max-w-md">
        <h3 class="text-lg font-semibold mb-4">Edit User</h3>

        <form id="editUserForm" method="POST">
            @csrf
            @method('PUT')

            <input id="edit_name" name="name" type="text" placeholder="Nama" class="w-full mb-3 p-2 border rounded"
                required>
            <input id="edit_email" name="email" type="email" placeholder="Email"
                class="w-full mb-3 p-2 border rounded" required>

            <select id="edit_role" name="role" class="w-full mb-3 p-2 border rounded" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>

            <input id="edit_password" name="password" type="password" placeholder="(Opsional) Ganti Password"
                class="w-full mb-3 p-2 border rounded">

            <div class="flex justify-end gap-2">
                <button type="button" data-modal-hide="editUserModal"
                    class="px-3 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-3 py-2 bg-indigo-600 text-white rounded">Update</button>
            </div>
        </form>
    </div>
</div>
