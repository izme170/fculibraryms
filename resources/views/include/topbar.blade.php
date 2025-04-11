<style>
    .topbar {
        position: sticky;
        top: 0;
        z-index: 1000;
        background-color: white;
        margin-bottom: 10px;
        box-shadow: 0 4px 6px #D3D3D3;
    }
</style>

<div class="topbar rounded p-1 d-flex justify-content-between align-items-center gap-3">
    {{-- User dropdown --}}
    <div class="dropdown rounded p-1">
        <a class="text-decoration-none d-flex gap-1 align-items-center" href="#" role="button"
            data-bs-toggle="dropdown" aria-expanded="false" style="color: #0E1133;">
            <img src="{{ Auth::user()->user_image ? asset('storage/' . Auth::user()->user_image) : asset('img/default-user-image.png') }}"
                alt="User Image" class="object-fit-cover rounded-circle me-2" width="40" height="40">
            <span style="font-size: 15px">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
        </a>
        <ul class="dropdown-menu">
            <li>
                <form action="/user/update-image/{{ Auth::user()->user_id }}" method="post" class="mb-0"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <label for="user_image" class="dropdown-item">Change Picture</label>
                    <input type="file" id="user_image" name="user_image" accept="image/*" style="display: none"
                        onchange="this.form.submit()">
                </form>
            </li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                    data-bs-target="#changeUserPassword">Change Password</a></li>
        </ul>
    </div>
    <div id="datetime"></div>
</div>

<script>
    //Date and time
    function updateDateTime() {
        const now = new Date(); // Get the current date and time

        // Format the date and time
        const options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        };
        const currentDateTime = now.toLocaleString('en-US', options); // Use locale for formatting

        // Display date and time in the div
        document.getElementById('datetime').textContent = currentDateTime;
    }

    setInterval(updateDateTime, 1000); // Update every second
    updateDateTime(); // Initial call to display date and time right away
</script>

@include('modals.user.change_password')
