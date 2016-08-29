<?php

namespace App\Http\Controllers;
use View;
use PulkitJalan\Google\Facades\Google;
use PulkitJalan\Google\Client;
use DB;
class ContactController extends Controller
{
    public  function  index(){
        return View::make('pages.contact');
    }

    public function test()
    {

        //$excel = \App::make('excel');
        $fileName = date('mdY');
        \Excel::create($fileName, function($excel) {
            $excel->sheet('test3', function($sheet) {
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
                        $dataString .= $artist->artist_full_name .'|';
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


        return  View::make('pages.contact');
    }
}
