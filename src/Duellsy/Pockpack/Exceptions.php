<?php namespace Duellsy\Pockpack;
/**
 * The Pockpack package is a quick wrap to make connecting and
 * consuming the pocket API much simpler and quicker to get up and running.
 * For information / documentation on using this package, please refer to:
 * https://github.com/duellsy/pockpack
 *
 * @package    Pockpack
 * @version    2.0.0
 * @author     Chris Duell
 * @license    MIT
 * @copyright  (c) 2013 Chris Duell
 * @link       https://github.com/duellsy/pockpack
 */

class NoConsumerKeyException extends \UnexpectedValueException {}
class NoItemException extends \UnexpectedValueException {}
class InvalidItemTypeException extends \UnexpectedValueException {}
class NoPockpackQueueException extends \UnexpectedValueException {}

