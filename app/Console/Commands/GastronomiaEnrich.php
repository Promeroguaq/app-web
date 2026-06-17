<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GastronomiaEnrich extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gastronomia:enrich
                            {--limit=10 : Number of platos to process}
                            {--department= : Filter by department}
                            {--category= : Filter by category}
                            {--plato-id= : Process specific plato by ID}
                            {--only-pending : Only process platos with pending status}
                            {--dry-run : Show what would be done without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enrich gastronomy platos with recipe details from verified sources';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $limit = (int) $this->option('limit');
        $department = $this->option('department');
        $category = $this->option('category');
        $platoId = $this->option('plato-id');
        $onlyPending = $this->option('only-pending');
        $dryRun = $this->option('dry-run');

        $this->info('Starting gastronomy enrichment...');
        $this->info("Limit: {$limit}");
        $this->info("Department: " . ($department ?? 'All'));
        $this->info("Category: " . ($category ?? 'All'));
        $this->info("Only Pending: " . ($onlyPending ? 'Yes' : 'No'));
        $this->info("Dry Run: " . ($dryRun ? 'Yes' : 'No'));

        // Build query
        $query = DB::table('tabla_gastronomia')
            ->whereNotNull('PLATOS_TIPICOS')
            ->where('PLATOS_TIPICOS', '!=', 'PLATOS_TIPICOS');

        if ($department) {
            $query->where('DEPARTAMENTO', $department);
        }

        if ($category) {
            $query->where('CATEGORIA', $category);
        }

        if ($platoId) {
            $query->where('ID_PLATOS', $platoId);
        }

        if ($onlyPending) {
            $query->whereNotIn('ID_PLATOS', function ($q) {
                $q->select('plato_id')
                    ->from('detalle_platos')
                    ->where('estado_verificacion', '!=', 'pendiente');
            });
        }

        $platos = $query->limit($limit)->get();

        $this->info("Found {$platos->count()} platos to process");

        if ($platos->isEmpty()) {
            $this->warn('No platos found matching criteria.');
            return 0;
        }

        $progressBar = $this->output->createProgressBar($platos->count());
        $progressBar->start();

        $processed = 0;
        $skipped = 0;

        foreach ($platos as $plato) {
            $this->processPlato($plato, $dryRun) ? $processed++ : $skipped++;
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        $this->info("Processed: {$processed}");
        $this->info("Skipped: {$skipped}");

        return 0;
    }

    private function processPlato($plato, $dryRun)
    {
        $platoId = $plato->ID_PLATOS;
        $nombre = trim($plato->PLATOS_TIPICOS ?? '');
        $departamento = trim($plato->DEPARTAMENTO ?? '');
        $categoria = trim($plato->CATEGORIA ?? '');

        // Check if already has verified detail
        $existing = DB::table('detalle_platos')
            ->where('plato_id', $platoId)
            ->where('estado_verificacion', 'publicado')
            ->first();

        if ($existing) {
            $this->line("Skipping {$nombre} - already published");
            return false;
        }

        // Create pending entry if not exists
        $pending = DB::table('detalle_platos')
            ->where('plato_id', $platoId)
            ->first();

        if (!$pending && !$dryRun) {
            DB::table('detalle_platos')->insert([
                'plato_id' => $platoId,
                'estado_verificacion' => 'pendiente',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->line("Processing: {$nombre} ({$departamento}) - Status: pending");

        // Note: Actual research and data entry should be done manually
        // This command creates the infrastructure for manual enrichment
        // or could be extended with API calls to verified sources

        return true;
    }
}
