<?php

namespace Tests\Feature\Admin;

use App\Models\BankAccount;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class BankAccountTest extends TestCase
{
    use LazilyRefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    public function test_admin_can_view_bank_accounts_list(): void
    {
        BankAccount::factory(3)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.bank-accounts.index'));

        $response->assertStatus(200);
        $response->assertSee('Rekening Bank');
    }

    public function test_admin_can_create_bank_account(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.bank-accounts.store'), [
                'bank_name' => 'BCA',
                'account_name' => 'Yayasan Sumbangan',
                'account_number' => '1234567890',
            ]);

        $response->assertRedirect(route('admin.bank-accounts.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('bank_accounts', [
            'bank_name' => 'BCA',
            'account_number' => '1234567890',
        ]);
    }

    public function test_admin_can_update_bank_account(): void
    {
        $account = BankAccount::factory()->create(['bank_name' => 'BCA']);

        $response = $this->actingAs($this->admin)
            ->put(route('admin.bank-accounts.update', $account), [
                'bank_name' => 'Mandiri',
                'account_name' => 'Updated Name',
                'account_number' => '999888777',
            ]);

        $response->assertRedirect(route('admin.bank-accounts.index'));
        $this->assertDatabaseHas('bank_accounts', [
            'id' => $account->id,
            'bank_name' => 'Mandiri',
        ]);
    }

    public function test_admin_can_delete_bank_account(): void
    {
        $account = BankAccount::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.bank-accounts.destroy', $account));

        $response->assertRedirect(route('admin.bank-accounts.index'));
        $this->assertModelMissing($account);
    }

    public function test_validation_fails_when_bank_name_is_empty(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.bank-accounts.store'), [
                'bank_name' => '',
                'account_name' => 'Test',
                'account_number' => '123',
            ]);

        $response->assertSessionHasErrors('bank_name');
    }

    public function test_guest_cannot_access_bank_account_routes(): void
    {
        $response = $this->get(route('admin.bank-accounts.index'));
        $response->assertRedirect('/admin/login');
    }
}
