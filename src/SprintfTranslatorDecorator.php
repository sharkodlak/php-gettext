<?php

namespace Sharkodlak\Gettext;


/** Decorator for \Nette\ITranslator which performs sprintf on translated message.
 **/
class SprintfTranslatorDecorator extends ATranslator {
	private $translator;


	public function __construct(ITranslator $translator) {
		$this->translator = $translator;
	}


	private function callMethodAndSprintf($method, array $args, $methodArgsNumber) {
		$methodArgs = array_splice($args, 0, $methodArgsNumber);
		// translate using primary translator
		$callback = array($this->translator, $method);
		$message = call_user_func_array($callback, $methodArgs);

		// modify message with spare arguments just like sprintf
		error_log(var_export($message, true));

		$message = vsprintf($message, $args);
		error_log(var_export($message, true));

		return $message;
	}

	public function dgettext($domain, $message) {
		$args = func_get_args();
		$methodArgsNumber = 2;
		$message = $this->callMethodAndSprintf(__FUNCTION__, $args, $methodArgsNumber);
		return $message;
	}

	public function dngettext($domain, $singular, $plural, $count) {
		$args = func_get_args();
		$methodArgsNumber = 4;
		$message = $this->callMethodAndSprintf(__FUNCTION__, $args, $methodArgsNumber);
		return $message;
	}

	public function dnpgettext($domain, $context, $singular, $plural, $count) {
		$args = func_get_args();
		$methodArgsNumber = 5;
		$message = $this->callMethodAndSprintf(__FUNCTION__, $args, $methodArgsNumber);
		return $message;
	}

	public function dpgettext($domain, $context, $message) {
		$args = func_get_args();
		$methodArgsNumber = 3;
		$message = $this->callMethodAndSprintf(__FUNCTION__, $args, $methodArgsNumber);
		return $message;
	}

	/** Call sprintf on the translation result.
	 *
	 * @param string $message Message to translate (in singular form).
	 * @param mixed $arg,... First argument that will be formated according to
	 *   format specified in translated $message.
	 */
	public function gettext($message) {
		$args = func_get_args();
		$methodArgsNumber = 1;
		$message = $this->callMethodAndSprintf(__FUNCTION__, $args, $methodArgsNumber);
		return $message;
	}

	public function ngettext($singular, $plural, $count) {
		$args = func_get_args();
		$methodArgsNumber = 3;
		$message = $this->callMethodAndSprintf(__FUNCTION__, $args, $methodArgsNumber);
		return $message;
	}

	public function npgettext($context, $singular, $plural, $count) {
		$args = func_get_args();
		$methodArgsNumber = 4;
		$message = $this->callMethodAndSprintf(__FUNCTION__, $args, $methodArgsNumber);
		return $message;
	}

	public function pgettext($context, $message) {
		$args = func_get_args();
		$methodArgsNumber = 2;
		$message = $this->callMethodAndSprintf(__FUNCTION__, $args, $methodArgsNumber);
		return $message;
	}

	/** Translates the given string.
	 *
	 * @deprecated
	 **/
	public function translate($message, $count = NULL) {
		$args = func_get_args();
		$methodArgsNumber = 2;

		if (isset($count) && count($args) == 2) {
			$args[] = array($count);
		}

		$message = $this->callMethodAndSprintf(__FUNCTION__, $args, $methodArgsNumber);
		return $message;
	}
}
