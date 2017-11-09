<?php
require './bootstrap/autoload.php';

use Pheanstalk\Pheanstalk;

$pheanstalk = new Pheanstalk('127.0.0.1');

$count      = 1000;
while($count)
{
    $job      = $pheanstalk->watch('tubeSMS')->ignore('default')->reserve();
    $job_data = json_decode($job->getData(), true);

    echo 'job: ' . print_r($job_data, true);

    $pheanstalk->delete($job);
    $count--;
}
