<?php

namespace DTApi\Http\Controllers;

use App\enum\roleEnum;
use App\Http\Requests\BookingControllerIndexRequest;
use DTApi\Models\Job;
use DTApi\Http\Requests;
use DTApi\Models\Distance;
use Exception;
use Illuminate\Http\Request;
use DTApi\Repository\BookingRepository;
use App\trait\jsonResponse;

/**
 * Class BookingController
 * @package DTApi\Http\Controllers
 */
class BookingController extends Controller
{
    use jsonResponse;

    /**
     * @var BookingRepository
     */
    protected $repository;

    /**
     * BookingController constructor.
     * @param BookingRepository $bookingRepository
     */
    public function __construct(BookingRepository $bookingRepository)
    {
        $this->repository = $bookingRepository;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(BookingControllerIndexRequest $request)
    {
            try{
                $response=NULL;
                $request->whenHas($request->user_id, function ($query) use (&$response,$request) {
                $response=$this->repository->getUsersJobs($request->user_id);
                });
                $response= $response?: ( $request()->user()->user_type==(roleEnum::ADMIN_ROLE_ID,roleEnum::SUPERADMIN_ROLE_ID) ? $this->repository->getAll($request) : NULL);
                return $response ?  self::success($data) : error($data);
    }catch(Exception $exception){
        return self::exception($exception);
    };
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show(Booking $booking)
    {
        // so that model binding could whether specific id exists or not 
        try{
        $job = $this->repository->with('translatorJobRel.user')->find($id);
        return $response ?  self::success($job) : error($job);
        }catch(Exception $exception){
            return self::exception($exception);
        };
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(BookingStoreRequest $request) : jsonResponse
    {
        try{
       return  $response = $this->repository->store($request->user(), $request->validated()) ? self::success($data) : self::error($response);
    }catch(Exception $exception){
        return self::exception($exception);
    };
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function update(Booking $booking, Request $request)
    {
        try{
            return  $response = $this->repository->updateJob($booking->id, $request->safe()->except(['_token', 'submit']), auth()->user()) ? self::success($reponse) :self::error($response)  ;
     } catch(Exception $exception){
            return self::exception($exception);
        };
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function immediateJobEmail(BookingimmediateJobEmailRequest $request)
    {
        try{
        // $adminSenderEmail = config('app.adminemail');   as not being used 
      return   $response = $this->repository->storeJobEmail($request()->safe()->all()) ? self::success($data) : self::error($data);
    } catch(Exception $exception){
        return self::exception($exception);
    };
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getHistory(Request $request)
    {
        try{
             $response=$request->whenHas($request->user_id,function($query) use ($request){
               return  $this->repository->getUsersJobsHistory($user_id, $request);
             });
             return $response ? self::success($response) : self::error([]);
        }catch(Exception $exception){
        return self::exception($exception);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */

     /* we could make a high order function  for following functions that uses same parameter but different functions in repo and one function here as well like*/
     
    public function handleJob(BookinghanldeJobRequest $request):jsonResponse{
        try{
            return  $reponse=$this->repository->hanldejob($request->safe()->all(), auth()->user(),$request->functionName) ? self::success($response) :  self::error($response);
       }catch(Exception $exception){
           return self::exception($exception);
           }
    }
     /* we could make a high order function in repo and one function here as well like*/



    public function acceptJob(BookingacceptJobRequest $request)
    {
        try{
         return  $reponse=$this->repository->acceptJob($request->safe()->all(), auth()->user()) ? self::success($response) :  self::error($response);
    }catch(Exception $exception){
        return self::exception($exception);
        }
    }

    public function acceptJobWithId(BookingacceptJobWithIdRequest $request)
    {
        try{
        return  $reponse=$this->repository->acceptJobWithId($request->safe()->all(), auth()->user()) ? self::success($response) :  self::error($response);
    }catch(Exception $exception){
        return self::exception($exception);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function cancelJob(BookingcancelJobRequest $request)
    {

        try{
            return  $reponse=$this->repository->cancelJobAjax($request->safe()->all(), auth()->user()) ? self::success($response) :  self::error($response);
        }catch(Exception $exception){
            return self::exception($exception);
            }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function endJob(BookingendJobRequest $request)
    {
        try{
            return  $reponse=$this->repository->endJob($request->safe()->all()) ? self::success($response) :  self::error($response);
        }catch(Exception $exception){
            return self::exception($exception);
            }
    }

    public function customerNotCall(BookingcustomerNotCallRequest $request)
    {
        try{
            return  $reponse=$this->repository->customerNotCall($request->safe()->all()) ? self::success($response) :  self::error($response);
        }catch(Exception $exception){
            return self::exception($exception);
        }

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getPotentialJobs(BookinggetPotentialJobsRequest $request)
    {

        try{
            return  $reponse=$this->repository->getPotentialJobs($request->safe()->all(), auth()->user()) ? self::success($response) :  self::error($response);
        }catch(Exception $exception){
            return self::exception($exception);
            }
    }

    public function distanceFeed(BookingdistanceFeedRequest $request)
    {

        try{
            //we will do all these validations in request
        // $data = $request->all();

        // if (isset($data['distance']) && $data['distance'] != "") {
        //     $distance = $data['distance'];
        // } else {
        //     $distance = "";
        // }
        // if (isset($data['time']) && $data['time'] != "") {
        //     $time = $data['time'];
        // } else {
        //     $time = "";
        // }
        // if (isset($data['jobid']) && $data['jobid'] != "") {
        //     $jobid = $data['jobid'];
        // }

        // if (isset($data['session_time']) && $data['session_time'] != "") {
        //     $session = $data['session_time'];
        // } else {
        //     $session = "";
        // }

        // if ($data['flagged'] == 'true') {
        //     if($data['admincomment'] == '') return "Please, add comment";
        //     $flagged = 'yes';
        // } else {
        //     $flagged = 'no';
        // }
        
        // if ($data['manually_handled'] == 'true') {
        //     $manually_handled = 'yes';
        // } else {
        //     $manually_handled = 'no';
        // }

        // if ($data['by_admin'] == 'true') {
        //     $by_admin = 'yes';
        // } else {
        //     $by_admin = 'no';
        // }

        // if (isset($data['admincomment']) && $data['admincomment'] != "") {
        //     $admincomment = $data['admincomment'];
        // } else {
        //     $admincomment = "";
        // }
        $request->hasany([$request->time,$request->distance],function() use ($request){
            $result=DB::transaction(function ()  use ($request){
              return  Distance::where('job_id', '=', $request->jobid)->update( $request->safe()->only(['distance','time']));
            });
        });


        $request->hasany([$request->admincomment,$request->session,$request->flagged,$request->manually_handled,$request->by_admin],function() use ($request){
            $result=DB::transaction(function ()  use ($request){
            return   $affectedRows1 = Job::where('id', '=', $jobid)->update($request->safe()->only(['admin_comments', 'flagged' , 'session_time', 'manually_handled', 'by_admin' ]));
            });
        });

        return self::success([],"no content");

    }catch(Exception $exception){
        return self::exception($exception);
        }
    }

    public function reopen(BookingreopenRequest $request)
    {
        try{
            return  $reponse=$this->repository->reopen($request->safe()->all()) ? self::success($response) :  self::error($response);
        }catch(Exception $exception){
            return self::exception($exception);
        }
    }

    /*same we could write one function  for below two functions */

    public function resendNotifications(BookingresendNotificationsRequest $request)
    {
        try{
        $job = $this->repository->find($request->safe()->only('id'));
        $job_data = $this->repository->jobToData($job);
      return $this->repository->sendNotificationTranslator($job, $job_data, '*')==true ? self::success(['success' => 'Push sent']) : self::error() ;
    }catch(Exception $exception){
        return self::exception($exception);
    }
    }

    /**
     * Sends SMS to Translator
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function resendSMSNotifications(BookingresendSMSNotificationsRequest $request)
    {
        try{
        $job = $this->repository->find($request->safe()->only('id'));
        $job_data = $this->repository->jobToData($job);
      return $this->repository->sendSMSNotificationToTranslator($job)==true ? self::success(['success' => 'SMS sent']) : self::error() ;
        }
        catch(Exception $exception){
            return self::exception($exception);
        }
    }

}
