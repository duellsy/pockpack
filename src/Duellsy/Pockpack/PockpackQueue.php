<?php namespace Duellsy\Pockpack;

use Duellsy\Pockpack\NoItemException;
use Duellsy\Pockpack\InvalidItemTypeException;

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
class PockpackQueue
{

    private $actions = array();

    /**
     * Grab the list of actions created so far
     * @return array
     */
    public function getActions()
    {

        return $this->actions;

    }

    /**
     * Clear the actions array
     * This is typically used after the send API call has been made
     * @return boolean
     */
    public function clear()
    {

        $this->actions = array();
        return sizeof($this->actions) == 0;

    }


    /**
     * All single actions are routed through this method,
     * to wrap the request in the required format for the
     * pocket API.
     *
     * Valid actions are: favorite, unfavorite, archive, readd, delete
     *
     * @param  int $item_id
     * @param  string $action
     */
    public function add($item_id = null, $action = null)
    {

        if( is_null($item_id) ) {
            throw new NoItemException("No item id was sent");
        } else if ( ! is_numeric($item_id) ){
            throw new InvalidItemTypeException("The item id: $item_id is not valid it should be a number");
        }

        $this->actions[] =
            array(
                'action'        => $action,
                'item_id'       => $item_id,
                'time'          => time()
            );

        return true;

    }



    /**
     * Archive a particular bookmark
     *
     * @param  int $item_id
     */
    public function archive($item_id = null)
    {
        return self::add($item_id, 'archive');
    }



    /**
     * Re-add a bookmark that was previously archived
     *
     * @param  int $item_id
     */
    public function readd($item_id = null)
    {
        return self::add($item_id, 'readd');
    }



    /**
     * Mark as bookmark as a favorite
     *
     * @param  int $item_id
     */
    public function favorite($item_id = null)
    {
        return self::add($item_id, 'favorite');
    }



    /**
     * Unmark as bookmark as a favorite
     *
     * @param  int $item_id
     */
    public function unfavorite($item_id = null)
    {
        return self::add($item_id, 'unfavorite');
    }



    /**
     * Remove a particular bookmark
     *
     * @param  int $item_id
     */
    public function delete($item_id = null)
    {
        return self::add($item_id, 'delete');
    }



}
