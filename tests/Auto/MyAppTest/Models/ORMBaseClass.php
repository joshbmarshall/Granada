<?php

namespace MyAppTest;

class ORMBaseClass extends \Granada\ExtendedModel {

    public static function currentTimezone() {
        return 'America/Chicago';
    }

    public static function siteTimezone() {
        return 'Australia/Perth';
    }
}
