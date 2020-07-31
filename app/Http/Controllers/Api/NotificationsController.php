<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Notification;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Http\Response;

/**
 * Class NotificationsController
 * This class is used to handle and manage notifications integration.
 *
 * @package App\Http\Controllers\Api
 * @property Controller $this
 */
class NotificationsController extends Controller
{
    /**
     * Get Notifications
     * This functions is used to retrieve a list of notifications from a user. The user id will be set to the token
     * user by default; otherwise, it can be overridden by passing a user_id on the payload.
     *
     * @param Request $request
     * @return JsonResponse
     * @author Jason Marchalonis
     * @since 1.0
     */
    public function getNotifications(Request $request)
    {
        $user = $request->user();
        $user_id = $user->id;

        // If user_id is passed, allow it $user_id to be overridden
        if (null != $request->input('user_id')) {
            $user_id = $request->input('user_id');
        }

        // Query the notifications for the requested user from the token
        $records = Notification::query()
            ->get([
                'id',
                'user_id',
                'message',
                'read',
            ])
            ->where('deleted', '')
            ->where('user_id', $user_id)
            ->toArray();

        return $this->setApiResponse(['notifications' => $records]);
    }

    /**
     * Create Notification
     * This function is used to create a new notification record
     *
     * @param Request $request
     * @return JsonResponse
     * @author Jason Marchalonis
     * @since 1.0
     */
    public function createNotification(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required',
            'message' => 'required|max:255',
            'type' => 'required|max:25'
        ]);

        // Check if the User Exists; if does not, we throw an error
        $user = User::where('id', $data['user_id'])->first();
        if (empty($user)) {
            return response(['message' => __('The requested user could not be found')]);
        }

        // Create the new notification record
        $record = Notification::create($data);

        return $this->setApiResponse(true);
    }

    /**
     * Mark Notification Read
     * This function is used to update a notification and mark its status as read. Notifications that have been
     * marked read can later be filtered.
     *
     * @param Request $request
     * @return JsonResponse
     * @author Jason Marchalonis
     * @since 1.0
     */
    public function markNotificationRead(Request $request)
    {
        $data = $request->validate([
            'notification_id' => 'required',
        ]);

        // Check if the Notification Exists; if does not, we throw an error
        $notification = Notification::where('id', $data['notification_id'])->first();
        if (empty($notification)) {
            return response(['message' => __('The requested notification could not be found')]);
        }

        // Update the notification
        $notification->read = true;
        $notification->save();

        return $this->setApiResponse(true);
    }

    /**
     * Delete Notification/Notifications
     * This endpoint is used to soft delete the requested notification id
     *
     * @param Request $request
     * @return JsonResponse
     * @author Jason Marchalonis
     * @since 1.0
     */
    public function deleteNotification(Request $request)
    {
        $data = $request->validate([
            'notification_id' => 'required',
        ]);

        // Check if the Notification Exists; if does not, we throw an error
        $notification = Notification::where('id', $data['notification_id'])->first();
        if (empty($notification)) {
            return response(['message' => __('The requested notification could not be found')]);
        }

        // Delete the notification
        $notification->delete();

        return $this->setApiResponse(true);
    }

}
