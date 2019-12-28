<?php

use Illuminate\Database\Seeder;
use App\Participant;
use App\Result;
use Symfony\Component\Console\Output\ConsoleOutput;

class ParticipantAndResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $output = new ConsoleOutput;

        $csv = $this->readCSV(__DIR__ . '/csv/training.csv');
        foreach ($csv as $line) {
            $participant = Participant::create([
                'name' => $line[0],
                'gender' => $line[6],
                'origin' => $line[7]
            ]);

            $result = Result::create([
                'participant_id' => $participant->id,
                'twk' => $this->resultDictionary($line[1]),
                'tiu' => $this->resultDictionary($line[2]),
                'tkp' => $this->resultDictionary($line[3]),
                'tpa' => $this->resultDictionary($line[4]),
                'tbi' => $this->resultDictionary($line[5]),
            ]);

            if ($result) {
                $output->writeln($participant->name . ' inserted');
            } else {
                $output->writeln('insert fail for ' . $participant->name);
            }
        }
    }

    protected function readCSV($csvFile)
    {
        $file_handle = fopen($csvFile, 'r');
        while (!feof($file_handle) ) {
            $line_of_text[] = fgetcsv($file_handle, 0);
        }
        fclose($file_handle);
        return $line_of_text;
    }

    protected function resultDictionary($result)
    {
        switch ($result) {
            case 'RENDAH':
                return 1;
            case 'SEDANG':
                return 2;
            case 'TINGGI':
                return 3;
            default:
                return 0;
        }
    }
}
