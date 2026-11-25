<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RupiaFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_sent_to_login_and_user_can_register(): void
    {
        $this->get('/')->assertRedirect(route('login'));

        $this->post(route('register.store'), [
            'name' => 'Rupia User',
            'username' => 'rupiauser',
            'email' => 'rupia@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticated();
        $this->get(route('dashboard'))->assertOk()->assertSee('Sisa Saldo');
    }

    public function test_transaction_category_must_belong_to_user_and_match_type(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $foreignCategory = Category::create([
            'user_id' => $otherUser->id,
            'name' => 'Gaji',
            'type' => 'income',
        ]);
        $ownExpenseCategory = Category::create([
            'user_id' => $user->id,
            'name' => 'Makan',
            'type' => 'expense',
        ]);

        $this->actingAs($user)->post(route('transactions.store'), [
            'transaction_date' => '2026-11-25',
            'type' => 'income',
            'category_id' => $foreignCategory->id,
            'amount' => 100000,
        ])->assertSessionHasErrors('category_id');

        $this->actingAs($user)->post(route('transactions.store'), [
            'transaction_date' => '2026-11-25',
            'type' => 'income',
            'category_id' => $ownExpenseCategory->id,
            'amount' => 100000,
        ])->assertSessionHasErrors('category_id');

        $this->assertDatabaseCount('transactions', 0);
    }

    public function test_user_can_record_transaction_and_open_reports(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'user_id' => $user->id,
            'name' => 'Gaji',
            'type' => 'income',
        ]);

        $this->actingAs($user)->post(route('transactions.store'), [
            'transaction_date' => '2026-11-25',
            'type' => 'income',
            'category_id' => $category->id,
            'amount' => 2500000,
            'description' => 'Gaji bulanan',
        ])->assertRedirect(route('transactions.index'));

        $this->get(route('transactions.index'))->assertOk()->assertSee('Gaji bulanan');
        $this->get(route('reports.index'))->assertOk()->assertSee('Tren Arus Keuangan Bulanan');
        $this->get(route('dashboard'))->assertOk()->assertSee('2.500.000');
    }
}
