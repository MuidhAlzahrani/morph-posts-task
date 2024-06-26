import React, { useState } from "react";
import dayjs from "dayjs";
import relativeTime from 'dayjs/plugin/relativeTime';
import { useForm, usePage } from "@inertiajs/react";
import InputError from "./InputError";
import PrimaryButton from "./PrimaryButton";
import Dropdown from "./Dropdown";

dayjs.extend(relativeTime);

export default function Post({ post, href, showCommentsCount }) {
    const { auth } = usePage().props;

    const [editing, setEditing] = useState(false);

    const { data: postData, setData: setPostData, patch, clearErrors, processing: postProcessing, reset: resetPost, errors: postErrors } = useForm({
        message: post.message,
    });

    const submitPost = (e) => {
        e.preventDefault();
        patch(route('posts.update', post.id), { onSuccess: () => setEditing(false) });
    };

    return (
        <div className="p-6 flex space-x-2">
            <div className="flex-1">
                <div className="flex justify-between items-center">
                    <div>
                        <span className="text-gray-800"> {post.user.name} </span>
                        <span className="text-sm text-gray-600 ml-2"> {dayjs(post.created_at).fromNow()} </span>
                        {post.created_at !== post.updated_at && <small className="text-sm text-gray-600"> &middot; edited</small>}
                    </div>
                    {post.user.id === auth.user.id &&
                        <Dropdown>
                            <Dropdown.Trigger>
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </button>
                            </Dropdown.Trigger>
                            <Dropdown.Content>
                                <button className="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out" onClick={() => setEditing(true)}>
                                    Edit
                                </button>
                                <Dropdown.Link as="button" href={route('posts.destroy', post.id)} method="delete">Delete</Dropdown.Link>
                            </Dropdown.Content>
                        </Dropdown>
                    }
                </div>
                {editing
                    ? <form onSubmit={submitPost}>
                        <textarea value={postData.message} onChange={e => setPostData('message', e.target.value)} className="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm resize-none h-28"></textarea>
                        <InputError message={postErrors.message} className="mt-2" />
                        <div className="space-x-2">
                            <PrimaryButton className="mt-4" disabled={postProcessing}>Save</PrimaryButton>
                            <button type="button" className="mt-4" onClick={() => { setEditing(false); resetPost(); clearErrors(); }}>Cancel</button>
                        </div>
                    </form>
                    :   <div> 
                            {href
                                ? 
                                (<a href={href} className="mt-4 text-lg text-gray-900 block">{post.message}</a>)
                                :
                                (<span className="mt-4 text-lg text-gray-900 block">{post.message}</span>)
                            }
                            {showCommentsCount && (
                            <div className="text-sm text-gray-500 flex justify-end items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <span className="ml-1">{post.comments_count}</span> 
                            </div>
                            )}
                        </div>
                }
            </div>
        </div>
    );
}
