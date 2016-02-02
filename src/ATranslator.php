<?php

namespace Sharkodlak\Gettext;


abstract class ATranslator implements ITranslator {
	/** Allows to add context to standard message.
	 *
	 * This is usefull for standard functions which accepts only message parameter
	 * for example form functions. This function shall be added to GettextExtractor
	 * known functions.
	 * Ex: $ge->getFilter('PHP')->addFunction('addContext', 2, NULL, 1);
	 *
	 * @param string $context Context.
	 * @param string $message Message.
	 * @return string Returns message with context.
	 **/
	static public function addContext($context, $message) {
		return $context . self::GETTEXT_CONTEXT_GLUE . $message;
	}

	/** Allows to add contextual plural form to standard message.
	 *
	 * This is usefull for standard functions which accepts only singular
	 * and plural parameters without context, for example form functions.
	 * This function shall be added to GettextExtractor known functions.
	 * Ex: $ge->getFilter('PHP')->addFunction('addPlural', 2, 3, 1);
	 *
	 * @param string $context Context.
	 * @param string $singular Message in singular form.
	 * @param string $plural Message in plural form.
	 * @return string Returns singular message with context. Translate function
	 *   will use it to find singular or plural form accordingly to number.
	 **/
	static public function addPlural($context, $singular, $plural) {
		return $context . self::GETTEXT_CONTEXT_GLUE . $singular;
	}


	public function _($message) {
		return $this->gettext($message);
	}

	public function d_($domain, $message) {
		return $this->dgettext($domain, $message);
	}

	public function dn_($domain, $singular, $plural, $count) {
		return $this->dngettext($domain, $singular, $plural, $count);
	}

	public function dnp_($domain, $context, $singular, $plural, $count) {
		return $this->dnpgettext($domain, $context, $singular, $plural, $count);
	}

	public function dp_($domain, $context, $message) {
		return $this->dpgettext($domain, $context, $message);
	}

	public function n_($singular, $plural, $count) {
		return $this->ngettext($singular, $plural, $count);
	}

	public function np_($context, $singular, $plural, $count) {
		return $this->npgettext($context, $singular, $plural, $count);
	}

	public function p_($context, $message) {
		return $this->pgettext($context, $message);
	}
}
