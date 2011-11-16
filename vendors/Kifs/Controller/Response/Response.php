<?php
namespace Kifs\Controller\Response;

interface Response
{
	public function appendContent($content);

	public function send();
}
