<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class EliminarSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:eliminar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'eliminar las sesiones';

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
        // $texto = "Emma Bebe";
        // Storage::append("archivo.txt", $texto);
        $directory = 'C:\xampp\htdocs\recibodesueldo\storage\framework\sessions';
        $ignoreFiles = ['.gitignore', '.', '..'];
        $files = scandir($directory);

        foreach ($files as $file) {
            if(!in_array($file,$ignoreFiles)) unlink($directory . '/' . $file);
        }
    }
}
