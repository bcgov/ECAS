<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Interfaces\iModelRepository;
use App\Rules\SocialInsuranceNumberRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProfileController extends BaseController
{

    protected $model;

    public function __construct(iModelRepository $model)
    {
        $this->model            = $model;

    }



    public function index()
    {

        abort('404');

    }


    public function show($id)
    {

        // check user is requesting their own profile
        if($id <> Auth::id()) {
            abort(302, 'unauthorized');
        }

        $profile = $this->model->filter(['id'=> $id])->first();
        return new ProfileResource($profile);
    }


    /*
 * Create the Profile record (Contact in Dynamics)
 */
    public function store(Request $request)
    {
        // TODO - check that user only creates a profile with their federated_id
        $request = $this->validateProfileRequest($request);

        $user_id = $this->model->create($request->all());

        return new ProfileResource($this->show($user_id));
    }

    /*
     * Update an existing user Profile (Contact in Dynamics)
     */
    public function update($federated_id, Request $request)
    {
        // TODO - Check that the user is authorised to update their federated_id

        $request = $this->validateProfileRequest($request);
        $response = $this->model->update($federated_id, $request->all());

        return new ProfileResource($response);
    }


    public function destroy($federated_id)
    {
        abort(401);
        // unauthorized

    }


    /*
     * Create a new Assignment
     * Or change the status of an existing Assignment
     */
    private function validateProfileRequest(Request $request): Request
    {
        // Get rid of spaces
        $remove_spaces_from = ['postal_code', 'sin'];
        foreach ($remove_spaces_from as $field) {
            if (isset($request[$field])) {
                $request[$field] = preg_replace('/\s+/', '', $request[$field]);
            }
        }

        // Sanitize phone numbers, remove everything that isn't a number
        $sanitize_to_integer = ['phone'];
        foreach ($sanitize_to_integer as $field) {
            $request[$field] = preg_replace('/[^0-9.]/', '', $request[$field]);
        }

        // If we pass in blank look-up ids Dynamics freaks out
        // remove options that are blank
        $remove_blank_options = ['district_id', 'school_id'];
        foreach ($remove_blank_options as $field) {
            if ( ! $request[$field]) {
                unset($request[$field]);
            }
        }

        $this->validate($request, [
            'first_name'                    => 'required',
            'last_name'                     => 'required',
            'email'                         => 'required|email',
            'phone'                         => 'required',
            'address_1'                     => 'required',
            'city'                          => 'required',
            'region'                        => 'required',
            'postal_code'                   => 'required|regex:/^\D\d\D\s?\d\D\d$/i',
            'social_insurance_number'       => [ new SocialInsuranceNumberRule ]
        ],
            [
                'first_name.required'  => 'Required',
                'last_name.required'   => 'Required',
                'email.required'       => 'Required',
                'email.email'          => 'Invalid email',
                'phone.required'       => 'Required',
                'address_1.required'   => 'Required',
                'city.required'        => 'Required',
                'region.required'      => 'Required',
                'postal_code.required' => 'Required',
                'postal_code.regex'    => 'Invalid Postal Code',
            ]);

        return $request;
    }




}
