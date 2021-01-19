<?php


namespace App\Http\Controllers\Api;


use App\Mail\ApplicationCreated;
use App\Models\Application;
use App\Http\Requests\Api\CreateApplicationRequest;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends BaseController
{
    public function store(CreateApplicationRequest $request)
    {
        $application = Application::create($request->all());
        Mail::to('toobilimapp@gmail.com')->send(new ApplicationCreated($application));
        return $this->sendResponse([], 'Заявка подана');
    }
}
