<div  wire:poll.10000ms="refreshNotificationCount" class="notification_box {{empty($commentCounter)?'no_notification_box':''}}" data-bs-toggle="modal" data-bs-target="#notificationDrop">
    <a class="innersubtext notificationCon" href="" data-bs-toggle="modal" data-bs-target="#notification" data-backdrop="static" data-keyboard="false">
        <img src="{{asset('img/notification_.svg')}}" alt="notification" class="notification_img">
      </a>
      </div>