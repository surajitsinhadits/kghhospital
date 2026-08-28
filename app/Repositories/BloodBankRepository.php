<?php

namespace App\Repositories;

use App\Models\Billing;
use App\Models\BlBloodInventory;
use App\Models\BlDonation;
use App\Models\BlDonor;
use App\Models\BlReceptant;
use App\Models\BlSectionHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BloodBankRepository
{
    function generateUniqueUhid($length = 10)
    {
        do {
            $uhid = Str::upper(Str::random($length));
        } while (BlReceptant::where('unique_id', $uhid)->exists());

        return $uhid;
    }


    public function create(array $data, $section)
    {
        $uniqueId = $this->generateUniqueUhid();
        $patient_id = Billing::where('id', $data['bill_id'])->first()->patient_id;
        $blood_inventory = BlBloodInventory::whereIn('id', $data['blood_group_receiver'])->get();
        foreach ($data['blood_group_receiver'] as $bloodGroupId) {
            $receptant = new BlReceptant();
            $receptant->unique_id = $uniqueId;
            $receptant->section_id = $patient_id;
            $receptant->section_name = 'Patient';
            $receptant->blood_inventory_id = $bloodGroupId;
            $receptant->donated_date = $data['donated_date'];
            $receptant->quantity = $blood_inventory->firstWhere('id', $bloodGroupId)->quantity;
            $receptant->save();

            $bloodInventory = BlBloodInventory::find($bloodGroupId);
            $bloodInventory->is_used = 1;
            $bloodInventory->update();
        }

        foreach ($data['name'] as $index => $name) {
            if($name == null){
                continue;
            }
            $doner_registration = new BlDonor();
            $doner_registration->name = $data['name'][$index];
            $doner_registration->blood_group = $data['blood_group'][$index];
            $doner_registration->contact_number = $data['contact_number'][$index];
            $doner_registration->address = $data['address'][$index];
            $doner_registration->last_donation_date = date('Y-m-d', strtotime($data['last_donation_date'][$index]));
            $doner_registration->save();

            $donations = new BlDonation();
            $donations->donor_id = $doner_registration->id;
            $donations->donation_date = date('Y-m-d', strtotime($data['donation_date'][$index]));
            $donations->quantity_ml = $data['quantity_ml'][$index];
            $donations->expiry_date = date('Y-m-d', strtotime($data['expiry_date'][$index]));
            $donations->tested = 'Yes';
            $donations->stock_updated = 1;
            $donations->save();

            $blood_inventory = new BlBloodInventory();
            $blood_inventory->section_id = $doner_registration->id;
            $blood_inventory->section = 'BlDonation';
            $blood_inventory->blood_group = $data['blood_group'][$index];
            $blood_inventory->quantity = $data['quantity_ml'][$index];
            $blood_inventory->donation_date = date('Y-m-d', strtotime($data['donation_date'][$index]));
            $blood_inventory->expiry_date = date('Y-m-d', strtotime($data['expiry_date'][$index]));
            $blood_inventory->added_by = Auth::id();
            $blood_inventory->save();
        }

        $section_history = new BlSectionHistory();
        $section_history->bill_id = $data['bill_id'];
        $section_history->section_id = $data['section_id'];
        $section_history->section = $section;
        $section_history->receptant_id = $uniqueId;
        $section_history->created_by = Auth::id();
        $section_history->save();

        return $uniqueId;
    }
}
