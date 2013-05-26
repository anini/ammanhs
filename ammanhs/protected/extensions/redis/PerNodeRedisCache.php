<?php

class PerNodeRedisCache extends CRedisCache
{

	protected function generateUniqueKey($key)
	{
		return gethostname().'.'.parent::generateUniqueKey($key);
	}
}

