<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Video\V1;

use Twilio\ListResource;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains preview products that are subject to change. Use them with caution. If you currently do not have developer preview access, please contact help@twilio.com.
 */
class RecordingSettingsList extends ListResource {
    /**
     * Construct the RecordingSettingsList
     *
     * @param Version $version Version that contains the resource
     * @return \Twilio\Rest\Video\V1\RecordingSettingsList
     */
    public function __construct(Version $version) {
        parent::__construct($version);

        // Path Solution
        $this->solution = array();
    }

    /**
     * Constructs a RecordingSettingsContext
     *
     * @return \Twilio\Rest\Video\V1\RecordingSettingsContext
     */
    public function getContext() {
        return new RecordingSettingsContext($this->version);
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString() {
        return '[Twilio.Video.V1.RecordingSettingsList]';
    }
}