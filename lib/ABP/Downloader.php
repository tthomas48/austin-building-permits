<?php
namespace ABP;

class Downloader
{

    private $dataDirectory;

    public function __construct($dataDirectory)
    {
        $this->dataDirectory = $dataDirectory;
    }

    public function download($startDateString)
    {
        // 02/13/2014
        $finalDate = new \DateTime();
        $startDate = \DateTime::createFromFormat("m/d/Y", $startDateString);
        $currentStart = clone $startDate;
        while ($currentStart < $finalDate) {
            $currentEnd = clone $currentStart;
            $currentEnd->modify("+7 days");
            if($currentEnd > $finalDate) {
                $currentEnd = $finalDate;
            }
            \cli\line("Pulling data from " . $currentStart->format("m/d/Y") . " to " . $currentEnd->format("m/d/Y"));
            $this->downloadFile($currentStart->format("m/d/Y"), $currentEnd->format("m/d/Y"));
            $currentStart = $currentEnd;
        }
    }

    private function downloadFile($startDate, $endDate)
    {
        $filename = $this->dataDirectory . "/" . str_replace("/", "_", $startDate) . "-" . str_replace("/", "_", $endDate) . ".html";
        if (file_exists($filename)) {
           \cli\line("Skipping existing file " . $filename);
        }
        
        $client = new \Guzzle\Http\Client();
        $request = $client->post('http://www.austintexas.gov/oss_permits/permit_report.cfm', array(), array(
            'sDate' => $startDate,
            'eDate' => $endDate,
            'Submit' => 'Submit',
        ));
        $response = $request->send();
        file_put_contents($filename, $response->getBody());
        \cli\line("Wrote to " . $filename);
    }
}