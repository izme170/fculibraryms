<div class="modal fade" id="changeUserPassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Change Password</h1>
            </div>
            <div class="modal-body">
                <form action="/user/change-password/{{Auth::user()->user_id}}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="old_password">Enter old password</label>
                        <input type="password" id="old_password" name="old_password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Enter new password</label>
                        <input type="password" id="password" name="password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password_confirmation">Confirm password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation">
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
