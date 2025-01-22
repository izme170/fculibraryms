<div class="modal fade" id="activate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Are you sure?</h1>
            </div>
            <div class="modal-body">
                <form action="/user/activate/{{$user->user_id}}" method="POST">
                    @csrf
                    @method('PUT')
                    <button class="btn-simple bg-red" type="button" data-bs-dismiss="modal"
                            aria-label="Close">Cancel</button>
                    <button type="submit" class="btn-simple bg-success">Activate</button>
                </form>
            </div>
        </div>
    </div>
</div>
