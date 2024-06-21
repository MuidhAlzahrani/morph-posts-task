import React from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, useForm } from "@inertiajs/react";
import InputError from "@/Components/InputError";
import PrimaryButton from "@/Components/PrimaryButton";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import Post from "@/Components/Post";
import Comment from "@/Components/Comment";

dayjs.extend(relativeTime);
export default function Show({ auth, post, comments }) {
    const {
        data,
        setData,
        post: postComment,
        processing,
        reset,
        errors,
    } = useForm({
        comment: "",
    });

    const submit = (e) => {
        e.preventDefault();

        postComment(route("comments.store", post.id), {
            onSuccess: () => reset(),
        });
    };
    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title={`${post.user.name}'s Post`} />
            <div className="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
                <div className="mt-6 bg-white shadow-sm rounded-lg divide-y">
                    <div>
                        <Post post={post} />
                        <form onSubmit={submit} className="px-4 pb-4">
                            <textarea
                                value={data.comment}
                                onChange={(e) =>
                                    setData("comment", e.target.value)
                                }
                                className="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm resize-none h-24"
                                placeholder="Comment"
                            ></textarea>
                            <InputError
                                message={errors.comment}
                                className="mt-4"
                            />
                            <PrimaryButton
                                className="mt-4"
                                disabled={processing}
                            >
                                Comment
                            </PrimaryButton>
                        </form>
                    </div>
                    {post.comments.length > 0 && (
                        <div className="p-6">
                            {[...post.comments]
                                .reverse()
                                .map((comment, index) => (
                                    <React.Fragment key={comment.id}>
                                        <Comment comment={comment} />
                                        {index !== post.comments.length - 1 && (
                                            <hr className="my-4 border-gray-200" />
                                        )}
                                    </React.Fragment>
                                ))}
                        </div>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
