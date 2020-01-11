<?php

use Illuminate\Database\Seeder;
use App\Participant;
use App\Result;
use Illuminate\Console\Command;

class ParticipantAndResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $output = new ConsoleOutput;
        $command = new Command;

        $csv = readCSV(__DIR__ . '/csv/training.csv');
        $counter = count(file(__DIR__ . '/csv/training.csv', FILE_SKIP_EMPTY_LINES));

        $this->command->getOutput()->progressStart($counter);

        foreach ($csv as $line) {
            $participant = Participant::create([
                'name' => $line[0]
            ]);

            $result = Result::create([
                'participant_id' => $participant->id,
                'twk' => resultDictionary($line[1]),
                'tiu' => resultDictionary($line[2]),
                'tkp' => resultDictionary($line[3]),
                'tpa' => resultDictionary($line[4]),
                'tbi' => resultDictionary($line[5]),
                'result' => testResult($line[8])
            ]);

            if ($result) {
                $this->command->getOutput()->progressAdvance();
            } else {
                $command->line('insert fail for ' . $participant->name);
            }
        }
        $this->command->getOutput()->progressFinish();
    }

    /**
     * get total row in CSV file
     * 
     * @param string $csvFile
     * 
     * @return integer rows 
     */
    protected function countCSV($csvFile)
    {
        return count(file($csvFile, FILE_SKIP_EMPTY_LINES));
    }
}
