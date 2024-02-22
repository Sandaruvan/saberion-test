<?php

namespace App\Helpers;

class APIResponseMessage
{

    const ERROR_STATUS = "error";
    const SUCCESS_STATUS = "success";
    const UNAUTHORIZED = "Unauthorized. Access is denied due to invalid credentials.";
    const ROUTE_NOT_FOUND = "The route you are trying to access not exists.";
    const UPDATED = 'Successfully updated';
    const UPLOADED = 'Successfully uploaded';
    const ERROR_EXCEPTION = 'Failed the process';
    const DELETED = 'Successfully deleted';
    const CREATED = 'Successfully Saved';
    const NOT_FOUND = "Record not found.";
}
