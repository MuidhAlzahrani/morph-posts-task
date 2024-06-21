import React, { useState } from 'react';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime'
import { useForm, usePage } from '@inertiajs/react';
import Dropdown from './Dropdown';
import InputError from './InputError';
import PrimaryButton from './PrimaryButton';

dayjs.extend(relativeTime);

export default function Comment({ comment }) {
    const {auth} = usePage().props;
    const {editing, setEditing} = useState(false);

    const {data, setData, processing, patch, reset, errors} = useForm({
        comment: comment.comment,
    });

    const submit = (e) => {
        e.preventDefault();
        patch(route('comments.update', comment.id), { onSucess: () => setEditing(false) });
    }

    return (
        <div className="p-4 flex space-x-2">
            <div className="flex-1">
                <div className="flex justify-between items-center">
                    <div>
                        <span className="text-sm text-gray-600">{comment.user.name}</span>
                        <span className="ml-2 text-sm text-gray-600">{dayjs(comment.created_at).fromNow()}</span>
                        {comment.created_at !== comment.updated_at && <small className="text-sm text-gray-600"> &middot; edited</small>}
                    </div>
                    
                </div>
                {editing
                    ? <form onSubmit={submit}>
                        <textarea 
                            value={data.comment}
                            onChange={e => setData('comment', e.target.value)}
                            className="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        ></textarea>
                        <InputError message={errors.comment} className='mt-2' />
                        <div className='space-x-2'>
                            <PrimaryButton className='mt-4' disabled={processing}>Save</PrimaryButton>
                            <button type='button' className='mt-4' onClick={() => {setEditing(false); reset(); clearErrors();}}>Cancel</button>
                        </div>
                    </form>
                    : <p className='mt-4 text-lg text-gray-900'>{comment.comment}</p>
                }
            </div>
        </div>
    );
}
