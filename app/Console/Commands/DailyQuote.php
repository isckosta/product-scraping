<?php

    namespace App\Console\Commands;

    use App\Models\Product;
    use Illuminate\Console\Command;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Mail;

    class DailyQuote extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'quote:daily';

        /**
         * The console command description.
         *
         * @var string1
         */
        protected $description = 'Esse comando serve para truncar a tabela de produtos antes de iniciar uma nova captura de dados.';

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

            DB::table("products")->truncate();

            $this->info('Tabela truncada com sucesso!');
        }
    }
