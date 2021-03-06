<?php
/**
 * Part of the evias/nem-php package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under MIT License.
 *
 * This source file is subject to the MIT License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    evias/nem-php
 * @version    1.0.0
 * @author     Grégory Saive <greg@evias.be>
 * @author     Robin Pedersen (https://github.com/RobertoSnap)
 * @license    MIT License
 * @copyright  (c) 2017, Grégory Saive <greg@evias.be>
 * @link       http://github.com/evias/nem-php
 */
namespace NEM\Models;

use DateTime;
use DateTimeZone;

class TimeWindow
    extends Model
{
    /**
     * List of fillable attributes
     *
     * @var array
     */
    protected $fillable = [
        "timeStamp",
    ];

    /**
     * NEM Network Genesis.
     *
     * This corresponds to the NEMesis in *UTC Timezone*.
     *
     * @var integer
     */
    static public $nemesis = 1427587585;

    /**
     * TimeWindow DTO represents NIS API's Timestamps.
     *
     * @return  integer         Seconds since NEM genesis block.
     */
    public function toDTO($filterByKey = null)
    {
        return $this->toNIS();
    }

    /**
     * Returns timestamp since NEM Nemesis block.
     *
     * The calculated NEM Time is equal to the *Count of Seconds* 
     * between the `timeStamp` attribute and the NEM Genesis Block 
     * Time.
     *
     * @return int      The NEM NIS compliant timestamp.
     */
    public function toNIS()
    {
        // NEM Time = Seconds between the `timeStamp` attribute and the NEM Genesis Block Time.
        return $this->diff($this->attributes["timeStamp"] ?: null, static::$nemesis);
    }

    /**
     * Returns timestamp in UTC format.
     *
     * @return int      The UTC format timestamp
     */
    public function toUTC() 
    {
        $ts = time();
        if ($this->attributes["timeStamp"])
            $ts = static::$nemesis + ((int) $this->attributes["timeStamp"]);

        return $ts;
    }

    /**
     * The diff() method lets you return the number of seconds difference
     * between two timestamps.
     *
     * @param   null|integer|string     $a     The (optional) lvalue (Default is "now").
     * @param   null|integer|string     $b     The (optional) rvalue (Default is the UTC time of the NEM genesis block).
     * @return  integer     Number of seconds between `a` and `b` timestamps.
     */
    public function diff($a = "now", $b = null)
    {
        $start = $a ?: "now";
        $until = $b ?: static::$nemesis;

        $startTime = is_numeric($start) ? $start : @strtotime($start);
        $endTime   = is_numeric($until) ? $until : @strtotime($until);

        $dtStart = (new DateTime("@$startTime", new DateTimeZone("UTC")))->getTimestamp();
        $dtUntil = (new DateTime("@$endTime", new DateTimeZone("UTC")))->getTimestamp();

        // never return negative timestamps
        return $dtUntil > $dtStart ? $dtUntil - $dtStart
                                   : $dtStart - $dtUntil;
    }
}