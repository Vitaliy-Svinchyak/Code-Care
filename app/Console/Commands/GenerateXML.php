<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vocabulary;
use App\Models\User;
use SoapBox\Formatter\Formatter;
use Storage;

class GenerateXML extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xml:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate xml of db';

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
     * @return mixed
     */
    public function handle()
    {
        $users = User::with([
            'hashes.word'
        ])
            ->get()
            ->toArray();

        //Deleting some values
        foreach ($users as &$user) {
            unset($user['id']);
            foreach ($user['hashes'] as &$hashedWord) {
                unset($hashedWord['id']);
                unset($hashedWord['word_id']);
                unset($hashedWord['user_id']);
                $hashedWord['word'] = $hashedWord['word']['word'];
                $similarWords = Vocabulary::where('word', 'LIKE', "%{$hashedWord['word']}%")
                    ->where('word', '!=', $hashedWord['word'])
                    ->select('word')
                    ->get()
                    ->toArray();
                if ($similarWords) {
                    $hashedWord['similar'] = $similarWords;
                }
            }
        }
        $time = date('Y-m-d_H_i_s');
        $filename = 'vocabulary_' . $time . '.xml';
        $xml = Formatter::make($users, Formatter::ARR)->toXml();
        Storage::disk('local')->put($filename, $xml);
    }
}
