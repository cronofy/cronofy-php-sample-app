<?php
include("../config.php");

$calendars = $cronofy->list_calendars()["calendars"];
$calendar = $calendars[0];

$userinfo = $cronofy->get_userinfo();

if(!isset($calendar)){
  header('Location: ' . $GLOBALS['DOMAIN'] . '/profiles/');
  die;
}

$future_date = new DateTime();
$future_date->add(new DateInterval('P5D'));
$formatted_date = $future_date->format('Y-m-d');

$rts_details = [
    "oauth" => [
        "redirect_uri" => $GLOBALS['DOMAIN']. '/real-time-scheduling/success.php',
        "scope" => "write_only"
    ],
    "event" => [
        "event_id" => "test_event_id",
        "summary" => "Real time Scheduling test event",
    ],
    "availability" => [
        "participants" => [
            [
                "members" => [
                    [
                        "sub" => $userinfo["sub"],
                        "calendar_ids" => [ $calendar["calendar_id"] ]
                    ]
                ],
                "required" => "all"
            ]
        ],
        "required_duration" => [
            "minutes" => 60
        ],
        "available_periods" => [
            [
                "start" => $formatted_date . "T09:00:00Z",
                "end" => $formatted_date . "T17:00:00Z"
            ]
        ]
    ],
    "target_calendars" => [
        [
            "sub" => $userinfo["sub"],
            "calendar_id" => $calendar["calendar_id"]
        ]
    ],
    "tzid" => 'Europe/London'
];

$result = $cronofy->real_time_scheduling($rts_details);

header('Location: '. $result["url"]);
 ?>
