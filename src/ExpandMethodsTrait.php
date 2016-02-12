<?php

namespace Sharkodlak\Gettext;

/** Allow to define only methods which accepts domain.
 * Methods defined here will call D variant of same method with default domain used.
 */
trait ExpandMethodsTrait {
	/** Provide default domain.
	 *
	 * @return string  Returns instance's default domain.
	 */
	abstract public function getDefaultDomain();

	/** Lookup a message in the current domain.
	 *
	 * @param string  $message Message to translate.
	 *
	 * @return string  Returns translated message if found. If message translation isn't found returns original message.
	 **/
	public function gettext($message) {
		$domain = $this->getDefaultDomain();
		return $this->dgettext($domain, $message);
	}

	/** Plural version of gettext.
	 * Some languages have more than one form for plural messages dependent on the count.
	 *
	 * @param string  $singular Message in singular form.
	 * @param string  $plural Message in plural form.
	 * @param int  $count The number (e.g. item count) to determine the translation for the respective grammatical number.
	 *
	 * @return string  Returns correct plural form of message if found, otherwise it returns $singular for $count == 1
	 *  or $plural for rest.
	 *
	 * @see ExpandMethodsTrait::gettext()  To view message in the current domain lookup.
	 */
	public function ngettext($singular, $plural, $count) {
		$domain = $this->getDefaultDomain();
		return $this->dngettext($domain, $singular, $plural, $count);
	}

	/** Plural version of pgettext.
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
	 * @see ExpandMethodsTrait::ngettext()  To view plural version of gettext.
	 * @see ExpandMethodsTrait::pgettext()  To view contextual (particular) message in the current domain lookup.
	 */
	public function npgettext($context, $singular, $plural, $count) {
		$domain = $this->getDefaultDomain();
		return $this->dnpgettext($domain, $context, $singular, $plural, $count);
	}

	/** Lookup a contextual (particular) message in the current domain.
	 *
	 * @param string  $context Context name that distinguishes particular translation. Should be short and rarely need to change.
	 * @param string  $message Message to translate.
	 *
	 * @return string  Returns translated message if found. If message translation isn't found returns original message.
	 *
	 * @see ExpandMethodsTrait::gettext()  To view message in the current domain lookup.
	 */
	public function pgettext($context, $message) {
		$domain = $this->getDefaultDomain();
		return $this->dpgettext($domain, $context, $message);
	}
}
