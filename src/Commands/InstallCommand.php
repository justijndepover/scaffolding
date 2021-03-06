<?php

namespace Justijndepover\Beam\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'beam:install';

    protected $description = 'Run the Laravel Beam installer';

    private $commands;

    public function __construct()
    {
        parent::__construct();
        $this->commands = collect();
    }

    public function handle()
    {
        if ($this->confirm('Do you want to setup file structure?', true)) {
            $this->executeLater(FileStructureCommand::class);
        }

        if ($this->confirm('Do you want to install custom stub files?', true)) {
            $this->executeLater(StubsCommand::class);
        }

        if ($this->confirm('Do you want to install laravel-inbox?', true)) {
            $this->executeLater(LaravelInboxCommand::class);
        }

        if ($this->confirm('Do you want to install laravel-cookie-consent?', true)) {
            //
        }

        if ($this->choice('What css framework do you want to install?', ['Tailwindcss', 'Bootstrap', 'None'], 0)) {
            //
        }

        $this->info('Installing the assets');
        $this->executeCommands();
        $this->info('Done!');
    }

    private function executeLater($command)
    {
        $this->commands->push($command);
    }

    private function executeCommands()
    {
        foreach ($this->commands as $command) {
            $this->callSilent($command);
        }
    }
}
