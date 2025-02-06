<div>
    @include('include.messages')
    <input type="checkbox" wire:change="updateShowInForms($event.target.checked)"
        @if ($department->show_in_forms) checked @endif>
</div>
