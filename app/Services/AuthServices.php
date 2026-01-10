<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class AuthServices
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    protected function sendResetPasswordEmail(
        string $to,
        string $name,
        string $link
    ): void {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = config('mail.mailers.smtp.host');
            $mail->SMTPAuth   = true;
            $mail->Username   = config('mail.mailers.smtp.username');
            $mail->Password   = config('mail.mailers.smtp.password');
            $mail->Port       = config('mail.mailers.smtp.port');

            // ✅ FIX UTAMA DI SINI
            $encryption = config('mail.mailers.smtp.encryption');
            if ($encryption === 'ssl') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } elseif ($encryption === 'tls') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            } else {
                $mail->SMTPSecure = false;
            }

            $mail->setFrom(
                config('mail.from.address'),
                config('mail.from.name')
            );

            $mail->addAddress($to, $name);
            $mail->isHTML(true);
            $mail->Subject = 'Reset Password Akun Anda';

            $mail->Body = "
            <p>Halo <b>{$name}</b>,</p>
            <p>Klik link di bawah untuk reset password:</p>
            <p><a href='{$link}'>Reset Password</a></p>
            <p>Link ini berlaku selama 60 menit.</p>
        ";

            $mail->send();
        } catch (Exception $e) {
            throw $e;
        }
    }



    public function register(array $data): void
    {
        $data['password'] = Hash::make($data['password']);

        $this->userRepository->create($data);
    }


    public function login(array $credentials): array
    {
        $user = $this->userRepository->findByEmail($credentials['email']);

      

        // if (! $user || ! Hash::check($credentials['password'], $user->password)) {
        //     throw ValidationException::withMessages([
        //         'email' => ['Email atau password salah'],
        //     ]);
        // }

        // 🔥 WAJIB agar auth()->user() aktif
        // Auth::login(user: $user);

        // optional tapi best practice
        $user->tokens()->delete();

        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    public function getCurrentUser()
    {
        return auth()->user();
    }

    public function updateCurrentUser(array $data)
    {
        return $this->userRepository->update(auth()->id(), $data);
    }

    /**
     * ============================
     * DELETE USER
     * ============================
     */
    public function deleteUser(string $id): void
    {
        $this->userRepository->delete($id);
    }

    public function requestPasswordReset(string $email): void
    {
        $user = $this->userRepository->findByEmail($email);

        if (! $user) {
            // sengaja silent → anti email enumeration
            return;
        }

        $token = $this->userRepository->createPasswordResetToken($email);

        $resetLink = config('app.frontend_url')
            . "/reset-password?email={$email}&token={$token}";

        $this->sendResetPasswordEmail(
            to: $email,
            name: $user->name,
            link: $resetLink
        );
    }

    public function resetPassword(
        string $email,
        string $token,
        string $newPassword
    ): void {
        $isValid = $this->userRepository
            ->validatePasswordResetToken($email, $token);

        if (! $isValid) {
            throw ValidationException::withMessages([
                'token' => ['Token reset password tidak valid atau kadaluarsa'],
            ]);
        }

        $this->userRepository->resetPassword($email, $newPassword);
    }
}
