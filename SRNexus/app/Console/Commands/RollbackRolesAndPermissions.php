<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\RolesAndPermissionsSeeder;

class RollbackRolesAndPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seeders:rollback-roles-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback roles and permissions seeded by RolesAndPermissionsSeeder';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $seeder = new RolesAndPermissionsSeeder();
        $seeder->rollback();

        $this->info('Roles and permissions have been rolled back successfully.');

        return 0;
    }
}
