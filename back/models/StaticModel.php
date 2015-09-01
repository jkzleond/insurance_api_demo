<?php
class StaticModel extends SF_BaseModel
{
	protected function _getDb()
	{
		return SF_BaseDI::getCurrentDI()->get('db');
	}
}