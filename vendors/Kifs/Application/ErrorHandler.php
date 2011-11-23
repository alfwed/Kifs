<?php
namespace Kifs\Application;

class ErrorHandler
{
	private $_errorStack = array();

	private $_hasFatalError = false;


	private $_showErrors = false;

	private $_mailErrors = false;

	private $_templateInternalError;

	private $_templateErrorFront;

	private $_templateErrorMail;

	private $_mailErrorsTo = array();


	public function __construct($config)
	{
		$this->_loadConf($config);
	}

	public function start()
	{
		set_error_handler(array($this, 'errorHdlr'));
		set_exception_handler(array($this, 'exceptionHdlr'));
		register_shutdown_function(array($this, 'shutdownCallback'));
	}

	private function _loadConf($config)
	{
		if (empty($config) || !is_array($config))
			throw new \UnexpectedValueException('Config array for ErrorHandler class was empty or invalid');

		foreach ($config as $var => $value) {
			$property = '_'.$var;
			$this->$property = $value;
		}
	}

	public function errorHdlr($errorType, $msg, $file, $line)
	{
		$backtraces = array_reverse(debug_backtrace());
		array_pop($backtraces);

	    $this->_errorStack[] = array(
	    	'type' => $errorType,
	    	'message'	=> $msg,
	    	'file'	=> $file,
	    	'line'	=> $line,
	    	'backtraces' => $backtraces
	    );

	    // Don't execute PHP internal error handler
	    return true;
	}

	/**
	 * @param \Exception $e
	 */
	public function exceptionHdlr($e)
	{
		$this->errorHdlr(E_ERROR, $e->getMessage(), $e->getFile(), $e->getLine());
	}

	public function shutdownCallback()
	{
		$error = error_get_last();

		if (null === $error)
			return;

		if (in_array($error['type'], array(E_ERROR, E_USER_ERROR)))
		{
			$this->errorHdlr($error['type'], $error['message'], $error['file'], $error['line']);
			$this->_hasFatalError = true;
			require $this->_templateInternalError;
		}

		$this->_displayOrSendErrors();
	}

	private function _displayOrSendErrors()
	{
		if (empty($this->_errorStack))
			return;

		if ($this->_showErrors)
			$this->_displayErrors();

		if ($this->_mailErrors)
			$this->_mailErrors();
	}

	private function _displayErrors()
	{
		if (!isset($this->_templateErrorFront))
			return;

		$errors = $this->_errorStack;
		require $this->_templateErrorFront;
	}

	private function mailErrors()
	{
		if (!isset($this->_templateErrorMail))
			return;

		$errors = $this->_errorStack;
		$subject = $this->_getMailSubject();
		$content = $this->_getMailContent();

		mail(implode(',', $this->_mailErrorsTo), $subject, $content);
	}

	private function _getMailSubject()
	{
		$subject = '[ErrorHanlder]';

		if ($this->_hasFatalError)
			$subject .= '[Error]';
		else
	 		$subject .= '[Notice]';

	 	return $subject;
	}

	private function _getMailContent()
	{
		ob_start();
		require $this->_templateErrorMail;
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

}
