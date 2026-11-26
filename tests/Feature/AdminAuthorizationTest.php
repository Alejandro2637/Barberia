<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_invitado_no_entra_al_dashboard(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_cliente_registrado_recibe_403_en_el_dashboard(): void
    {
        $cliente = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $cliente->role = UserRole::Cliente;
        $cliente->save();

        $this->actingAs($cliente)->get('/dashboard')->assertForbidden();
        $this->actingAs($cliente)->get('/admin/servicios')->assertForbidden();
        $this->actingAs($cliente)->get('/admin/datos')->assertForbidden();
    }

    public function test_barbero_verificado_entra_al_dashboard(): void
    {
        $barbero = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $barbero->role = UserRole::Barber;
        $barbero->save();

        $this->actingAs($barbero)->get('/dashboard')->assertOk();
    }

    public function test_registro_crea_cliente_no_barbero(): void
    {
        $this->post('/register', [
            'name' => 'Cliente Nuevo',
            'email' => 'cliente@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'cliente@example.com',
            'role' => 'cliente',
        ]);
    }
}
