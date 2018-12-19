<?php

declare(strict_types=1);

namespace Orchid\Platform\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DashboardNotification extends Notification
{
    use Queueable;

    /**
     * @var
     */
    public $message;

    /**
     * Status.
     *
     * @var array
     */
    public $type = [
        'info'    => 'text-info',
        'success' => 'text-success',
        'error'   => 'text-danger',
        'warning' => 'text-warning',
    ];

    /**
     * DashboardNotification constructor.
     *
     * @param array $message
     */
    public function __construct(array $message)
    {
        if (! array_key_exists('type', $message)) {
            $message['type'] = 'info';
        }

        $message['type'] = $this->type[$message['type']];
        $message['time'] = Carbon::now();

        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return string[]
     */
    public function via()
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->message;
    }
}
