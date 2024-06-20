import React from 'react';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime'

dayjs.extend(relativeTime);

export default function Comment({ comment }) {
    return (
        <div className="p-4">
            <div className="flex">
                <div className="text-sm text-gray-600">{comment.user.first_name}</div>
                <div className="ml-auto text-sm text-gray-600">{dayjs(comment.created_at).fromNow()}</div>
            </div>
            <div className="mt-2 text-gray-900">{comment.comment}</div>
        </div>
    );
}
