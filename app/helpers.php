<?php

/**
 * convert string into integer value
 * 
 * @param string $result
 * 
 * @return int
 */
function resultDictionary($result)
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
 * convert string into integer value
 * 
 * @param string $result
 * 
 * @return int
 */
function testResult($result)
{
    if ($result == 'LULUS') {
        return 1;
    } else {
        return 0;
    }
}

/**
 * read csv file
 * 
 * @param string $csvFile
 */
function readCSV($csvFile)
{
    $fileHandle = fopen($csvFile, 'r');
    while (!feof($fileHandle)) {
        $lines[] = fgetcsv($fileHandle, 0);
    }
    fclose($fileHandle);

    return $lines;
}