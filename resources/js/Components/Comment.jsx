import React from "react";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";

dayjs.extend(relativeTime);

export default function Comment({ comment }) {
    return (
        <div className="p-4 flex space-x-2">
            <div className="flex-1">
                <div className="flex justify-between items-center">
                    <div>
                        <span className="text-sm text-gray-600">
                            {comment.user.name}
                        </span>
                        <span className="ml-1 text-sm text-gray-600">
                        &middot; {dayjs(comment.created_at).fromNow()}
                        </span>
                    </div>
                </div>
                <p className="mt-4 text-lg text-gray-900">{comment.comment}</p>
            </div>
        </div>
    );
}
