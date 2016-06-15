<?php
/**
 *
 * @package phpBB Extension - Sorting online list
 * @copyright (c) 2016 dmzx - http://www.dmzx-web.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace dmzx\sortingonlinelist\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents ()
	{
		return array(
			'core.obtain_users_online_string_sql'	=>	'obtain_users_online_string_sql',
		);
	}

	public function obtain_users_online_string_sql($event)
	{
		$sql_ary = $event['sql_ary'];
		$sql_ary['SELECT'] .= ', s.session_user_id, s.session_time';
		$sql_ary['LEFT_JOIN'][] = array(
			'FROM'	=> array(
				SESSIONS_TABLE => 's',
			),
			'ON'	=> 's.session_user_id = u.user_id',
		);
		$sql_ary['ORDER_BY'] = 's.session_time DESC';
		$event['sql_ary'] = $sql_ary;
	}
}
