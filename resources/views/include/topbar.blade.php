<div class="d-flex justify-content-end p-3">
    <div class="dropdown">
        <a class="text-decoration-none d-flex gap-3 align-items-center" href="#" role="button"
            data-bs-toggle="dropdown" aria-expanded="false" style="color: #0E1133;">
            <span>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
            <img src="{{ Auth::user()->user_image ? asset('storage/' . Auth::user()->user_image) : asset('img/default-user-image.png') }}"
                alt="User Image" class="rounded-circle object-fit-cover" width="50" height="50">
        </a>
        <ul class="dropdown-menu">
            <li>
                <form action="/user/update-image/{{ Auth::user()->user_id }}" method="post" class="mb-0" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <label for="user_image" class="dropdown-item">Change Picture</label>
                    <input type="file" id="user_image" name="user_image" accept="image/*" style="display: none"
                        onchange="this.form.submit()">
                </form>
            </li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changeUserPassword">Change Password</a></li>
        </ul>
    </div>
</div>

@include('modals.user.change_password')
