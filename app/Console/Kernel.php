<?php

namespace App\Console;

use DB;
use Log;
use Excel;
use Google_Service_Drive_Permission;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use PulkitJalan\Google\Facades\Google;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Events\Dispatcher;

class Kernel extends ConsoleKernel
{
    /**
     * OVERRIDING PARENT CLASS
     * The bootstrap classes for the application.
     *
     * @var array
     */
    protected $bootstrappers = [
        'Illuminate\Foundation\Bootstrap\DetectEnvironment',
        'Illuminate\Foundation\Bootstrap\LoadConfiguration',
        'Illuminate\Foundation\Bootstrap\HandleExceptions',
        'Illuminate\Foundation\Bootstrap\RegisterFacades',
        'Illuminate\Foundation\Bootstrap\SetRequestForConsole',
        'Illuminate\Foundation\Bootstrap\RegisterProviders',
        'Illuminate\Foundation\Bootstrap\BootProviders',
        'Bootstrap\ConfigureConsoleLogging'
    ];

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
            Log::info('************** EXPORT CSV GOOGLE DRIVE FILE ******************** ');
            $events =  DB::select("call SP_SELECT_EVENT_EXPORT()");
            Log::info('[ EVENTS COUNT :'.count($events).' ]');
            if(count($events) <= 0) return false;

            $fileName = date('mdY');
            Log::info('[ EXPORT FILE START '.$fileName.']');
            Log::info('[ EXPORT FILE DONT HAVE '.$fileName.']');
            Excel::create($fileName, function ($excel) {
                $sheetName = date('mdY');
                $excel->sheet($sheetName, function ($sheet) {
                    $events = DB::select("call S_SELECT_EVENT_EXPORT_ALL_DAY()");
                    $eventData = [];
                    foreach ($events as $event) {
                        $eventDataColumn = array($event->event_name, $event->event_date, $event->event_time, $event->customer_name, $event->customer_phone, $event->customer_email, $event->event_more_information);
                        $eventId = $event->event_id;
                        $artists = DB::select("call SP_GET_ARTIST_EVENT(?)", array($eventId));
                        $index = 0;

                        foreach ($artists as $artist) {
                            $dataString = '';
                            if ($index == 0) {
                                $index++;
                            } else {
                                $eventDataColumn = array('', '', '', '', '', '', '');
                            }
                            $dataString .= $artist->artist_full_name . '|';
                            $dataString .= $artist->artist_dob . "|";
                            $dataString .= $artist->artist_type_name;
                            array_push($eventDataColumn, $dataString);
                            array_push($eventData, $eventDataColumn);
                        }
                    }
                    $sheet->fromArray($eventData);
                });
            })->store('csv', storage_path('exports'));

            Log::info('[ EXPORT FILE '.$fileName.' END ]');
            Log::info('[ QUERY FILE  GOOGLE DRIVE ]');
            $googleClient = Google::getClient();
            $googleClient->setScopes(Google_Service_Drive::DRIVE);
            // $client = new Client($googleClient->getConfig());
            $storageService = new Google_Service_Drive($googleClient);

            $fileResult = $storageService->files->listFiles(array(
                'q' => "name='".$fileName."'",
                'fields' => 'nextPageToken, files(id, name)',
            ));
            Log::info('[ QUERY FILE  GOOGLE DRIVE COUNT : '.count($fileResult->files).']');
            $fileId = -1;
            if(count($fileResult->files) > 0){
                $file = $fileResult->files[0];
                $fileId = $file->id;
                $fileMetadata = new Google_Service_Drive_DriveFile(array(
                    'name' => $fileName,
                    'mimeType' => 'application/vnd.google-apps.spreadsheet'));
                $content = file_get_contents(storage_path('exports') . '/' . $fileName . '.csv');
                $file = $storageService->files->update($fileId, $fileMetadata, array(
                    'data' => $content,
                    'mimeType' => 'text/csv',
                    'uploadType' => 'multipart',
                    'fields' => 'id'));
                $fileId = $file->id;
            }else {
                $fileMetadata = new Google_Service_Drive_DriveFile(array(
                    'name' => $fileName,
                    'mimeType' => 'application/vnd.google-apps.spreadsheet'));
                $content = file_get_contents(storage_path('exports') . '/' . $fileName . '.csv');
                $file = $storageService->files->create($fileMetadata, array(
                    'data' => $content,
                    'mimeType' => 'text/csv',
                    'uploadType' => 'multipart',
                    'fields' => 'id'));
                $fileId = $file->id;
            }
            Log::info('[ SHARE PERMISSION GOOGLE DRIVE TO EMAIL ('.env('EMAIL_SHARING_NAME','nerorain1102@gmail.com').')]');
            $googleClient->setUseBatch(true);
            try {
                $batch = $storageService->createBatch();

                $userPermission = new Google_Service_Drive_Permission(array(
                    'type' => 'user',
                    'role' => 'reader',
                    'emailAddress' => env('EMAIL_SHARING_NAME','nerorain1102@gmail.com')
                ));
                $request = $storageService->permissions->create(
                    $fileId, $userPermission, array('fields' => 'id'));
                $batch->add($request, 'user');


                $results = $batch->execute();

                foreach ($results as $result) {
                    if ($result instanceof \Google_Service_Exception) {
                        Log::error('[ SHARE PERMISSION ERROR ]');
                        Log::error("ERROR : ".$result);
                        Log::error('[ SHARE PERMISSION ERROR ]');
                    } else {
                        Log::info('[ SHARE PERMISSION SUCCESS ]');
                        Log::info("Permission ID: ".$result->id);
                        Log::info('[ SHARE PERMISSION SUCCESS ]');

                    }
                }
                \Log::info('[ UPDATE STATUS EVENT TO SHARED ]');
                foreach ($events as $event){
                    DB::beginTransaction();
                    try {
                        $eventId = $event->event_id;
                        DB::statement("call SP_UPDATE_STATUS_EVENT(?)", array($eventId));

                        DB::commit();

                    } catch (\Exception $e) {
                        Log::error('[ UPDATE STATUS EVENT TO SHARED ERROR ]');
                        Log::error($e);
                        Log::error('[ UPDATE STATUS EVENT TO SHARED ERROR ]');
                        DB::rollback();
                    }
                }
                Log::info('[ UPDATE STATUS EVENT TO SHARED ]');
            }catch(\Exception $e) {
                Log::error('[ ERROR ]');
                Log::error($e);
                Log::error('[ ERROR ]');
            } finally {
                $googleClient->setUseBatch(false);

            }

            Log::info('************** END CSV GOOGLE DRIVE FILE ******************** ');


        })->everyMinute();
    }
}
