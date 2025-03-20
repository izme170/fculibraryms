<style>
    .topbar{
        position: sticky;
        top: 0;
        display: flex;
        justify-content: end;
        align-items: center;
        z-index: 1000;
        background-color: white;
        margin-bottom: 10px;
        box-shadow: 0 4px 6px #D3D3D3;
    }
</style>

<div class="topbar rounded p-1">

    {{-- User dropdown --}}
    <div class="dropdown rounded p-1">
        <a class="text-decoration-none d-flex gap-1 align-items-center" href="#" role="button"
            data-bs-toggle="dropdown" aria-expanded="false" style="color: #0E1133;">
            <span style="font-size: 15px">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
            <img src="{{ Auth::user()->user_image ? asset('storage/' . Auth::user()->user_image) : asset('img/default-user-image.png') }}"
                alt="User Image" class="object-fit-cover rounded-circle ms-2" width="40" height="40">
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
