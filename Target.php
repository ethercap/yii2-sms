<?php

namespace koenigseggposche\sms;

interface Target
{
	/**
	 * @param string $mobiles
	 * @param string $message
	 * @return bool
	 */
	public function send($mobiles, $message);
}