<?php
namespace App\Http\Controllers;

use App\Mail\VerificationCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    /**
     * Handle an incoming logout request.
     */
    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Handle an incoming login request.
     */
    public function AdminLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            $verificationCode = random_int(100000, 999999);

            session([
                'verification_code' => $verificationCode,
                'user_id'           => $user->id,
            ]);

            Mail::to($user->email)->send(
                new VerificationCodeMail($verificationCode)
            );

            Auth::logout();

            return redirect()
                ->route('custom.verification.form')
                ->with('status', 'Verification code sent to your mail');
        }

        return redirect()->back()
            ->withErrors(['email' => 'Invalid Credentials Provided']);
    }

    /**
     * Show the verification form.
     */
    public function ShowVerification()
    {
        return view('auth.verify');
    }

    /**
     * Verify the verification.
     */
    public function VerificationVerify(Request $request)
    {
        $request->validate(['code' => 'required|numeric']);

        if ($request->code == session('verification_code')) {
            Auth::loginUsingId(session('user_id'));

            session()->forget(['verification_code', 'user_id']);

            return redirect()->intended('/dashboard');
        }

        return redirect()->back()
            ->withErrors(['code' => 'Invalid Verification Code']);

    }

    /**
     * Show the admin profile page.
     */
    public function AdminProfile()
    {
        $profileData = Auth::user();
        return view('admin.admin_profile', compact('profileData'));
    }

    /**
     * Handle the profile update request.
     */
    public function ProfileStore(Request $request)
    {
        $data = Auth::user();

        $data->name    = $request->name;
        $data->email   = $request->email;
        $data->phone   = $request->phone;
        $data->address = $request->address;

        $oldPhotoPath = $data->photo;

        if ($request->hasFile('photo')) {

            $file = $request->file('photo');

            $fileName = time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('upload/user_images'), $fileName);

            $data->photo = $fileName;

            if ($oldPhotoPath && $oldPhotoPath !== $fileName) {
                $this->deleteOldImage($oldPhotoPath);
            }
        }

        $data->save();

        $notification = [
            'message'    => 'Profile updated successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    /**
     * Delete the old image file.
     */
    protected function deleteOldImage(string $fileName)
    {
        $filePath = public_path('upload/user_images/' . $fileName);

        if (file_exists($filePath) && is_file($filePath)) {
            @unlink($filePath);
        }
    }

    /**
     *
     */
    public function PasswordUpdate(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'old_password'     => 'required',
            'new_password'     => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            $notification = [
                'message'    => 'Old password does not match!',
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($notification);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        Auth::logout();

        $notification = [
            'message'    => 'Password changed successfully!',
            'alert-type' => 'success',
        ];
        return redirect()->route('login')->with($notification);
    }

}
