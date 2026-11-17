<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class DashboardTabsTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_transactions_tab_only_shows_transaction_tools(): void
    {
        $response = $this->get('/?tab=transactions');

        $response->assertOk()
            ->assertSee('Riwayat transaksi')
            ->assertSee('Catat transaksi')
            ->assertDontSee('Total pemasukan');
    }

    public function test_goals_tab_only_shows_savings_goal_tools(): void
    {
        $response = $this->get('/?tab=goals');

        $response->assertOk()
            ->assertSee('Target tabungan')
            ->assertSee('Buat target baru')
            ->assertDontSee('Riwayat transaksi');
    }

    public function test_unknown_tab_defaults_to_overview(): void
    {
        $response = $this->get('/?tab=unknown');

        $response->assertOk()
            ->assertSee('Ringkasan keuangan')
            ->assertSee('Total pemasukan');
    }

    public function test_saving_a_transaction_returns_to_the_transactions_tab(): void
    {
        $response = $this->post(route('transactions.store', ['tab' => 'transactions']), [
            'type' => 'income',
            'amount' => 100000,
            'category' => 'Gaji',
            'transaction_date' => '2026-11-17',
        ]);

        $response->assertRedirect(route('dashboard', ['tab' => 'transactions']));
        $this->assertDatabaseHas('transactions', [
            'type' => 'income',
            'category' => 'Gaji',
        ]);
    }

    public function test_saving_a_goal_returns_to_the_goals_tab(): void
    {
        $response = $this->post(route('goals.store', ['tab' => 'goals']), [
            'title' => 'Dana darurat',
            'target_amount' => 5000000,
            'current_amount' => 0,
        ]);

        $response->assertRedirect(route('dashboard', ['tab' => 'goals']));
        $this->assertDatabaseHas('savings_goals', [
            'title' => 'Dana darurat',
            'target_amount' => 5000000,
        ]);
    }
}
