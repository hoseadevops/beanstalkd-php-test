<?php
require './bootstrap/autoload.php';

use Pheanstalk\Pheanstalk;

$pheanstalk = new Pheanstalk('127.0.0.1:11300');

$isAlive    = $pheanstalk->getConnection()->isServiceListening();

if(!$isAlive)
    exit('服务状态不可用');

for( $i=0; $i<1000; $i++ )
{
    $job       = new stdClass();
    $job->id   = rand();
    $job->date = date('Y-m-d H:i:s');
    $job->msg  = "短信验证码是：". rand();
    $job_data  = json_encode($job);

    $return = $pheanstalk->useTube('tubeSMS')->put($job_data);

    echo print_r($return, true);

    echo "pushed: " . $job_data . "\n";
}


