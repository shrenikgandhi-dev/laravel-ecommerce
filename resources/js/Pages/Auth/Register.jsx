import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import PhoneInput from 'react-phone-input-2';
import 'react-phone-input-2/lib/style.css';

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        fname: '',
        lname: '',
        email: '',
        uname: '',
        country_code: '',
        phone: '',
        password: '',
        password_confirmation: '',
        profile_picture: '',
        photo_id: '',
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('register'), {
            forceFormData: true,
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };

    return (
        <GuestLayout title="Guest Register">
            <Head title="Register" />

            <form onSubmit={submit}>
                <div>
                    <InputLabel htmlFor="fname" value="First Name" />

                    <TextInput
                        id="fname"
                        name="fname"
                        value={data.fname}
                        className="mt-1 block w-full"
                        autoComplete="given-name"
                        isFocused={true}
                        onChange={(e) => setData('fname', e.target.value)}
                        required
                    />

                    <InputError message={errors.fname} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="lname" value="Last Name" />

                    <TextInput
                        id="lname"
                        name="lname"
                        value={data.lname}
                        className="mt-1 block w-full"
                        autoComplete="family-name"
                        onChange={(e) => setData('lname', e.target.value)}
                        required
                    />

                    <InputError message={errors.lname} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        className="mt-1 block w-full"
                        autoComplete="username"
                        onChange={(e) => setData('email', e.target.value)}
                        required
                    />

                    <InputError message={errors.email} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel className='mb-1' htmlFor="phone" value="Phone" />

                    <PhoneInput
                        value={data.phone}
                        onChange={(phone, country) => { 
                            setData('phone', phone);
                            setData('country_code', country.dialCode);
                        }}
                        country={'in'}
                        enableSearch
                        inputStyle={{
                            width: '100%',
                        }}
                        inputProps={{
                            id: 'phone',
                            name: 'phone',
                            required: true,
                            minLength: 6,
                            autoComplete: 'tel',
                        }}
                    />

                    <InputError message={errors.phone} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="uname" value="User Name" />

                    <TextInput
                        id="uname"
                        name="uname"
                        value={data.uname}
                        className="mt-1 block w-full"
                        onChange={(e) => setData('uname', e.target.value)}
                        required
                    />

                    <InputError message={errors.uname} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="password" value="Password" />

                    <TextInput
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        className="mt-1 block w-full"
                        autoComplete="new-password"
                        onChange={(e) => setData('password', e.target.value)}
                        required
                    />

                    <InputError message={errors.password} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel
                        htmlFor="password_confirmation"
                        value="Confirm Password"
                    />

                    <TextInput
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        value={data.password_confirmation}
                        className="mt-1 block w-full"
                        autoComplete="new-password"
                        onChange={(e) =>
                            setData('password_confirmation', e.target.value)
                        }
                        required
                    />

                    <InputError
                        message={errors.password_confirmation}
                        className="mt-2"
                    />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="profile_picture" value="Profile Picture" />

                    <TextInput
                        type="file"
                        id="profile_picture"
                        name="profile_picture"
                        className="mt-1 block w-full"
                        onChange={(e) => setData('profile_picture', e.target.files[0])}
                    />

                    <InputError message={errors.profile_picture} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="photo_id" value="Photo ID" />

                    <TextInput
                        type="file"
                        id="photo_id"
                        name="photo_id"
                        className="mt-1 block w-full"
                        onChange={(e) => setData('photo_id', e.target.files[0])}
                    />

                    <InputError message={errors.photo_id} className="mt-2" />
                </div>

                <div className="mt-4 flex items-center justify-end">
                    <Link
                        href={route('login')}
                        className="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Already registered?
                    </Link>

                    <PrimaryButton className="ms-4" disabled={processing}>
                        Register
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
}
