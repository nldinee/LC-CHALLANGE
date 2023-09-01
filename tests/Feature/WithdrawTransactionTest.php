<?php

namespace Tests\Feature;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WithdrawTransactionTest extends TestCase
{
    use RefreshDatabase;
    public function testCreateMethodReturnsView()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->get(route('withdraw'));
        // dd($response);
        $response->assertViewIs('withdraw');
        $response->assertStatus(200);
    }

    public function testWithdrawSuccess()
    {
        $user = User::factory()->create(['balance' => 50]);

        $response = $this->actingAs($user)
            ->post(route('withdraw'), ['amount' => 50]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Withdraw successful.');

        $this->assertDatabaseHas('transactions', [
            'amount' => 50,
            'type' => 'debit',
            'balance' => 0,
            'user_id' => $user->id,
        ]);
        // New balance after withdrawal
        $this->assertDatabaseHas('users', ['balance' => 0]);
    }

    public function testInsufficientBalance()
    {
        $user = User::factory()->create(['balance' => 50]);

        $response = $this->actingAs($user)
            ->post(route('withdraw'), ['amount' => 100]);

        $response->assertRedirect();
        // Check validation error
        $response->assertSessionHasErrors(['amount']);

        // Assert that no transaction or balance change occurred
        $this->assertDatabaseMissing('transactions', [
            'amount' => 100,
            'type' => 'debit',
            'user_id' => $user->id,
        ]);
        // Balance remains unchanged
        $this->assertDatabaseHas('users', ['balance' => 50]);
    }


}
