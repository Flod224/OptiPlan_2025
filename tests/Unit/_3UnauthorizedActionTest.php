<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class _3UnauthorizedActionTest extends TestCase
{
    /**
     * 
     */
    public function non_admin_cannot_add_session()
    {
      $user = User::factory()->create([
          'role' => 0, 
      ]);

      $this->actingAs($user);

      $sessionData = [
          'description' => 'Test Session',
          'session_start' => now()->format('Y-m-d'),
          'session_end' => now()->addDay()->format('Y-m-d'),
      ];

      $response = $this->post('/sessionAdd', $sessionData);

      $this->assertDatabaseMissing('sessions', $sessionData);

      $response->assertRedirect();
    }
}
