<?php

namespace App\Console\Commands;

use App\Notification;
use Illuminate\Console\Command;

/**
 * Class ClearNotifications
 * This command is used to clear all notifications on the database. The optional argument can be passed
 * to handle soft deleting and permanent deletion.
 *
 * @author Jason Marchalonis
 * @since 1.0
 * @package App\Console\Commands
 */
class ClearNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:notifications {force_delete=false : Should we force delete?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Used to clear all user notifications. Optional parameter to force delete';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @since 1.0
     * @author Jason Marchalonis
     */
    public function handle()
    {
        // Get and read the arguments from the console
        $force_delete = $this->argument('force_delete');

        // Handle if we should force delete or soft delete the records for historical detail
        if ($force_delete === "true") {
            $records = Notification::query()->forceDelete();
            echo "{$records} Records Permanently Deleted \n";
        } else {
            $records = Notification::query()->delete();
            echo "{$records} Records Soft Deleted \n";
        }
    }

}
