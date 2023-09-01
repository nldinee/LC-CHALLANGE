<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransferTransactionTest extends TestCase
{
    use RefreshDatabase;
    public function testCreateMethodReturnsView()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->get(route('transfer'));
        // dd($response);
        $response->assertViewIs('transfer');
        $response->assertStatus(200);
    }


    public function testTransferSuccess()
    {
        $user = User::factory()->create(['balance' => 100]);
        $beneficiary = User::factory()->create(['balance' => 50]);

        $response = $this->actingAs($user)
            ->post(route('transfer'), ['email' => $beneficiary->email, 'amount' => 50]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Transfer successful.');

        // Assert transaction records and balance updates
        $this->assertDatabaseHas('transactions', [
            'amount' => 50,
            'type' => 'debit',
            'user_id' => $user->id,
            'beneficiary' => $beneficiary->id,
        ]);
        $this->assertDatabaseHas('transactions', [
            'amount' => 50,
            'type' => 'credit',
            'user_id' => $beneficiary->id,
            'beneficiary' => $user->id,
        ]);
        $this->assertDatabaseHas('users', ['balance' => 50]); // User's new balance
        $this->assertDatabaseHas('users', ['balance' => 100]); // Beneficiary's new balance
    }

    public function testInsufficientBalance()
    {
        $user = User::factory()->create(['balance' => 50]);
        $beneficiary = User::factory()->create(['balance' => 50]);

        $response = $this->actingAs($user)
            ->post(route('transfer'), ['email' => $beneficiary->email, 'amount' => 100]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['amount']); // Check validation error

        // Assert no transaction or balance change occurred
        $this->assertDatabaseMissing('transactions', [
            'amount' => 100,
            'type' => 'debit',
            'user_id' => $user->id,
            'beneficiary' => $beneficiary->id,
        ]);
        $this->assertDatabaseMissing('transactions', [
            'amount' => 100,
            'type' => 'credit',
            'user_id' => $beneficiary->id,
            'beneficiary' => $user->id,
        ]);
        $this->assertDatabaseHas('users', ['balance' => 50]); // Balances remain unchanged
    }

    public function testSelfTransfer()
    {
        $user = User::factory()->create(['balance' => 100]);

        $response = $this->actingAs($user)
            ->post(route('transfer'), ['email' => $user->email, 'amount' => 50]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['email']); // Check validation error

        // Assert no transaction or balance change occurred
        $this->assertDatabaseMissing('transactions', [
            'user_id' => $user->id,
            'beneficiary' => $user->id,
        ]);
        $this->assertDatabaseHas('users', ['balance' => 100]); // Balance remains unchanged
    }


}
