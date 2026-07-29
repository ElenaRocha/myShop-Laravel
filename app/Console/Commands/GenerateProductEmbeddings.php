<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Laravel\Ai\Embeddings;

class GenerateProductEmbeddings extends Command
{
    protected $signature = 'products:embed {--force : Regenerar aunque ya exista embedding}';

    protected $description = 'Genera embeddings de texto para todos los productos del catálogo';

    public function handle(): int
    {
        $products = Product::when(
            ! $this->option('force'),
            fn ($q) => $q->whereNull('embedding')
        )->get();

        if ($products->isEmpty()) {
            $this->info('Todos los productos ya tienen embedding. Usa --force para regenerar.');

            return self::SUCCESS;
        }

        $bar = $this->output->createProgressBar($products->count());
        $bar->start();

        foreach ($products as $product) {
            $text = "{$product->name}. {$product->description}";

            $vector = Embeddings::for([$text])->dimensions(1536)->generate()->first();

            $product->embedding = $vector;
            $product->save();

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Embeddings generados para {$products->count()} productos.");

        return self::SUCCESS;
    }
}
