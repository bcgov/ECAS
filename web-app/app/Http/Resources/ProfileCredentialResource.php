<?php

namespace App\Http\Resources;

use App\Dynamics\Decorators\CacheDecorator;
use App\Dynamics\Interfaces\iCredential;
use App\Dynamics\ProfileCredential;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class ProfileCredentialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {


        // Dynamics reports credentials as one of: "Yes", "No" or "Unverified"
        // This application transforms the verification field into a Boolean

        return [
            'id'            => $this['id'],
            'contact_id'    => $this['contact_id'],
            'credential'    => new SimpleResource($this['credential']),
            'year'          => $this['year'],
            'verified'      => $this['verified'] == ProfileCredential::$status['Yes'] ? TRUE : FALSE,
        ];
    }
}
