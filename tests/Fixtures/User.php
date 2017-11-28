<?php

namespace Castro732\Firebase\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Castro732\Firebase\SyncsWithFirebase;

class User extends Model
{
	use SoftDeletes;
	use SyncsWithFirebase;
}
