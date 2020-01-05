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

        $csv = $this->readCSV(__DIR__ . '/csv/training.csv');
        $counter = count(file(__DIR__ . '/csv/training.csv', FILE_SKIP_EMPTY_LINES));

        $this->command->getOutput()->progressStart($counter);

        foreach ($csv as $line) {
            $participant = Participant::create([
                'name' => $line[0]
            ]);

            $result = Result::create([
                'participant_id' => $participant->id,
                'twk' => $this->resultDictionary($line[1]),
                'tiu' => $this->resultDictionary($line[2]),
                'tkp' => $this->resultDictionary($line[3]),
                'tpa' => $this->resultDictionary($line[4]),
                'tbi' => $this->resultDictionary($line[5]),
                'result' => $this->testResult($line[8])
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
     * function to read CSV file
     * 
     * @param string $csvFile
     * 
     * @return array $lines
     */
    protected function readCSV($csvFile)
    {
        $fileHandle = fopen($csvFile, 'r');
        while (!feof($fileHandle) ) {
            $lines[] = fgetcsv($fileHandle, 0);
        }
        fclose($fileHandle);
        return $lines;
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

    /**
     * convert string from CSV into integer value
     * 
     * @param string $result
     * 
     * @return int
     */
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

    /**
     * convert string from test result CSV into integer value
     * 
     * @param string $result
     * 
     * @return int
     */
    protected function testResult($result)
    {
        if ($result == 'LULUS') {
            return 1;
        } else {
            return 0;
        }
    }
}
