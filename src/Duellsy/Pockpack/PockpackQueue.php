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
     * Valid actions are: favorite, unfavorite, archive, readd, delete, tags_clear
     *
     * @param  int $item_id
     * @param  string $action
     */
    public function queue($item_id = null, $action = null)
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
     * All double tag actions are routed through this method,
     * to wrap the request in the required format for the
     * pocket API.
     *
     * Valid actions are: tags_add, tags_remove, tags_replace
     *
     * @param  array $tag_info
     * @param  string $action
     */
    public function tags_queue($tag_info = array(), $action = null)
    {

        if( ! isset($tag_info['item_id']) ) {
            throw new NoItemException("No item id was sent");
        } else if ( ! is_numeric($tag_info['item_id']) ){
            throw new InvalidItemTypeException("The item id: {$tag_info['item_id']} is not valid it should be a number");
        }

        if( sizeof($tag_info['tags']) == 0 ) {
            throw new NoItemException("No tags received");
        }
        
        $base_info  = array(
            'action'        => $action,
            'time'          => time()
        );

        $tag_info = array_merge($base_info, $tag_info);

        $this->actions[] = $tag_info;

        return true;

    }



    /**
     * Add a particular bookmark
     *
     * @param  array $link_info
     */
    public function add($link_info = array())
    {

        if( ! isset($link_info['url']) ) {
            throw new NoItemException("The url is required when adding a link");
        }

        $base_info  = array(
            'action'        => 'add',
            'time'          => time()
        );

        $link_info = array_merge($base_info, $link_info);

        $this->actions[] = $link_info;

        return true;

    }


    
    /**
     * Archive a particular bookmark
     *
     * @param  int $item_id
     */
    public function archive($item_id = null)
    {
        return self::queue($item_id, 'archive');
    }



    /**
     * Re-add a bookmark that was previously archived
     *
     * @param  int $item_id
     */
    public function readd($item_id = null)
    {
        return self::queue($item_id, 'readd');
    }



    /**
     * Mark as bookmark as a favorite
     *
     * @param  int $item_id
     */
    public function favorite($item_id = null)
    {
        return self::queue($item_id, 'favorite');
    }



    /**
     * Unmark as bookmark as a favorite
     *
     * @param  int $item_id
     */
    public function unfavorite($item_id = null)
    {
        return self::queue($item_id, 'unfavorite');
    }



    /**
     * Remove a particular bookmark
     *
     * @param  int $item_id
     */
    public function delete($item_id = null)
    {
        return self::queue($item_id, 'delete');
    }



    /**
     * Add tags to a bookmark
     *
     * @param  array $tag_info
     */
    public function tags_add($tag_info = array())
    {
        return self::tags_queue($tag_info, 'tags_add');
    }


    /**
     * Remove tags from a bookmark
     *
     * @param  array $tag_info
     */
    public function tags_remove($tag_info = array())
    {
        return self::tags_queue($tag_info, 'tags_remove');
    }


    /**
     * Replace tags from a bookmark
     *
     * @param  array $tag_info
     */
    public function tags_replace($tag_info = array())
    {
        return self::tags_queue($tag_info, 'tags_replace');
    }



    /**
     * Clear all tags of a bookmark
     *
     * @param  int $item_id
     */
    public function tags_clear($item_id = null)
    {
        return self::queue($item_id, 'tags_clear');
    }



}
