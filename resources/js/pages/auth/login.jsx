import { Head, useForm, usePage } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';

import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/auth-layout';
import { useEffect, useState } from 'react';

export default function Login({ status, canResetPassword }) {
    const { props } = usePage();
    const flash = props.flash || {}
    const [warningDialogOpen, setWarningDialogOpen] = useState(false);
    const [lockDialogOpen, setLockDialogOpen] = useState(false);
    const [multiSessionDialogOpen, setMultiSessionDialogOpen] = useState(false);

    useEffect(() => {
        if (flash.showAccountWarningModal) {
            setWarningDialogOpen(true);
        }
    }, [flash.showAccountWarningModal]);

    useEffect(() => {
        if (flash.showAccountLockedModal) {
            setLockDialogOpen(true);
        }
    }, [flash.showAccountLockedModal]);

    useEffect(() => {
        if (flash.showMultiSessionModal) {
            setMultiSessionDialogOpen(true);
        }
    }, [flash.showMultiSessionModal]);

    const { data, setData, post, processing, errors, reset } = useForm({
        employee_id: '',
        password: '',
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    const killSession = (e) => {
        e.preventDefault();
        post(route('kill-session'));
    };

    const closeWarningDialogOpen = () => {
        setWarningDialogOpen(false);
    }

    const closeLockDialogOpen = () => {
        setLockDialogOpen(false);
    }

    const closeMultiSessionDialogOpen = () => {
        setData('employee_id', '');
        setData('password', '');
        setMultiSessionDialogOpen(false);
    }

    return (
        <AuthLayout title="Log in to your account" description="Enter your employee id and password below to log in">
            <Head title="Log in" />

            <form className="flex flex-col gap-6" onSubmit={submit}>
                <div className="grid gap-6">
                    <div className="grid gap-2">
                        <Label htmlFor="employee_id">Employee ID</Label>
                        <Input
                            id="employee_id"
                            required
                            autoFocus
                            tabIndex={1}
                            autoComplete="employee_id"
                            value={data.employee_id}
                            onChange={(e) => setData('employee_id', e.target.value)}
                        />
                        <InputError message={errors.employee_id} />
                    </div>

                    <div className="grid gap-2">
                        <div className="flex items-center">
                            <Label htmlFor="password">Password</Label>
                            {canResetPassword && (
                                <TextLink href={route('password.request')} className="ml-auto text-sm" tabIndex={5}>
                                    Forgot password?
                                </TextLink>
                            )}
                        </div>
                        <Input
                            id="password"
                            type="password"
                            required
                            tabIndex={2}
                            autoComplete="current-password"
                            value={data.password}
                            onChange={(e) => setData('password', e.target.value)}
                            placeholder="Password"
                        />
                        <InputError message={errors.password} />
                    </div>

                    {/* <div className="flex items-center space-x-3">
                        <Checkbox
                            id="remember"
                            name="remember"
                            checked={data.remember}
                            onClick={() => setData('remember', !data.remember)}
                            tabIndex={3}
                        />
                        <Label htmlFor="remember">Remember me</Label>
                    </div> */}

                    <Button type="submit" className="mt-4 w-full" tabIndex={4} disabled={processing}>
                        {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                        Log in
                    </Button>
                </div>
            </form>

            {status && <div className="mb-4 text-center text-sm font-medium text-green-600">{status}</div>}

            <AlertDialog open={warningDialogOpen} onOpenChange={setWarningDialogOpen}>
                <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle>Account Attempt Warning</AlertDialogTitle>
                        <AlertDialogDescription>You've already attempted to log in to your account 3 times. Your Account will be locked after 2 wrong attempts.</AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        {/* <AlertDialogCancel>Cancel</AlertDialogCancel> */}
                        <AlertDialogAction onClick={closeWarningDialogOpen}>Continue</AlertDialogAction>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>

            <AlertDialog open={lockDialogOpen} onOpenChange={setLockDialogOpen}>
                <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle>Account Locked</AlertDialogTitle>
                        <AlertDialogDescription>Your account is now locked. Please Contact SAPU for Inquiry.</AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        {/* <AlertDialogCancel>Cancel</AlertDialogCancel> */}
                        <AlertDialogAction onClick={closeLockDialogOpen}>Continue</AlertDialogAction>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
            
            <AlertDialog open={multiSessionDialogOpen} onOpenChange={setMultiSessionDialogOpen}>
                <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle>Multiple Session Detected</AlertDialogTitle>
                        <AlertDialogDescription>Your account has been detected to have multiple session from multiple browsers/devices. Would you like to end all sessions and proceed?</AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel>Don't Proceed</AlertDialogCancel>
                        <AlertDialogAction onClick={killSession}>End All Session and Continue</AlertDialogAction>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        </AuthLayout>

        
    );
}
