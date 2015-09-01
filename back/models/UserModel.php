<?php
class UserModel extends StaticModel
{
	public static function findUserById($user_id)
	{
		$sql = 'select * from IAM_USER where userId = :user_id';
		$bind = array(
			'user_id' => $user_id
		);

		$db = self::_getDb();

		return $db->fetchOne($sql, $bind);
	}
}