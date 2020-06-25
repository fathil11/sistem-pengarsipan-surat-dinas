<?php

use App\Mail;

use App\User;
use App\MailFile;
use App\MailType;
use Carbon\Carbon;
use Faker\Factory;
use App\MailFolder;
use App\MailLog;
use App\MailVersion;
use App\MailPriority;
use App\MailReference;
use App\MailTransaction;
use Illuminate\Database\Seeder;

class MailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');

        $folders = MailFolder::all();
        $types = MailType::all(['id', 'type'])->toArray();
        $references = MailReference::all(['id', 'type'])->toArray();
        $priorities = MailPriority::all(['id', 'type'])->toArray();

        foreach ($folders as $folder) {
            $type = $faker->randomElement($types);
            $reference = $faker->randomElement($references);
            $priority = $faker->randomElement($priorities);
            $company = $faker->company();

            $mail = Mail::create([
                'kind' => 'in',
                'directory_code' => $faker->bothify('???/???/####/##/##'),
                'code' => $faker->bothify('???-###-###'),
                'title' => $type['type'] . ' ' . $company,
                'origin' => $company,
                'mail_folder_id' => $folder->id,
                'mail_type_id' => $type['id'],
                'mail_reference_id' => $reference['id'],
                'mail_priority_id' => $priority['id'],
                'mail_created_at' => Carbon::now(),
            ]);

            $mail_version = MailVersion::create([
                'mail_id' => $mail->id,
            ]);

            MailFile::create([
                'mail_version_id' => $mail_version->id,
                'original_name' => $faker->bothify('???????'),
                'directory_name' => $faker->bothify('#########'),
                'type' => $faker->randomElement(['jpg', 'doc', 'pdf', 'png'])
            ]);

            $mail_transaction = MailTransaction::create([
                'mail_version_id' => $mail_version->id,
                'user_id' => User::withPosition('Kepala TU')->first()->id,
                'target_user_id' => User::withPosition('Sekretaris')->first()->id,
                'type' => 'create'
            ]);

            MailLog::create([
                'mail_transaction_id' => $mail_transaction->id,
                'log' => 'send'
            ]);
        }

        /// Mail Out
        $positions = ['Kepala Seksie', 'Kepala Bidang', 'Sekretaris', 'Kepala Dinas', 'Admin'];
        $target_positions = ['Kepala Bidang', 'Sekretaris', 'Kepala Dinas', 'Kepala TU', 'Kepala TU'];

        foreach ($folders as $index => $folder) {
            $type = $faker->randomElement($types);
            $reference = $faker->randomElement($references);
            $priority = $faker->randomElement($priorities);
            $company = $faker->company();

            $mail = Mail::create([
                'kind' => 'out',
                'title' => $type['type'] . ' ' . $company,
                'origin' => 'Internal',
                'mail_folder_id' => $folder->id,
                'mail_type_id' => $type['id'],
                'mail_reference_id' => $reference['id'],
                'mail_priority_id' => $priority['id'],
                'mail_created_at' => Carbon::now(),
            ]);


            $mail_version = MailVersion::create([
                'mail_id' => $mail->id,
            ]);

            MailFile::create([
                'mail_version_id' => $mail_version->id,
                'original_name' => $faker->bothify('???????'),
                'directory_name' => $faker->bothify('#########'),
                'type' => $faker->randomElement(['jpg', 'doc', 'pdf', 'png'])
            ]);

            $mail_transaction = MailTransaction::create([
                'mail_version_id' => $mail_version->id,
                'user_id' => User::withPosition($positions[$index])->first()->id,
                'target_user_id' => User::withPosition($target_positions[$index])->first()->id,
                'type' => 'create'
            ]);

            MailLog::create([
                'mail_transaction_id' => $mail_transaction->id,
                'log' => 'send'
            ]);

            $mail_transaction = MailTransaction::create([
                'mail_version_id' => $mail_version->id,
                'user_id' => User::withPosition($target_positions[$index])->first()->id,
                'target_user_id' => User::withPosition($positions[$index])->first()->id,
                'type' => 'correction'
            ]);

            MailLog::create([
                'mail_transaction_id' => $mail_transaction->id,
                'log' => 'send'
            ]);
        }
    }
}
