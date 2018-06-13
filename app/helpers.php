<?php

/* 
 * Helper functions for CatiSup
 */


/**
 * Connect to the Limesurvey API
 * 
 * @return array containing the JSONRPC connection and the session key
 */
function connectAPI()
{
    $myJSONRPCClient = new \org\jsonrpcphp\JsonRPCClient( env('LIME_URL').'/admin/remotecontrol' );
    $sessionKey= $myJSONRPCClient->get_session_key( env('LIME_USER'), env('LIME_PASSWORD') );
    return array('connection' => $myJSONRPCClient, 'sessionKey' => $sessionKey);
}


/**
 * Disconnect from the Limesurvey API
 * 
 * @param array containing the JSONRPC connection and the session key
 * 
 * @return string OK
 */
function disconnectAPI($api)
{
    return $api['connection']->release_session_key($api['sessionKey']);
}


