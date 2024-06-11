<div  wire:key="notificationDrop" wire:poll.1000ms="refreshComments">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staff_heading">Notification</h5>
            <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close">
                <img src="{{asset('img/cross_icon.svg')}}" alt="icon">
            </button>
        </div>
        <div class="modal-body scroll" >
            @forelse ($comments as $comment)
            <div class="dashCard mb-2">
                <div class="dashCardImg d-flex">
                    <img class="me-2" src="{{asset('img/notification_modal.svg')}}" alt="user icon">
                    <h2 class="notificationText"><b> {{$comment->getUser()->full_name}} commented </b> <br> {{$comment->comment}} </h2>
                </div>
                <div class="dashCardHeading">
                   
                    <div class="notiCon d-flex justify-content-end">
                        <!-- <button type="button" class="btn btn-outline-info mt-2 me-3">See Details</button> -->
                        <p class="notificationStatus">{{($comment->created_at->diffForHumans())}}</p>
                    </div>
                </div>
            </div>
            @empty
                {{"No data found"}}
            @endforelse
    {{-- <div class="dashCard mb-2"> --}}
                {{-- <div class="dashCardImg">
                    <img src="{{asset('img/notification_modal.svg')}}" alt="user icon">
                </div>
                <div class="dashCardHeading">
                    <h2>User <b> Rajat Sharma </b> Want to help to add the goals or Daily habits. he send you a support message.</h2>
                    <div class="notiCon">
                        <button type="button" class="primaryBtn backBtn mt-2">View Details</button>
                        <p class="notificationStatus">2:30 pm</p>
                    </div>
                </div> --}}
            {{-- </div> --}}
        </div>
    </div>
</div>