# GetPocket Package

This package is for connecting to the [getpocket API](http://getpocket.com/developer/)

You'll need to register an app with getpocket, and use the generated tokens provided in order for you to be able to connect to the API.

## Usage

### Auth

#### Get request token

```
        $request_token = Getpocket::connect($consumer_key);
```

#### Redirect the user to pockets auth page

```
        https://getpocket.com/auth/authorize?request_token=YOUR_REQUEST_TOKEN&redirect_uri=YOUR_REDIRECT_URI
```

#### Get users access token

```
        $access_token = Getpocket::receiveToken($consumer_key, $request_token);
```

### Actions

####Retreive reading list

```
    $reading_list = Getpocket::retrieve($consumer_key, $access_token);
```

## Contributing

Contributions are encouraged and welcome; to keep things organised, all bugs and requests should be
opened in the github issues tab for the main project, at [duellsy/getpocket/issues](https://github.com/duellsy/getpocket/issues)

All issues should have either [bug], [request], or [suggestion] prefixed in the title.

All pull requests should be made to the develop branch, so they can be tested before being merged into the master branch.
