<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

class MiscellaneousApiController extends Controller
{

    public function index(Request $request, ?int $id = null): JsonResponse
    {
        $remoteData = collect();
        $remoteStatus = true;

        $response = Http::timeout(20)->get(
            'https://store.nirmalafoundation.co.in/api/miscellanies',
            $request->all()
        );

        $remoteJson = $response->json();
        $responseData = $remoteJson['data'] ?? $remoteJson;
        $remoteRows = is_array($responseData) && array_is_list($responseData)
            ? $responseData
            : ($responseData ? [$responseData] : []);
        $remoteData = collect($remoteRows)->map(function ($row) {
            $row = (array) $row;
            if (isset($row['id'])) {
                $row['id'] = str_starts_with((string) $row['id'], 'NF#')
                    ? $row['id']
                    : 'NF#' . $row['id'];
            }

            return $row;
        });
        $remoteStatus = $response->successful();

        $statusColumn = $this->miscellaneousStatusColumn();

        $query = DB::table('miscellanies')
            ->leftJoin('miscellaneous_payments as mp', 'mp.miscellaneous_id', '=', 'miscellanies.id')
            ->leftJoin('users as created_by_users', 'created_by_users.id', '=', 'miscellanies.created_by')
            ->leftJoin('users as verified_by_users', 'verified_by_users.id', '=', 'miscellanies.verified_by')
            ->leftJoin('users as approved_by_users', 'approved_by_users.id', '=', 'miscellanies.approved_by')
            ->leftJoin('expense_ledger_masters', 'expense_ledger_masters.id', '=', 'miscellanies.expense_ledger_masters_id')
            ->leftJoin('tds_duties_taxes_ledger_masters', 'tds_duties_taxes_ledger_masters.id', '=', 'miscellanies.tds_duties_taxes_ledger_masters_id')
            ->leftJoin('st_vendors as creditor_master', 'creditor_master.id', '=', 'miscellanies.service_provider')
            ->select([
                // miscellanies - DB fields only
                'miscellanies.id as miscellanies__bill_id',
                'miscellanies.bill_no as miscellanies__bill_no',
                'miscellanies.voucher_date as miscellanies__voucher_date',
                'miscellanies.voucher_number as miscellanies__voucher_number',
                'miscellanies.reference_number as miscellanies__reference_number',
                'miscellanies.bill_amount as miscellanies__bill_amount',
                'miscellanies.tds_bill_amount as miscellanies__tds_bill_amount',
                'miscellanies.tds_deduction_amount as miscellanies__tds_deduction_amount',
                'miscellanies.gst_amount as miscellanies__gst_amount',
                'miscellanies.total_amount as miscellanies__total_amount',
                'miscellanies.created_at as miscellanies__bill_date',
                'miscellanies.due_date as miscellanies__due_date',
                'miscellanies.narration as miscellanies__narration',

                // creditor_master
                'creditor_master.vendor_name as creditor_master__creditor_name',
                'creditor_master.short_name as creditor_master__short_name',
                'creditor_master.pan_number as creditor_master__pan_number',
                'creditor_master.gstin as creditor_master__gstin',
                'creditor_master.gst_registration_type as creditor_master__gst_reg_type',
                'creditor_master.state as creditor_master__state_code',
                'creditor_master.place_of_supply as creditor_master__place_of_supply',
                'creditor_master.tds_applicable as creditor_master__tds_applicable',
                'creditor_master.tds_deductee_type as creditor_master__tds_deductee_type',
                'creditor_master.tds_nature_of_payment as creditor_master__tds_nature_payment',
                'creditor_master.is_lower_deduction as creditor_master__tds_lower_deduction',
                'creditor_master.lower_deduction_rate as creditor_master__tds_lower_ded_rate',
                'creditor_master.lower_deduction_cert_no as creditor_master__tds_cert_no',
                'creditor_master.address as creditor_master__address_line1',
                'creditor_master.address_line_2 as creditor_master__address_line2',
                'creditor_master.pin_code as creditor_master__pincode',
                'creditor_master.opening_balance as creditor_master__opening_balance',
                'creditor_master.credit_limit as creditor_master__credit_limit',
                'creditor_master.credit_days as creditor_master__credit_days',
                'creditor_master.maintain_bill_wise as creditor_master__maintain_billwise',

                // expense ledger
                'expense_ledger_masters.ledger_name as expense_ledger_masters__ledger_name',
                'expense_ledger_masters.ledger_name as expense_ledger_masters__expense_ledger_name',
                'expense_ledger_masters.ledger_group as expense_ledger_masters__ledger_group',
                'expense_ledger_masters.tds_applicable as expense_ledger_masters__tds_applicable',
                'expense_ledger_masters.tds_nature_payment as expense_ledger_masters__tds_nature_payment',
                'expense_ledger_masters.tds_rate as expense_ledger_masters__tds_rate',
                'expense_ledger_masters.tds_threshold as expense_ledger_masters__tds_threshold',
                'expense_ledger_masters.gst_applicable as expense_ledger_masters__gst_applicable',
                'expense_ledger_masters.created_at as expense_ledger_masters__created_at',
                'expense_ledger_masters.updated_at as expense_ledger_masters__updated_at',
                'expense_ledger_masters.default_cost_centre as expense_ledger_masters__default_cost_centre',
                'expense_ledger_masters.gst_charge_type as expense_ledger_masters__gst_charge_type',
                'expense_ledger_masters.sac_hsn_code as expense_ledger_masters__sac_hsn_code',
                'expense_ledger_masters.igst_ledger_name as expense_ledger_masters__igst_ledger_name',
                'expense_ledger_masters.cgst_ledger_name as expense_ledger_masters__cgst_ledger_name',
                'expense_ledger_masters.sgst_ledger_name as expense_ledger_masters__sgst_ledger_name',
                'expense_ledger_masters.rcm_output_gst_ledger as expense_ledger_masters__rcm_output_gst_ledger',
                'expense_ledger_masters.cost_centre_applicable as expense_ledger_masters__cost_centre_applicable',
                'expense_ledger_masters.gst_rate as expense_ledger_masters__gst_rate',
                'expense_ledger_masters.opening_balance as expense_ledger_masters__opening_balance',
                'expense_ledger_masters.description as expense_ledger_masters__description',

                // tds duties taxes ledger
                'tds_duties_taxes_ledger_masters.tds_ledger_name as tds_duties_taxes_ledger_masters__tds_ledger_name',
                'tds_duties_taxes_ledger_masters.under_group as tds_duties_taxes_ledger_masters__under_group',
                'tds_duties_taxes_ledger_masters.tds_section_code as tds_duties_taxes_ledger_masters__tds_section_code',
                'tds_duties_taxes_ledger_masters.tds_section_desc as tds_duties_taxes_ledger_masters__tds_section_desc',
                'tds_duties_taxes_ledger_masters.deductee_type as tds_duties_taxes_ledger_masters__deductee_type',
                'tds_duties_taxes_ledger_masters.tds_rate as tds_duties_taxes_ledger_masters__tds_rate',
                'tds_duties_taxes_ledger_masters.surcharge_applicable as tds_duties_taxes_ledger_masters__surcharge_applicable',
                'tds_duties_taxes_ledger_masters.surcharge_rate as tds_duties_taxes_ledger_masters__surcharge_rate',
                'tds_duties_taxes_ledger_masters.cess_applicable as tds_duties_taxes_ledger_masters__cess_applicable',
                'tds_duties_taxes_ledger_masters.cess_rate as tds_duties_taxes_ledger_masters__cess_rate',
                'tds_duties_taxes_ledger_masters.tds_payment_code as tds_duties_taxes_ledger_masters__tds_payment_code',
                'tds_duties_taxes_ledger_masters.tds_type as tds_duties_taxes_ledger_masters__tds_type',
                'tds_duties_taxes_ledger_masters.annual_threshold as tds_duties_taxes_ledger_masters__annual_threshold',
                'tds_duties_taxes_ledger_masters.single_txn_threshold as tds_duties_taxes_ledger_masters__single_txn_threshold',
                'tds_duties_taxes_ledger_masters.nature_of_payment as tds_duties_taxes_ledger_masters__nature_of_payment',
                'tds_duties_taxes_ledger_masters.opening_balance as tds_duties_taxes_ledger_masters__opening_balance',

                // users
                'created_by_users.id as created_by_users__id',
                'created_by_users.name as created_by_users__name',

                'verified_by_users.id as verified_by_users__id',
                'verified_by_users.name as verified_by_users__name',

                'approved_by_users.id as approved_by_users__id',
                'approved_by_users.name as approved_by_users__name'
            ])
            ->whereNotNull('miscellanies.approved_by')
            ->whereNotNull('miscellanies.approved_at')
            ->whereNot('miscellanies.payment_status', '=', 'completed')
            ->latest('miscellanies.created_at');

        $isLookupRequest = $this->applyLookupFilter($query, $request, $id);

        $rows = $query->get();

        $data = $this->formatJoinedRows($rows);

        if ($isLookupRequest && $data->isEmpty()) {
            return response()->json([
                'status' => false,
                'count' => 0,
                'data' => [],
                'message' => 'Miscellaneous record not found.',
            ], 404);
        }

        $data = $data->map(function ($row) {
            $row = (array) $row;
            if (isset($row['id'])) {
                $row['id'] = str_starts_with((string) $row['id'], 'KGH#')
                    ? $row['id']
                    : 'KGH#' . $row['id'];
            }

            return $row;
        })->values();

        $data = $data->merge($remoteData)->values();
        $isLookupRequest = false;

        $responseData = $isLookupRequest ? $data->first() : $data;

        return response()->json([
            'status' => $remoteStatus,
            'count' => $data->count(),
            'data' => $responseData,
            'message' => 'Miscellanies fetched successfully.',
        ]);
    }

    public function complete($id): JsonResponse
    {
        $record = DB::table('miscellanies')
            ->where('id', $id)
            ->first();

        if (!$record) {
            return response()->json([
                'status' => false,
                'message' => 'Miscellaneous record not found.',
            ], 404);
        }


        if (!empty($record->payment_status != 'completed')) {
            return response()->json([
                'status' => false,
                'message' => 'Miscellaneous record already completed.',
            ]);
        }

        $updated = DB::table('miscellanies')
            ->where('id', $id)
            ->update([
                'payment_status' => "completed",
                'updated_at' => now(),
            ]);

        return response()->json([
            'status' => (bool) $updated,
            'message' => 'Miscellaneous status updated to completed successfully.',
        ]);
    }

    protected function applyLookupFilter($query, Request $request, ?int $routeId = null): bool
    {
        $id = $request->input('id', $routeId);

        if ($id !== null && $id !== '') {
            $query->where('miscellanies.id', $id);

            return true;
        }

        return false;
    }

    protected function miscellaneousStatusColumn(): ?string
    {
        if (Schema::hasColumn('miscellanies', 'status')) {
            return 'status';
        }

        if (Schema::hasColumn('miscellanies', 'payment_status')) {
            return 'payment_status';
        }

        return null;
    }

    protected function applyApprovedStatusFilter($query, ?string $statusColumn): void
    {
        if ($statusColumn === 'status') {
            $query->where('miscellanies.status', 'approved');

            return;
        }

        if ($statusColumn !== null) {
            $query->where(function ($query) use ($statusColumn) {
                $query->whereNull("miscellanies.$statusColumn")
                    ->orWhere("miscellanies.$statusColumn", '!=', 'completed');
            });
        }
    }

    protected function formatJoinedRows(Collection $rows): Collection
    {
        return $rows
            ->groupBy('miscellanies__bill_id')
            ->map(function (Collection $group) {
                $firstRow = $group->first();

                $creditor = $this->extractPrefixedData($firstRow, 'creditor_master') ?? [];
                $entries = $this->buildVoucherEntries($firstRow);
                $totalAmount = collect($entries)
                    ->where('dr_cr', 'Dr')
                    ->sum('amount');

                return array_merge([
                    'id' => $firstRow->miscellanies__bill_id,
                ], $creditor, [
                    'voucher_type' => 'Purchase',
                    'voucher_date' => $firstRow->miscellanies__voucher_date,
                    'voucher_number' => $firstRow->miscellanies__voucher_number,
                    'reference_number' => $firstRow->miscellanies__reference_number,
                    'company_name' => 'ABC Pvt Ltd',
                    'narration' => $firstRow->miscellanies__narration ?? '',
                    'total_debit' => $this->formatAmount($totalAmount),
                    'total_credit' => $this->formatAmount($totalAmount),
                    'entries' => $entries,
                ]);
            })
            ->values();
    }

    protected function buildVoucherEntries(object $row): array
    {
        $entries = [];
        $billAmount = $this->numericAmount(
            $row->miscellanies__tds_bill_amount
                ?? $row->miscellanies__bill_amount
                ?? $row->miscellanies__gst_amount
                ?? $row->miscellanies__total_amount
                ?? 0
        );
        $tdsAmount = $this->numericAmount($row->miscellanies__tds_deduction_amount ?? 0);

        $this->addVoucherEntry(
            $entries,
            $row->expense_ledger_masters__ledger_name ?? $row->expense_ledger_masters__expense_ledger_name ?? null,
            $billAmount,
            'Dr'
        );

        $this->addVoucherEntry(
            $entries,
            $row->tds_duties_taxes_ledger_masters__tds_ledger_name ?? null,
            $tdsAmount,
            'Cr'
        );

        return $entries;
    }

    protected function addVoucherEntry(array &$entries, ?string $ledgerName, float $amount, string $drCr): void
    {
        if ($ledgerName === null || $ledgerName === '' || $amount <= 0) {
            return;
        }

        $entries[] = [
            'ledger_name' => $ledgerName,
            'amount' => $this->formatAmount($amount),
            'dr_cr' => $drCr,
        ];
    }

    protected function numericAmount($amount): float
    {
        return round((float) ($amount ?? 0), 2);
    }

    protected function formatAmount($amount): float
    {
        return round((float) ($amount ?? 0), 2);
    }

    protected function extractPrefixedData(object $row, string $prefix): ?array
    {
        $data = [];

        foreach ((array) $row as $key => $value) {
            $prefixToken = $prefix . '__';

            if (!str_starts_with($key, $prefixToken)) {
                continue;
            }

            $data[substr($key, strlen($prefixToken))] = $this->sanitizeApiValue($value);
        }

        if ($data === []) {
            return null;
        }

        $nonNullValues = array_filter($data, fn($value) => $value !== null);

        return $nonNullValues === [] ? null : $data;
    }

    protected function sanitizeApiValue($value)
    {
        if (!is_string($value)) {
            return $value;
        }

        return trim(preg_replace('/\s+/', ' ', $value));
    }
}
