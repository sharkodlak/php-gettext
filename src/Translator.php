<?php

namespace Sharkodlak\Gettext;

if (!defined('LC_MESSAGES')) {
	/** Specify gettext LC_MESSAGES constant if it's missing (e.g. module not loaded).
	 */
	define('LC_MESSAGES', 5);
}

if (!function_exists('dpgettext')) {
	/** Context-aware dgettext wrapper; use when messages in different contexts
	 * won't be distinguished from the English source but need different translations.
	 * The context string will appear as msgctxt in the .po files.
	 *
	 * Not currently exposed in PHP's gettext module; implemented to be compatible
	 * with gettext.h's macros.
	 *
	 * @param string  $domain domain identifier, or null for default domain
	 * @param string  $context context identifier, should be some key like "menu|file"
	 * @param string  $message English source text
	 *
	 * @return string  translated message or original if translation not found
	 */
	function dpgettext($domain, $context, $message) {
		$msgid = $context . Translator::GETTEXT_CONTEXT_GLUE . $message;
		$out = dgettext($domain, $msgid);
		if ($out === $msgid) {
			return $message;
		}
		return $out;
	}
}

if (!function_exists('pgettext')) {
	function pgettext($context, $message) {
		$domain = textdomain(null);
		return dpgettext($domain, $context, $message);
	}
}

if (!function_exists('dnpgettext')) {
	/** Context-aware dngettext wrapper; use when messages in different contexts
	 * won't be distinguished from the English source but need different translations.
	 * The context string will appear as msgctxt in the .po files.
	 *
	 * Not currently exposed in PHP's gettext module; implemented to be compatible
	 * with gettext.h's macros.
	 *
	 * @param string  $domain domain identifier, or null for default domain
	 * @param string  $context context identifier, should be some key like "menu|file"
	 * @param string  $singular singular English source singular form
	 * @param string  $plural plural English source plural form
	 * @param int $count  number of items to control plural selection
	 *
	 * @return string  translated message or original if translation not found
	 */
	function dnpgettext($domain, $context, $singular, $plural, $count) {
		$msgid = $context . Translator::GETTEXT_CONTEXT_GLUE . $singular;
		$out = dngettext($domain, $msgid, $plural, $count);
		if ($out === $msgid) {
			if ($count == 1) {
				return $singular;
			}
			return $plural;
		}
		return $out;
	}
}

if (!function_exists('npgettext')) {
	function npgettext($context, $singular, $plural, $count) {
		$domain = textdomain(null);
		return dnpgettext($domain, $context, $singular, $plural, $count);
	}
}

/** Classes implementing this interface will be interchangeable as translator objects.
 *
 * I've decided not to require dcgettext and dcngettext as they have minor use.
 * If needed, they can be implemented in ExpandMethodsTrait.
 */
interface Translator {
	/** The separator between msgctxt and msgid in a .mo file.
	 *
	 * @var string  The separator between msgctxt and msgid in a .mo file.
	 */
	const GETTEXT_CONTEXT_GLUE = "\x04";

	/** Lookup a message in the given domain.
	 *
	 * @param string  $domain In which domain (filename) to look up.
	 * @param string  $message Message to translate.
	 *
	 * @return string  Returns translated message if found. If message translation isn't found returns original message.
	 **/
	public function dgettext($domain, $message);

	/** Plural version of dgettext.
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
	 * @see Translator::dgettext()  To view message in given domain lookup.
	 */
	public function dngettext($domain, $singular, $plural, $count);

	/** Plural version of dpgettext.
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
	 * @see Translator::dngettext()  To view plural version of dgettext.
	 * @see Translator::dpgettext()  To view contextual (particular) message in the given domain lookup.
	 */
	public function dnpgettext($domain, $context, $singular, $plural, $count);

	/** Lookup a contextual (particular) message in the given domain.
	 *
	 * @param string  $context Context name that distinguishes particular translation. Should be short and rarely need to change.
	 * @param string  $message Message to translate.
	 *
	 * @return string  Returns translated message if found. If message translation isn't found returns original message.
	 *
	 * @see Translator::dgettext()  To view message in the given domain lookup.
	 */
	public function dpgettext($domain, $context, $message);

	/** Lookup a message in the current domain.
	 *
	 * @param string  $message Message to translate.
	 *
	 * @return string  Returns translated message if found. If message translation isn't found returns original message.
	 **/
	public function gettext($message);

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
	 * @see Translator::gettext()  To view message in the current domain lookup.
	 */
	public function ngettext($singular, $plural, $count);

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
	 * @see Translator::ngettext()  To view plural version of gettext.
	 * @see Translator::pgettext()  To view contextual (particular) message in the current domain lookup.
	 */
	public function npgettext($context, $singular, $plural, $count);

	/** Lookup a contextual (particular) message in the current domain.
	 *
	 * @param string  $context Context name that distinguishes particular translation. Should be short and rarely need to change.
	 * @param string  $message Message to translate.
	 *
	 * @return string  Returns translated message if found. If message translation isn't found returns original message.
	 *
	 * @see Translator::gettext()  To view message in the current domain lookup.
	 */
	public function pgettext($context, $message);
}
