<?php

namespace EON\Console\Commands;

use EON\XML\Actions\XMLParseAction;
use Illuminate\Console\Command;

class XMLParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xml:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for parsing test xml file and get apartment data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(XMLParseAction $action)
    {
        $action->handle('storage/tmp/test.xml');
    }
}
