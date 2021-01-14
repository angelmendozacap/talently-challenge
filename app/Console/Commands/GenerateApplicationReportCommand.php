<?php

namespace App\Console\Commands;

use App\Models\Phase;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateApplicationReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:applications-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates an applications report';

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
     * @return int
     */
    public function handle()
    {
        $date = Carbon::now();
        $strDate = $date->toDateString();

        $reportArray = Phase::select('id', 'name')->withCount([
            'applications as applications_count' => function ($query) use ($strDate) {
                $query->whereDate('updated_at', $strDate);
            },
        ])->get()->toArray();

        $randomStr = (string) Str::random(6);
        $path = "applications-reports/{$randomStr}_Aplicaciones_{$strDate}.csv";

        Storage::disk('public')->put($path, '');

        $file = fopen(storage_path("app/public/$path"), 'a');

        fputcsv($file, ['Phase ID', 'Phase Name', 'Applications Count']);
        foreach ($reportArray as $report) {
            fputcsv($file, $report);
        }

        fclose($file);

        $this->info('Successfully generated applications report.');
    }
}
