<div class="tab-pane fade in active" id="notifications">
    @if ((int) count(auth()->user()->unreadNotifications) > 0)
    @else
        <div class="alert alert-info alert-important" role="alert">
            <strong>Info:</strong> Er zijn geen ongelezen notificaties.
        </div>
    @endif
</div>