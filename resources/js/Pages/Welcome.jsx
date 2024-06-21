import { Link, Head } from '@inertiajs/react';
import GuestLayout from '@/Layouts/GuestLayout';
import PrimaryButton from '@/Components/PrimaryButton';

export default function Welcome({ auth, laravelVersion, phpVersion }) {
    const handleImageError = () => {
        document.getElementById('screenshot-container')?.classList.add('!hidden');
        document.getElementById('docs-card')?.classList.add('!row-span-1');
        document.getElementById('docs-card-content')?.classList.add('!flex-row');
        document.getElementById('background')?.classList.add('!hidden');
    };

    return (
        <>
            <Head title="Welcome" />
            <GuestLayout>
                <div className="flex flex-col items-center justify-center">
                    <div className="max-w-2xl p-4">
                        <h1 className='text-3xl'>Welcome to My Social App</h1>
                            <nav className="flex flex-1 justify-center items-center mt-4">
                                {auth.user ? (

                                    <Link href={route('dashboard')}>
                                            <PrimaryButton className="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                                Dashboard
                                            </PrimaryButton>
                                        </Link>
                                ) : (
                                    
                                    <div className='flex items-center'>
                                        <Link href={route('login')}>
                                            <PrimaryButton className="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                                Log in
                                            </PrimaryButton>
                                        </Link>

                                        
                                        <Link
                                            href={route('register')}
                                            className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-black dark:hover:text-black/80 dark:focus-visible:ring-white"
                                        >
                                            Register
                                        </Link>
                                    </div>
                                    
                                )}
                            </nav>
                            <Link
                                href={route('adminLogin')}
                                    className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-black dark:hover:text-black/80 dark:focus-visible:ring-white"                                >
                                            Admin Login
                            </Link>
                    </div>
                </div>
            </GuestLayout>
        </>
    );
}
