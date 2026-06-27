<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Seed Roles
        $roleAdminId = DB::table('roles')->insertGetId([
            'name' => 'Admin',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $roleModId = DB::table('roles')->insertGetId([
            'name' => 'Mod',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $roleDoctorId = DB::table('roles')->insertGetId([
            'name' => 'Doctor',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        
        $roleReceptionistId = DB::table('roles')->insertGetId([
            'name' => 'Receptionist',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 2. Seed Users
        $adminId = DB::table('users')->insertGetId([
            'role_id' => $roleAdminId,
            'name' => 'Dr. Ahmed Mahmoud (Admin)',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'is_active' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 3. Seed Kids
        $kid1Id = DB::table('kids')->insertGetId([
            'full_name' => 'ياسين أحمد محمود',
            'date_of_birth' => '2018-05-14',
            'gender' => 'Male',
            'parent_name' => 'أحمد محمود',
            'contact_phone' => '01012345678',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $kid2Id = DB::table('kids')->insertGetId([
            'full_name' => 'مريم مصطفى السيد',
            'date_of_birth' => '2021-11-02',
            'gender' => 'Female',
            'parent_name' => 'مصطفى السيد',
            'contact_phone' => '01198765432',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 4. Seed Reservations
        $reservation1Id = DB::table('reservations')->insertGetId([
            'kid_id' => $kid1Id,
            'user_id' => $adminId,
            'visit_date' => $now->copy()->subDays(2),
            'status' => 'Completed',
            'fee' => 200.00,
            'payment_status' => 'Paid',
            'notes' => 'كشف دوري',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 5. Seed Consultations
        $consultation1Id = DB::table('consultations')->insertGetId([
            'reservation_id' => $reservation1Id,
            'user_id' => $adminId,
            'diagnosis_notes' => 'الطفل يعاني من التهاب خفيف في الحلق.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 6. Seed Prescriptions
        $prescription1Id = DB::table('prescriptions')->insertGetId([
            'consultation_id' => $consultation1Id,
            'user_id' => $adminId,
            'notes' => 'الراحة التامة لمدة 3 أيام',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 7. Seed Prescription Items
        DB::table('prescription_items')->insert([
            [
                'prescription_id' => $prescription1Id,
                'medication_name' => 'Paracetamol Syrup',
                'dosage' => '5ml',
                'frequency' => 'Every 8 hours',
                'duration_days' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'prescription_id' => $prescription1Id,
                'medication_name' => 'Vitamin C Drops',
                'dosage' => '10 drops',
                'frequency' => 'Once daily',
                'duration_days' => 7,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);

        // 8. Seed Vaccines
        $vaccine1Id = DB::table('vaccines')->insertGetId([
            'name' => 'Polio (Oral)',
            'category' => 'Essential',
            'manufacturer' => 'PharmaCorp',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $vaccine2Id = DB::table('vaccines')->insertGetId([
            'name' => 'Hepatitis B',
            'category' => 'Essential',
            'manufacturer' => 'HealthInc',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 9. Seed Vaccine Records
        DB::table('vaccine_records')->insert([
            'kid_id' => $kid1Id,
            'vaccine_id' => $vaccine1Id,
            'user_id' => $adminId,
            'administered_date' => $now->copy()->subYears(2),
            'next_due_date' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
