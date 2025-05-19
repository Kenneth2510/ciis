// Components
import { Head, useForm, usePage } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';

import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/auth-layout';
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
import { useEffect, useState } from 'react';

export default function ForgotPassword({ status }) {
    const { props } = usePage();
    const flash = props.flash || {};

    const [verifyIdDialogOpen, setVerifyIdDialogOpen] = useState(false)
    const [verifiedData, setVerifiedData] = useState(null)

    console.log(flash.showVerifyEidModal);
    
    useEffect(() => {
        if (flash.showVerifyEidModal) {
            setVerifiedData(flash.showVerifyEidModal);
            setVerifyIdDialogOpen(true);
        }
    }, [flash.showVerifyEidModal]);

    const { data, setData, post, processing, errors } = useForm({
        employee_id: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('password.email'));
    };

    const sendPasswordResetMail = (e) => {
        e.preventDefault();
        post(route('send.password.reset.mail'), {
            user: flash.showVerifyEidModal
        });
    };

    return (
        <AuthLayout title="Forgot password" description="Enter your Employee ID to receive a password reset link">
            <Head title="Forgot password" />

            {status && <div className="mb-4 text-center text-sm font-medium text-green-600">{status}</div>}

            <div className="space-y-6">
                <form onSubmit={submit}>
                    <div className="grid gap-2">
                        <Label htmlFor="employee_id">Employee ID</Label>
                        <Input
                            id="employee_id"
                            type="text"
                            name="employee_id"
                            autoComplete="off"
                            value={data.employee_id}
                            autoFocus
                            onChange={(e) => setData('employee_id', e.target.value)}
                        />

                        <InputError message={errors.employee_id} />
                    </div>

                    <div className="my-6 flex items-center justify-start">
                        <Button className="w-full" disabled={processing}>
                            {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                            Verify Employee ID
                        </Button>
                    </div>
                </form>

                <div className="text-muted-foreground space-x-1 text-center text-sm">
                    <span>Or, return to</span>
                    <TextLink href={route('login')}>log in</TextLink>
                </div>
            </div>


        {verifiedData && (
            <AlertDialog open={verifyIdDialogOpen} onOpenChange={setVerifyIdDialogOpen}>
                <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle>Check Employee Details</AlertDialogTitle>
                        <AlertDialogDescription>Please Check and Confirm the following Employee Details</AlertDialogDescription>
                        <hr />
                        <AlertDialogDescription>Employee ID: <span className='font-medium'>{verifiedData.employee_id}</span></AlertDialogDescription>
                        <AlertDialogDescription>Name: <span>{`${verifiedData.fname} ${verifiedData.mname || ''} ${verifiedData.lname}`}</span></AlertDialogDescription>
                        <AlertDialogDescription>Email: {verifiedData.email}</AlertDialogDescription>
                        <span className='mt-5 text-sm text-red-500 italic'>Note: If you did not receive an email, please contact SAPU for coordination</span>
                        <hr />
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                        <AlertDialogAction onClick={sendPasswordResetMail}>Send Temporary Password to Email</AlertDialogAction>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        )}
        </AuthLayout>
    );
}
