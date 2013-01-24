<?php namespace Duellsy\Pockpack\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * The Pockpack package is a quick wrap to make connecting and
 * consuming the pocket API much simpler and quicker to get up and running.
 * For information / documentation on using this package, please refer to:
 * https://github.com/duellsy/pockpack
 *
 * @package    Pockpack
 * @version    1.1
 * @author     Chris Duell
 * @license    MIT
 * @copyright  (c) 2013 Chris Duell
 * @link       https://github.com/duellsy/pockpack
 */

class Pockpack extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'pockpack'; }

}
