<?php
namespace App\Services;

use App\Models\Donation;
use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalEntryLine;

class DonationService
{
    public static function postCreate(Donation $donation): void
    {
        if ($donation->type === 'cash') {
            self::createCashJournal($donation);
        } else {
            // For in-kind, journal entry could reflect inventory asset increase
            self::createInKindJournal($donation);
        }
    }

    protected static function getOrCreateAccount(string $code, string $name, string $type): Account
    {
        $acc = Account::where('code', $code)->first();
        if (!$acc) { $acc = Account::create(['code' => $code, 'name' => $name, 'type' => $type]); }
        return $acc;
    }

    protected static function createCashJournal(Donation $donation): void
    {
        $cash = self::getOrCreateAccount('101', 'Cash', 'asset');
        $donationsRevenue = self::getOrCreateAccount('401', 'Donations Revenue', 'revenue');
        $entry = JournalEntry::create([
            'date' => $donation->received_at ? $donation->received_at->toDateString() : now()->toDateString(),
            'entry_type' => 'donation_cash',
            'gate' => 'donation',
            'locked' => false,
        ]);
        JournalEntryLine::create([
            'journal_entry_id' => $entry->id,
            'account_id' => $cash->id,
            'debit' => $donation->amount ?? 0,
            'credit' => 0,
        ]);
        JournalEntryLine::create([
            'journal_entry_id' => $entry->id,
            'account_id' => $donationsRevenue->id,
            'debit' => 0,
            'credit' => $donation->amount ?? 0,
        ]);
    }

    protected static function createInKindJournal(Donation $donation): void
    {
        $inventory = self::getOrCreateAccount('120', 'Inventory - In Kind', 'asset');
        $donationsRevenue = self::getOrCreateAccount('401', 'Donations Revenue', 'revenue');
        $entry = JournalEntry::create([
            'date' => $donation->received_at ? $donation->received_at->toDateString() : now()->toDateString(),
            'entry_type' => 'donation_in_kind',
            'gate' => 'donation',
            'locked' => false,
        ]);
        JournalEntryLine::create([
            'journal_entry_id' => $entry->id,
            'account_id' => $inventory->id,
            'debit' => $donation->estimated_value ?? 0,
            'credit' => 0,
        ]);
        JournalEntryLine::create([
            'journal_entry_id' => $entry->id,
            'account_id' => $donationsRevenue->id,
            'debit' => 0,
            'credit' => $donation->estimated_value ?? 0,
        ]);
    }
}
