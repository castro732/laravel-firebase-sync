<?php

namespace Castro732\Firebase;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

/**
 * Class SyncsWithFirebase
 */
trait SyncsWithFirebase
{

    /**
     * @var FirebaseInterface|null
     */
    protected $firebaseClient;

    /**
     * Boot the trait and add the model events to synchronize with firebase.
     */
    public static function bootSyncsWithFirebase()
    {
        static::created(function ($model) {
            $model->saveToFirebase('set');
        });
        static::updated(function ($model) {
            $model->saveToFirebase('update');
        });
        static::deleted(function ($model) {
            $model->saveToFirebase('delete');
        });
        if (trait_exists('SoftDeletes')) {
	        static::restored(function ($model) {
	            $model->saveToFirebase('set');
	        });
        }
    }

    /**
     * @param FirebaseInterface|null $firebaseClient
     */
    public function setFirebaseClient()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(config('services.firebase.json_dir'));
        $apiKey = config('services.firebase.api_key');
        $firebaseClient = (new Factory)
                    ->withServiceAccount($serviceAccount)
                    ->withDatabaseUri(config('services.firebase.database_url'))
                    ->create();
        $this->firebaseClient = $firebaseClient;
    }

    /**
     * @return array
     */
    protected function getFirebaseSyncData()
    {
        if ($fresh = $this->fresh()) {
            return $fresh->toArray();
        }
        return [];
    }

    /**
     * @param $mode
     */
    protected function saveToFirebase($mode)
    {
        if (is_null($this->firebaseClient)) {
            $this->setFirebaseClient();
        }

        $path = $this->getTable() . '/' . $this->getKey();

        if ($mode === 'set' && $fresh = $this->fresh()) {
            $this->firebaseClient->getDatabase()->getReference($path)->set($fresh->toArray());
        } elseif ($mode === 'update' && $fresh = $this->fresh()) {
            $this->firebaseClient->getDatabase()->getReference($path)->update($fresh->toArray());
        } elseif ($mode === 'delete') {
            $this->firebaseClient->delete($path);
        }
    }
}
