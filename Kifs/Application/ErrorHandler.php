<?php
namespace Kifs\Application;

class ErrorHandler
{
	/**
	 * Pile of errors that have been catched
	 *
	 * @var array
	 */
	private $_errorStack = array();

	/**
	 * Flag if a fatal error occured
	 *
	 * @var bool
	 */
	private $_hasFatalError = false;

	/**
	 * Config - Display the error at the end of the script
	 *
	 * @var bool
	 */
	private $_showErrors = false;

	/**
	 * Config - Mail the errors at end of the script
	 *
	 * @var bool
	 */
	private $_mailErrors = false;

	/**
	 * Config - Template to display in case of a fatal error
	 *
	 * @var string
	 */
	private $_templateInternalError;

	/**
	 * Config - Template to use to display errors
	 *
	 * @var string
	 */
	private $_templateErrorFront;

	/**
	 * Config - Template to use when mailing the errors
	 *
	 * @var string
	 */
	private $_templateErrorMail;

	/**
	 * Config - Array of emails to which the mail will be sent
	 *
	 * @var array
	 */
	private $_mailErrorsTo = array();


	/**
	 * @param array $config Error handler config
	 */
	public function __construct($config)
	{
		$this->_loadConf($config);
	}

	/**
	 * Start catching errors
	 */
	public function start()
	{
		set_error_handler(array($this, 'errorHdlr'));
		set_exception_handler(array($this, 'exceptionHdlr'));
		register_shutdown_function(array($this, 'shutdownCallback'));
	}

	/**
	 * Function called when an error is catched
	 *
	 * @param int $errorType
	 * @param string $msg
	 * @param string $file
	 * @param int $line
	 */
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
	 * Function called when an exception is catched
	 *
	 * @param \Exception $e
	 */
	public function exceptionHdlr($e)
	{
		$this->errorHdlr(E_ERROR, $e->getMessage(), $e->getFile(), $e->getLine());
		$this->_hasFatalError = true;
		require $this->_templateInternalError;
		$this->_displayOrSendErrors();
	}

	/**
	 * Function called at the end of the script
	 */
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

	/**
	 * Retrieve configs from the config array $config
	 *
	 * @param array $config
	 */
	private function _loadConf($config)
	{
		if (empty($config) || !is_array($config))
			throw new \UnexpectedValueException('Config array for ErrorHandler class was empty or invalid');

		foreach ($config as $var => $value) {
			$property = '_'.$var;
			$this->$property = $value;
		}
	}

	/**
	 * Send or mail the errors depending on class' config
	 */
	private function _displayOrSendErrors()
	{
		if (empty($this->_errorStack))
			return;

		if ($this->_showErrors)
			$this->_displayErrors();

		if ($this->_mailErrors)
			$this->_mailErrors();
	}

	/**
	 * Display the errors
	 */
	private function _displayErrors()
	{
		if (!isset($this->_templateErrorFront))
			return;

		$errors = $this->_errorStack;
		require $this->_templateErrorFront;
	}

	/**
	 * Mail the errors
	 */
	private function mailErrors()
	{
		if (!isset($this->_templateErrorMail))
			return;

		$errors = $this->_errorStack;
		$subject = $this->_getMailSubject();
		$content = $this->_getMailContent();

		mail(implode(',', $this->_mailErrorsTo), $subject, $content);
	}

	/**
	 * Returns the subject of the mail containing the errors
	 */
	private function _getMailSubject()
	{
		$subject = '[ErrorHanlder]';

		if ($this->_hasFatalError)
			$subject .= '[Error]';
		else
	 		$subject .= '[Notice]';

	 	return $subject;
	}

	/**
	 * Returns the content of the mail containing the errors
	 */
	private function _getMailContent()
	{
		ob_start();
		require $this->_templateErrorMail;
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

}
