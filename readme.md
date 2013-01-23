# GetPocket Package

This package is for connecting to the [getpocket API](http://getpocket.com/developer/)

You'll need to register an app with getpocket, and use the generated tokens provided in order for you to be able to connect to the API.

## Auth

### Get request token

```
$request_token = Getpocket::connect($consumer_key);
```

### Redirect the user to pockets auth page

```
https://getpocket.com/auth/authorize?request_token=YOUR_REQUEST_TOKEN&redirect_uri=YOUR_REDIRECT_URI
```

### Get users access token

```
$access_token = Getpocket::receiveToken($consumer_key, $request_token);
```

## Actions

### Retreive reading list
This will return a full list of all active (unarchived) bookmarks, optionally
you can have it also return extra information such as images

```
$reading_list = Getpocket::retrieve($consumer_key, $access_token, [$options = array()]);
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

### Archive bookmark

```
Getpocket::archive($consumer_key, $access_token, $item_id);
```

### Unarchive bookmark

```
Getpocket::unarchive($consumer_key, $access_token, $item_id);
```


### Re-add bookmark

```
Getpocket::readd($consumer_key, $access_token, $item_id);
```

### Favorite bookmark

```
Getpocket::favorite($consumer_key, $access_token, $item_id);
```

### Unfavorite bookmark

```
Getpocket::unfavorite($consumer_key, $access_token, $item_id);
```



## Contributing

Contributions are encouraged and welcome; to keep things organised, all bugs and requests should be
opened in the github issues tab for the main project, at [duellsy/getpocket/issues](https://github.com/duellsy/getpocket/issues)

All issues should have either [bug], [request], or [suggestion] prefixed in the title.

All pull requests should be made to the develop branch, so they can be tested before being merged into the master branch.
