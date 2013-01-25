# PockPack docs

This package is for connecting to the [getpocket API](http://getpocket.com/developer/)

You'll need to register an app with pocket, and use the generated tokens provided in order for you to be able to connect to the API.

[![Build Status](https://travis-ci.org/duellsy/pockpack.png?branch=master)](https://travis-ci.org/duellsy/pockpack)

## Installation

Pockpack is installable via [composer](http://getcomposer.org/doc/00-intro.md), the details are on [packagist, here.](https://packagist.org/packages/duellsy/pockpack)

Add the following to the `require` section of your projects composer.json file:
```
    "duellsy/pockpack": "2.*"
```

## Authenticate

### Get request token

```
$pockpath_auth = Duellsy\Pockpack\PockpackAuth::connect();
$request_token = $pockpath_auth->connect($consumer_key);
```

### Redirect the user to pockets auth page

```
https://getpocket.com/auth/authorize?request_token=YOUR_REQUEST_TOKEN&redirect_uri=YOUR_REDIRECT_URI
```

### Get users access token

```
$pockpack = new Duellsy\Pockpack\PockpackAuth();
$access_token = $pockpack->receiveToken($consumer_key, $request_token);
```

## Get reading list

### Retreive reading list
This will return a full list of all active (unarchived) bookmarks, optionally
you can have it also return extra information such as images

```
$pockpack = new Duellsy\Pockpack\Pockpack($consumer_key, $access_token);
$list = $pockpack->retrieve($options);
```

The options array allows you to control exactly what is returned from the API.
For the full list of options, please check 'Optional Parameters' section of [the pocket retrieve API](http://getpocket.com/developer/docs/v3/retrieve) (you can also see an example JSON response on this page)

Example 1: show all favorited bookmarks, complete with images
```
$options = array(
    'state'         => 'all',
    'favorite'      => 1,
    'detailType'    => 'complete'
);
```

Example 2: show only unread bookmarks, complete with image
```
$options = array(
    'state'         => 'favorite',
    'detailType'    => 'complete'
);
```

## Modify existing bookmark

The main flow to modify a bookmark is as follows

```
$pockpack = new Duellsy\Pockpack\Pockpack($pocket_consumer_key, $pocket_access_token);
$pockpack_q = new Duellsy\Pockpack\PockpackQueue();

$pockpack_q->favorite($item_id);

$pockpack->send($pockpack_q);
```

You first need to create the pockpack connection, then add something to the
queue, and finally send the queue to pocket.

You can add as many items to the queue before sending, to send in bulk to
keep things fast.

### Archive bookmark

```
$pockpack_q->archive($item_id);
```

### Re-add bookmark

```
$pockpack_q->readd($item_id);
```

### Favorite bookmark

```
$pockpack_q->favorite($item_id);
```

### Unfavorite bookmark

```
$pockpack_q->unfavorite($item_id);
```

### Delete bookmark

```
$pockpack_q->delete($item_id);
```


## Contributing

Contributions are encouraged and welcome; to keep things organised, all bugs and requests should be
opened in the github issues tab for the main project, at [duellsy/pockpack/issues](https://github.com/duellsy/pockpack/issues)

All pull requests should be made to the develop branch, so they can be tested before being merged into the master branch.
