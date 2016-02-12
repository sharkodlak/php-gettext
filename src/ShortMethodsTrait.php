<?php

namespace Sharkodlak\Gettext;

/** Short method names to long method names aliases.
 *
 * @see Translator  View main interface defining long method names.
 * @see ShortMethodsTranslator  View interface defining short method names.
 */
trait ShortMethodsTrait {
	/** Lookup a message in the current domain.
	 *
	 * @param string  $message Message to translate.
	 *
	 * @return string  Returns translated message if found. If message translation isn't found returns original message.
	 *
	 * @see Translator::gettext()  Long method name alias.
	 **/
	public function _($message) {
		return $this->gettext($message);
	}

	/** Lookup a message in the given domain.
	 *
	 * @param string  $domain In which domain (filename) to look up.
	 * @param string  $message Message to translate.
	 *
	 * @return string  Returns translated message if found. If message translation isn't found returns original message.
	 *
	 * @see Translator::dgettext()  Long method name alias.
	 **/
	public function d_($domain, $message) {
		return $this->dgettext($domain, $message);
	}

	/** Plural version of d_.
	 * Some languages have more than one form for plural messages dependent on the count.
	 *
	 * @param string  $domain In which domain (filename) to look up.
	 * @param string  $singular Message in singular form.
	 * @param string  $plural Message in plural form.
	 * @param int  $count The number (e.g. item count) to determine the translation for the respective grammatical number.
	 *
	 * @return string  Returns correct plural form of message if found, otherwise it returns $singular for $count == 1
	 *  or $plural for rest.
	 *
	 * @see ShortMethodsTrait::d_()  To view message in given domain lookup.
	 * @see Translator::dngettext()  Long method name alias.
	 */
	public function dn_($domain, $singular, $plural, $count) {
		return $this->dngettext($domain, $singular, $plural, $count);
	}

	/** Plural version of dp_.
	 * Some languages have more than one form for plural messages dependent on the count.
	 *
	 * @param string  $domain In which domain (filename) to look up.
	 * @param string  $context Context name that distinguishes particular translation. Should be short and rarely need to change.
	 * @param string  $singular Message in singular form.
	 * @param string  $plural Message in plural form.
	 * @param int  $count The number (e.g. item count) to determine the translation for the respective grammatical number.
	 *
	 * @return string  Returns correct plural form of message if found, otherwise it returns $singular for $count == 1
	 *  or $plural for rest.
	 *
	 * @see ShortMethodsTrait::dn_()  To view plural version of dgettext.
	 * @see ShortMethodsTrait::dp_()  To view contextual (particular) message in the given domain lookup.
	 * @see Translator::dnpgettext()  Long method name alias.
	 */
	public function dnp_($domain, $context, $singular, $plural, $count) {
		return $this->dnpgettext($domain, $context, $singular, $plural, $count);
	}

	/** Lookup a contextual (particular) message in the given domain.
	 *
	 * @param string  $context Context name that distinguishes particular translation. Should be short and rarely need to change.
	 * @param string  $message Message to translate.
	 *
	 * @return string  Returns translated message if found. If message translation isn't found returns original message.
	 *
	 * @see ShortMethodsTrait::d_()  To view message in the given domain lookup.
	 * @see Translator::dpgettext()  Long method name alias.
	 */
	public function dp_($domain, $context, $message) {
		return $this->dpgettext($domain, $context, $message);
	}

	/** Plural version of _.
	 * Some languages have more than one form for plural messages dependent on the count.
	 *
	 * @param string  $singular Message in singular form.
	 * @param string  $plural Message in plural form.
	 * @param int  $count The number (e.g. item count) to determine the translation for the respective grammatical number.
	 *
	 * @return string  Returns correct plural form of message if found, otherwise it returns $singular for $count == 1
	 *  or $plural for rest.
	 *
	 * @see ShortMethodsTrait::_()  To view message in the current domain lookup.
	 * @see Translator::ngettext()  Long method name alias.
	 */
	public function n_($singular, $plural, $count) {
		return $this->ngettext($singular, $plural, $count);
	}

	/** Plural version of p_.
	 * Some languages have more than one form for plural messages dependent on the count.
	 *
	 * @param string  $context Context name that distinguishes particular translation. Should be short and rarely need to change.
	 * @param string  $singular Message in singular form.
	 * @param string  $plural Message in plural form.
	 * @param int  $count The number (e.g. item count) to determine the translation for the respective grammatical number.
	 *
	 * @return string  Returns correct plural form of message if found, otherwise it returns $singular for $count == 1
	 *  or $plural for rest.
	 *
	 * @see ShortMethodsTrait::n_()  To view plural version of gettext.
	 * @see ShortMethodsTrait::p_()  To view contextual (particular) message in the current domain lookup.
	 * @see Translator::npgettext()  Long method name alias.
	 */
	public function np_($context, $singular, $plural, $count) {
		return $this->npgettext($context, $singular, $plural, $count);
	}

	/** Lookup a contextual (particular) message in the current domain.
	 *
	 * @param string  $context Context name that distinguishes particular translation. Should be short and rarely need to change.
	 * @param string  $message Message to translate.
	 *
	 * @return string  Returns translated message if found. If message translation isn't found returns original message.
	 *
	 * @see ShortMethodsTrait::_()  To view message in the current domain lookup.
	 * @see Translator::pgettext()  Long method name alias.
	 */
	public function p_($context, $message) {
		return $this->pgettext($context, $message);
	}
}
