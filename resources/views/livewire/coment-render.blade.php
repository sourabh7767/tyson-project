
{{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> --}}
<div wire:key="notificationDrop" wire:poll.1000ms="refreshComments">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staff_heading">Notification</h5>
            <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close">
                <img src="{{asset('img/cross_icon.svg')}}" alt="icon">
            </button>
        </div>
        <div class="modal-body scroll">
            {{-- {{dd($comments)}} --}}
            @forelse ($comments as $comment)
                <a href="{{route('jobs.show',encrypt($comment->job_id))}}">
                    <div class="dashCard mb-2">
                        <div class="dashCardImg d-flex">
                            <img class="me-2" src="{{asset('img/notification_modal.svg')}}" alt="user icon">
                            <h2 class="notificationText">
                                <b> {{$comment->getUser()->full_name}} commented </b>
                                <br> {{$comment->comment}}
                            </h2>
                        </div>
                        <div class="dashCardHeading">
                            <div class="notiCon d-flex justify-content-end">
                                <p class="notificationStatus">{{($comment->created_at->diffForHumans())}}</p>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                {{"No data found"}}
            @endforelse
        </div>
    </div>
</div>

<!-- Popup Modal -->
<div id="newCommentPopup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="newCommentPopupLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newCommentPopupLabel">New Comment Notification</h5>
                <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close">
                    <img src="{{asset('img/cross_icon.svg')}}" alt="icon">
                </button>
            </div>
            <div class="modal-body">
                You have a new comment. Please check your notifications.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap CSS -->

<!-- Bootstrap JS and dependencies -->
{{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}

<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('newCommentNotification', () => {
            // var popup = new bootstrap.Modal(document.getElementById('newCommentPopup'));
            // popup.show();
            alert("New comment");
        });
    });
</script>
