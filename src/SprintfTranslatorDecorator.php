<?php

namespace Sharkodlak\Gettext;

/** Decorator for Translator which performs sprintf on translated message.
 **/
class SprintfTranslatorDecorator extends TranslatorBase {
	private $translator;

	private function callMethodAndSprintf($method, array $args, $methodArgsNumber) {
		$methodArgs = array_splice($args, 0, $methodArgsNumber);
		// translate using primary translator
		$callback = array($this->translator, $method);
		$message = call_user_func_array($callback, $methodArgs);
		// modify message with spare arguments just like sprintf
		return vsprintf($message, $args);
	}

	public function __construct(Translator $translator) {
		$this->translator = $translator;
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
}
