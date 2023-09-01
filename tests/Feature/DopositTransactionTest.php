<?php

namespace Tests\Feature;

use App\Models\User;
use App\Http\Requests\DepositRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DopositTransactionTest extends TestCase
{
    use RefreshDatabase;
    public function testCreateMethodReturnsView()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->get(route('deposit'));
        // dd($response);
        $response->assertViewIs('deposit');
        $response->assertStatus(200);
    }


    public function testDepositSuccessful()
    {
        $user = User::factory()->create(['balance' => 100]);

        $response = $this->actingAs($user)
            ->post(route('deposit'), ['amount' => 50]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Deposit successful.');

        $this->assertDatabaseHas('transactions', [
            'amount' => 50,
            'type' => 'credit',
            'balance' => 150,
            'user_id' => $user->id,
        ]);
        $this->assertDatabaseHas('users', [
            'balance' => 150,
            'id' => $user->id,
        ]);
    }

    public function testDepositFailed()
    {
        $user = User::factory()->create(['balance' => 100]);

        $response = $this->actingAs($user)
            ->post(route('deposit'), ['amount' => 0]);
        

        $response->assertRedirect();
        $response->assertSessionHasErrors(['amount']);

    }


}
