<?php

declare(strict_types=1);

namespace EON\Console\Commands;

use Illuminate\Console\Command;
use Psr\Log\LoggerInterface;

abstract class BaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(protected LoggerInterface $log)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    abstract public function handle(): int;
}
