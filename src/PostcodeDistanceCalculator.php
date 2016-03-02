<?php
/**
 * PostcodeDistanceCalculator.php
 *
 * Class to allow approximate distance calculation from a postcode outcode
 *
 * php 7+
 *
 * @category  None
 * @package   Floor9design\PostcodeDistanceCalculator
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright floor9design.com
 * @license   GPL 3.0 (http://www.gnu.org/copyleft/gpl.html)
 * @version   0.1
 * @link      http://floor9design.com/
 * @see       http://floor9design.com/
 * @since     File available since Release 1.0
 */
namespace Floor9design\PostcodeDistanceCalculator;

/**
 * Class PostcodeDistanceCalculator
 *
 * Class to allow approximate distance calculation from a postcodes
 * These are calculated using postcode outcodes, and assume a perfectly spherical earth.
 * Results are thus inaccurate, but a good indication and are useful enough for an average map search.
 *
 * Internal functions are public to allow custom/combination calculations.
 * Properties are protected to ensure proper accessor interaction.
 *
 * @category  None
 * @package   Floor9design\PostcodeDistanceCalculator
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright floor9design.com
 * @license   GPL 3.0 (http://www.gnu.org/copyleft/gpl.html)
 * @version   0.1
 * @link      http://floor9design.com/
 * @see       http://floor9design.com/
 * @since     File available since Release 1.0
 */
class PostcodeDistanceCalculator
{

    /**
     * @var array $location_data Array of location data (each is an array('key', 'lon', 'lat'). Empty unless extended.
     */
    protected $location_data = [];

    /**
     * @var bool $imperial Imperial marker. If true, distances will be given in miles.
     */
    protected $imperial;

    /**
     * @var string $first_postcode First postcode
     */
    protected $first_postcode;

    /**
     * @var string $second_postcode Second postcode
     */
    protected $second_postcode;

    /**
     * @var float $first_longitude First longitude
     */
    protected $first_longitude;

    /**
     * @var float $second_longitude Second longitude
     */
    protected $second_longitude;

    /**
     * @var float $first_latitude First latitude
     */
    protected $first_latitude;

    /**
     * @var float $second_latitude Second latitude
     */
    protected $second_latitude;

    /**
     * @var float $distance Calculated distance between items
     */
    protected $distance;

    // Accessors

    /**
     * Get the location_data
     *
     * @return array
     */
    public function getLocationData() : array
    {
        return $this->location_data;
    }

    /**
     * Set the location_data
     *
     * @param array $location_data Location data
     *
     * @return PostcodeDistanceCalculator
     */
    protected function setLocationData(array $location_data) : PostcodeDistanceCalculator
    {
        $this->location_data = $location_data;

        return $this;
    }

    /**
     * Get the imperial marker
     *
     * @return bool
     */
    public function getImperial():bool
    {
        return $this->imperial;
    }

    /**
     * Set the imperial marker
     *
     * @param bool $imperial Imperial selector
     *
     * @return PostcodeDistanceCalculator
     */
    protected function setImperial(bool $imperial):PostcodeDistanceCalculator
    {
        $this->imperial = $imperial;

        return $this;
    }

    /**
     * Get the first postcode
     *
     * @return string
     */
    public function getFirstPostcode():string
    {
        return $this->first_postcode;
    }

    /**
     * Set the first postcode
     *
     * @param string $first_postcode First postcode
     *
     * @return PostcodeDistanceCalculator
     */
    public function setFirstPostcode(string $first_postcode):PostcodeDistanceCalculator
    {
        $this->first_postcode = $this->validatePostcode($first_postcode);

        return $this;
    }

    /**
     * Get the second postcode
     *
     * @return string
     */
    public function getSecondPostcode():string
    {
        return $this->second_postcode;
    }

    /**
     * Set the second postcode
     *
     * @param string $second_postcode Second postcode
     *
     * @return PostcodeDistanceCalculator
     */
    public function setSecondPostcode(string $second_postcode):PostcodeDistanceCalculator
    {
        $this->second_postcode = $this->validatePostcode($second_postcode);

        return $this;
    }

    /**
     * Get the first longitude
     *
     * @return float
     */
    public function getFirstLongitude():float
    {
        return $this->first_longitude;
    }

    /**
     * Set the first longitude
     *
     * @param float $first_longitude First longitude
     *
     * @return PostcodeDistanceCalculator
     */
    public function setFirstLongitude(float $first_longitude):PostcodeDistanceCalculator
    {
        $this->first_longitude = $first_longitude;

        return $this;
    }

    /**
     * Get the second longitude
     *
     * @return float
     */
    public function getSecondLongitude():float
    {
        return $this->second_longitude;
    }

    /**
     * Set the second longitude
     *
     * @param float $second_longitude Second longitude
     *
     * @return PostcodeDistanceCalculator
     */
    public function setSecondLongitude(float $second_longitude):PostcodeDistanceCalculator
    {
        $this->second_longitude = $second_longitude;

        return $this;
    }

    /**
     * Get the first latitude
     *
     * @return float
     */
    public function getFirstLatitude():float
    {
        return $this->first_latitude;
    }

    /**
     * Set the first latitude
     *
     * @param float $first_latitude First latitude
     *
     * @return PostcodeDistanceCalculator
     */
    public function setFirstLatitude(float $first_latitude):PostcodeDistanceCalculator
    {
        $this->first_longitude = $first_latitude;

        return $this;
    }

    /**
     * Get the second latitude
     *
     * @return float
     */
    public function getSecondLatitude():float
    {
        return $this->second_latitude;
    }

    /**
     * Set the second latitude
     *
     * @param float $second_latitude Second latitude
     *
     * @return PostcodeDistanceCalculator
     */
    public function setSecondLatitude(float $second_latitude):PostcodeDistanceCalculator
    {
        $this->second_latitude = $second_latitude;

        return $this;
    }

    /**
     * Get the distance
     *
     * @return float
     */
    public function getDistance():float
    {
        return $this->distance;
    }

    /**
     * Set the distance
     *
     * @param float $distance Second latitude
     *
     * @return PostcodeDistanceCalculator
     */
    private function setDistance(float $distance):PostcodeDistanceCalculator
    {
        $this->distance = $distance;

        return $this;
    }

    // Constructor

    /**
     * PostcodeDistanceCalculator constructor.
     * Most likely instantiation is with postcodes, so allow easy set.
     * If they're set, automatically do the calculation on them.
     *
     * @param string $first_postcode
     * @param string $second_postcode
     * @param bool $imperial Are the measurements converted to imperial (miles)
     */
    function __construct(
        string $first_postcode = null,
        string $second_postcode = null,
        bool $imperial = true
    ) {
        $this->setFirstPostcode($first_postcode)
             ->setSecondPostcode($second_postcode)
             ->setImperial($imperial);

        // If everything is set up and called correctly, simply provide the answer straight away
        if (
            count($this->getLocationData()) &&
            $this->getFirstPostcode() &&
            $this->getSecondPostcode()
        ) {
            $this->calculatePostcodeDistance($this->getFirstPostcode(), $this->getSecondPostcode());
        }
    }

    // Main functions

    /**
     * Uses $this->$location_data to convert from postcode to lon/lat
     * This is similar to a database lookup.
     *
     * @param string $postcode
     *
     * @return array
     */
    public function convertToLonLat(string $postcode) : array
    {
        $return = ['key' => false, 'lat' => false, 'lng' => false];

        foreach ($this->location_data as $key => $postcode_details) {
            if ($postcode == $key) {
                $return = $postcode_details;
            }
        }

        return $return;
    }

    /**
     * Calculate approximate distance between two geo-locations on the surface of the planet.
     *
     * @param float $lat1 Latitude of first item
     * @param float $lon1 Longitude of first item
     * @param float $lat2 Latitude of second item
     * @param float $lon2 Longitude of second item
     *
     * @return float distance
     */
    public function calculateGeoLocationDistance(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2
    ) : float
    {
        // assumes spherical earth
        $pi80 = M_PI / 180;
        $lat1 *= $pi80;
        $lon1 *= $pi80;
        $lat2 *= $pi80;
        $lon2 *= $pi80;

        $r        = 6372.797; // mean radius of Earth in km
        $dlat     = $lat2 - $lat1;
        $dlon     = $lon2 - $lon1;
        $a        = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
        $c        = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $r * $c;

        // we work in miles in the UK:
        if ($this->imperial) {
            $distance = $distance * 0.621371;
        }

        return ceil($distance);
    }

    /**
     * Converts a postcode outcode (internally searchable).
     * For many regions this may not be needed, but if needed, can be overwritten by children.
     *
     * @param string $postcode The postcode to process
     *
     * @return string $postcode A processed postcode (outcode)
     */
    public function processPostcode(string $postcode) : string
    {
        return $postcode;
    }

    /**
     * Calculates the distance between two postcodes.
     * Returns distance, also sets result $this->distance
     *
     * @param string $first_postcode First postcode
     * @param string $second_postcode Second postcode
     *
     * @return float Distance between postcodes
     */
    public function calculatePostcodeDistance(string $first_postcode, string $second_postcode) : float
    {
        $location1 = $this->processPostcode($first_postcode);
        $location2 = $this->processPostcode($second_postcode);

        $this->setDistance(
            $this->calculateGeoLocationDistance(
                $location1['lat'],
                $location1['lng'],
                $location2['lat'],
                $location2['lng']
            )
        );

        return $this->getDistance();
    }
}