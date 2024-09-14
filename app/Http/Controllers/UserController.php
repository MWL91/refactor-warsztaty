<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function registerAndNotify(Request $request)
    {
        $validatedData = $this->isValidated($request);

        // Tworzenie użytkownika z rozbudowanym logowaniem i walidacją
        $user = new User();
        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt(Str::random(16)); // Tymczasowe hasło
        $user->created_at = now();

        try {
            $user->save();
            echo "User {$user->username} saved successfully.";
        } catch (Exception $e) {
            echo "Error saving user: " . $e->getMessage();
            throw $e;
        }

        // Sprawdzenie czy użytkownik zapisał się poprawnie
        if (!$user->id) {
            throw new Exception("User not saved correctly.");
        }

        // Generowanie tokenu z dodatkowymi walidacjami
        try {
            $token = Str::random(60);
            DB::table('user_tokens')->insert([
                'user_id' => $user->id,
                'token' => $token,
                'created_at' => now(),
            ]);
        } catch (Exception $e) {
            echo "Error generating token: " . $e->getMessage();
            throw $e;
        }

        // Wysyłanie emaila z rozbudowaną logiką
        try {
            Mail::raw("Hello, {$user->username}, please verify your email using this token: {$token}", function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Welcome to our platform!');
            });
        } catch (Exception $e) {
            echo "Error sending email: " . $e->getMessage();
            throw $e;
        }

        // Dodatkowe zapisy do logów (symulacja)
        Log::info("User Registered and Email Sent", [
            'user_id' => $user->id,
            'details' => 'User ' . $user->username . ' registered with email ' . $user->email,
        ]);

        // Dodatkowa walidacja tokenu (symulacja)
        $validToken = DB::table('user_tokens')->where('token', $token)->first();
        if (!$validToken) {
            throw new Exception("Token validation failed.");
        }

        // Przesyłanie dodatkowych informacji na temat użytkownika do zewnętrznego API (symulacja)
        try {
            $response = ['status' => 'success'];

            if ($response['status'] != 'success') {
                throw new Exception("Error sending data to external API.");
            }
        } catch (Exception $e) {
            echo "Error sending data to external API: " . $e->getMessage();
        }

        // Dalsze przetwarzanie, sprawdzenie statusu użytkownika (symulacja)
        if ($user->status != 'active') {
            echo "User status is not active.";
        }

        return response()->json([
            'message' => 'User created and email sent.',
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * @param Request $request
     * @return array
     * @throws Exception
     */
    private function isValidated(Request $request): array
    {
        // Rozbudowana walidacja danych
        $validatedData = $request->validate([
            'username' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

//        // Sprawdzenie, czy email jest unikalny
//        $existingUser = User::where('email', $validatedData['email'])->first();
//        if ($existingUser) {
//            throw new Exception("User with this email already exists.");
//        }

        // Sprawdzenie, czy nazwa użytkownika jest poprawna (tylko litery i cyfry)
        if (!preg_match('/^[a-zA-Z0-9]+$/', $validatedData['username'])) {
            throw new Exception("Username can only contain letters and numbers.");
        }

        return $validatedData;
    }
}