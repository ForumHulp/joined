<?php
/**
*
* Joined Date.
*
* @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace forumhulp\joined\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.viewtopic_cache_user_data'		=> 'add_page_header_link',
			'core.memberlist_prepare_profile_data'	=> 'modify_memberlist'
		);
	}

	/** @var \phpbb\user */
	protected $user;

	public function __construct(\phpbb\user $user)
	{
		$this->user = $user;
	}

	public function add_page_header_link($event)
	{
		$poster_data = $event['row'];
		$date_format = str_replace(array(',', 'H', ':', 'i', 'g', 'a'), '', $this->user->data['user_dateformat']);
		// get element
		$joined = $this->user->format_date($poster_data['user_regdate'], $date_format);
		$b = $event['user_cache_data'];
		$b['joined'] = $joined;
		// store the element again
		$event['user_cache_data'] = $b;
	}

	public function modify_memberlist($event)
	{
		$poster_data = $event['data'];
		$date_format = str_replace(array(',', 'H', ':', 'i', 'g', 'a'), '', $this->user->data['user_dateformat']);
		// get element
		$joined = $this->user->format_date($poster_data['user_regdate'], $date_format);
		$b = $event['template_data'];
		$b['JOINED'] = $joined;
		// store the element again
		$event['template_data'] = $b;
	}
}
