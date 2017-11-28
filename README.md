# Laravel Firebase Synchronization
## Synchronize your Eloquent models with the [Firebase Realtime Database](https://firebase.google.com/docs/database/)

![image](http://img.shields.io/packagist/v/castro732/laravel-firebase-synchronization.svg?style=flat)
![image](http://img.shields.io/packagist/l/castro732/laravel-firebase-synchronization.svg?style=flat)
<!-- [![Build Status](https://travis-ci.org/mpociot/laravel-firebase-sync.svg?branch=master)](https://travis-ci.org/mpociot/laravel-firebase-sync) -->

## Contents

- [Installation](#installation)
- [Usage](#usage)
- [Known issues](#knowni)
- [License](#license)

<a name="installation" />

## Installation

In order to add Laravel Firebase Sync to your project, just add

    "castro732/laravel-firebase-synchronization": "~2.0"

to your composer.json. Then run `composer install` or `composer update`.

Or run `composer require castro732/laravel-firebase-synchronization ` if you prefer that.


<a name="usage" />

## Usage

### Configuration

This package requires you to add the following section to your `.env` file:

```php
# Firebase
FIREBASE_API_KEY="YOUR_API_KEY"
FIREBASE_DATABASE_URL="https://domain.firebaseio.com"
FIREBASE_JSON_DIR="/your-app-firebase.json"
```

You can get the json from your Firebase Console > Settings > Firebase Admin SDK and click Generate New Private Key.


**Note**: This package only requires the configuration keys `database_url` and `secret`. The other keys are only necessary if you want to also use the firebase JS API. 

### Synchronizing models

To synchronize your Eloquent models with the Firebase realtime database, simply let the models that you want to synchronize with Firebase use the `Mpociot\Firebase\SyncsWithFirebase` trait.

```php
use Castro732\Firebase\SyncsWithFirebase;

class User extends Model {

    use SyncsWithFirebase;

}
```

The data that will be synchronized is the array representation of your model. That means that you can modify the data using the existing Eloquent model attributes like `visible`, `hidden` or `appends`.

If you need more control over the data that gets synchronized with Firebase, you can override the `getFirebaseSyncData` of the `SyncsWithFirebase` trait and let it return the array data you want to send to Firebase.

<a name="knowni" />

## Known Issues

- Tests are not working right now

<a name="license" />

## License

Laravel Firebase Sync is free software distributed under the terms of the MIT license.
Based on the work of [Marcel Pociot](https://github.com/mpociot)

