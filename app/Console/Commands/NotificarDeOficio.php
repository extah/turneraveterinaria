<?php

namespace App\Console\Commands;

use App\Pieza;
use Illuminate\Console\Command;

class NotificarDeOficio extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'piezas:notificarDeOficio';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notificar piezas de oficio';

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
        $this->piezaModel = new Pieza();
        $this->piezaModel->notificarDeOficio();
    }
}
