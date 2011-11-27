<?php
namespace Kifs\Controller\Response;

interface Response
{
	/**
	 * Add content to the body of the response
	 *
	 * @param content $content
	 */
	public function appendContent($content);

	/**
	 * Send the response to the client
	 */
	public function send();
}
