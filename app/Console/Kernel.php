<?php

namespace App\Console;

use DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use PulkitJalan\Google\Facades\Google;
use PulkitJalan\Google\Client;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
         Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->call(function () {
            $events =  DB::select("call SP_SELECT_EVENT_EXPORT()");
            if(count($events) <= 0) return false;
            //$excel = \App::make('excel');
            $fileName = date('mdY');
            \Excel::create($fileName, function($excel) {
                $sheetName = date('mdY');
                $excel->sheet($sheetName, function($sheet) {
                    $events =  DB::select("call SP_SELECT_EVENT_EXPORT()");
                    $eventData = [];
                    foreach ($events as $event){
                        $eventDataColumn = array($event->event_name, $event->event_date, $event->event_time, $event->customer_name, $event->customer_phone, $event->customer_email, $event->event_more_information);
                        $eventId = $event->event_id;
                        $artists =  DB::select("call SP_GET_ARTIST_EVENT(?)", array($eventId));
                        $index = 0;

                        foreach ($artists as $artist){
                            $dataString = '';
                            if($index == 0){
                                $index++;
                            }else{
                                $eventDataColumn = array('', '', '','','', '', '');
                            }
                            $dataString .= $artist->artist_full_name .'|4';
                            $dataString .= $artist->artist_dob."|";
                            $dataString .= $artist->artist_type_name;
                            array_push($eventDataColumn, $dataString);
                            array_push($eventData, $eventDataColumn);
                        }
                    }
                    $sheet->fromArray($eventData);
                });
            })->store('csv', storage_path('exports'));
            $googleClient = Google::getClient();
            $googleClient->setScopes(\Google_Service_Drive::DRIVE);
            // $client = new Client($googleClient->getConfig());
            $storageService = new \Google_Service_Drive($googleClient);

            $fileResult = $storageService->files->listFiles(array(
                'q' => "name='".$fileName."'",
                'fields' => 'nextPageToken, files(id, name)',
            ));

            if(count($fileResult->files) > 0){
                $file = $fileResult->files[0];
                $fileId = $file->id;
                $storageService->files->delete($fileId);
            }
            $fileMetadata = new \Google_Service_Drive_DriveFile(array(
                'name' => $fileName,
                'mimeType' => 'application/vnd.google-apps.spreadsheet'));
            $content = file_get_contents(storage_path('exports').'/'.$fileName.'.csv');
            $file = $storageService->files->create($fileMetadata, array(
                'data' => $content,
                'mimeType' => 'text/csv',
                'uploadType' => 'multipart',
                'fields' => 'id'));
            $googleClient->setUseBatch(true);
            try {
                $batch = $storageService->createBatch();

                $userPermission = new \Google_Service_Drive_Permission(array(
                    'type' => 'user',
                    'role' => 'reader',
                    'emailAddress' => env('EMAIL_SHARING_NAME','nerorain1102@gmail.com')
                ));
                $request = $storageService->permissions->create(
                    $file->id, $userPermission, array('fields' => 'id'));
                $batch->add($request, 'user');


                $results = $batch->execute();

                foreach ($results as $result) {
                    if ($result instanceof \Google_Service_Exception) {
                        \Log::info("Permission ID: ".$result);
                    } else {
                        \Log::info("Permission ID: ".$result->id);

                    }
                }
            } finally {
                $googleClient->setUseBatch(false);
            }


            foreach ($events as $event){
                DB::beginTransaction();
                try {
                    $eventId = $event->event_id;
                    DB::statement("call SP_UPDATE_STATUS_EVENT(?)", array($eventId));

                    DB::commit();

                } catch (\Exception $e) {
                    DB::rollback();

                }
            }

        })->everyTenMinutes();
    }
}
