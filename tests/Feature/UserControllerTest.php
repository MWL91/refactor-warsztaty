<?php

namespace Tests\Feature;

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterAndNotifySuccessfully()
    {
        Mail::fake();

        // Dane wejściowe
        $data = [
            'username' => 'testuser',
            'email' => 'test@example.com',
        ];

        // Wysłanie żądania POST do rejestracji
        $response = $this->postJson('/api/register', $data);

        // Sprawdzenie odpowiedzi
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'user' => ['id', 'username', 'email'],
            'token'
        ]);

        // Sprawdzenie, czy użytkownik został dodany do bazy danych
        $this->assertDatabaseHas('users', [
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);

        // Sprawdzenie, czy token został dodany do tabeli user_tokens
        $user = User::where('email', 'test@example.com')->first();
        $this->assertDatabaseHas('user_tokens', [
            'user_id' => $user->id,
        ]);

        // Sprawdzenie logów
        Log::shouldReceive('info')
            ->with('User Registered and Email Sent');
    }

    public function testRegisterFailsIfEmailAlreadyExists()
    {
        // Tworzenie istniejącego użytkownika
        $existingUser = User::factory()->create([
            'email' => 'existing@example.com',
        ]);

        // Dane wejściowe z już istniejącym emailem
        $data = [
            'username' => 'testuser',
            'email' => 'existing@example.com',
        ];

        // Wysłanie żądania POST do rejestracji
        $response = $this->postJson('/api/register', $data);

        // Sprawdzenie, czy odpowiedź zawiera błąd
        $response->assertStatus(422);
        $this->assertNotEmpty($response->json('errors.email'));
    }

    public function testRegisterFailsIfInvalidUsername()
    {
        // Dane wejściowe z niepoprawną nazwą użytkownika
        $data = [
            'username' => 'invalid_username!',
            'email' => 'test@example.com',
        ];

        // Wysłanie żądania POST do rejestracji
        $response = $this->postJson('/api/register', $data);

        // Sprawdzenie, czy odpowiedź zawiera błąd
        $response->assertStatus(500);
        $this->assertStringContainsString("Username can only contain letters and numbers.", $response->getContent());
    }

    public function testRegisterFailsIfTokenNotGenerated()
    {
        $this->markTestSkipped('TODO');
        // Wywołanie wyjątku podczas generowania tokenu
        DB::shouldReceive('table->insert')
            ->once()
            ->andThrow(new \Exception("Token validation failed."));

        // Dane wejściowe
        $data = [
            'username' => 'testuser',
            'email' => 'test@example.com',
        ];

        // Wysłanie żądania POST do rejestracji
        $response = $this->postJson('/api/register', $data);

        // Sprawdzenie, czy odpowiedź zawiera błąd
        $response->assertStatus(500);
        $this->assertStringContainsString("Token validation failed.", $response->getContent());
    }

    public function testRegisterFailsIfEmailNotSent()
    {
        // Wywołanie wyjątku podczas wysyłania e-maila
        Mail::shouldReceive('raw')
            ->once()
            ->andThrow(new \Exception("Error sending email."));

        // Dane wejściowe
        $data = [
            'username' => 'testuser',
            'email' => 'test@example.com',
        ];

        // Wysłanie żądania POST do rejestracji
        $response = $this->postJson('/api/register', $data);

        // Sprawdzenie, czy odpowiedź zawiera błąd
        $response->assertStatus(500);
        $this->assertStringContainsString("Error sending email.", $response->getContent());
    }
}
