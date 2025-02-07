<div>
    @include('include.messages')
    <input type="checkbox" title="Show in forms" wire:change="updateShowInForms($event.target.checked)"
        @if ($remark->show_in_forms) checked @endif>
</div>
