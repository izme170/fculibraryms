<div class="modal fade" id="editUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit User</h1>
            </div>
            <div class="modal-body">
                <form action="/user/update/{{ $user->user_id }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label" for="role_id">Role</label>
                                <select id="role_id" name="role_id">
                                    <option value="">Select Patron Type</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->role_id }}"
                                            {{ $role->role_id === $user->role_id ? 'selected' : '' }}>
                                            {{ $role->role }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="first_name">Firstname</label>
                                <input type="text" id="first_name" name="first_name" value="{{ $user->first_name }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="middle_name">Middle Name</label>
                                <input type="text" id="middle_name" name="middle_name"
                                    value="{{ $user->middle_name }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="last_name">Lastname</label>
                                <input type="text" id="last_name" name="last_name" value="{{ $user->last_name }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="text" id="email" name="email" value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label" for="contact_number">Contact Number</label>
                                <input type="text" id="contact_number" name="contact_number"
                                    value="{{ $user->contact_number }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="username">Username</label>
                                <input type="text" id="username" name="username" value="{{ $user->username }}">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-row justify-content-end gap-1">
                        <button class="btn-simple bg-red" type="button" data-bs-dismiss="modal"
                            aria-label="Close">Cancel</button>
                        <button class="btn-simple" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
