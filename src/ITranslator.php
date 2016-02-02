<?php

namespace Sharkodlak\Gettext;

if (!defined('LC_MESSAGES')) {
	define('LC_MESSAGES', 5);
}

if (!function_exists('dpgettext')) {
	/**
	 * Context-aware dgettext wrapper; use when messages in different contexts
	 * won't be distinguished from the English source but need different translations.
	 * The context string will appear as msgctxt in the .po files.
	 *
	 * Not currently exposed in PHP's gettext module; implemented to be compat
	 * with gettext.h's macros.
	 *
	 * @param string $domain domain identifier, or null for default domain
	 * @param string $context context identifier, should be some key like "menu|file"
	 * @param string $message English source text
	 * @return string original or translated message
	 */
	function dpgettext($domain, $context, $message) {
		$msgid = $context . ITranslator::GETTEXT_CONTEXT_GLUE . $message;
		$out = dgettext($domain, $msgid);
		if ($out == $msgid) {
			return $message;
		} else {
			return $out;
		}
	}
}

if (!function_exists('pgettext')) {
	function pgettext($context, $message) {
		$domain = textdomain(NULL);
		return dpgettext($domain, $context, $message);
	}
}

if (!function_exists('dnpgettext')) {
	/**
	 * Context-aware dngettext wrapper; use when messages in different contexts
	 * won't be distinguished from the English source but need different translations.
	 * The context string will appear as msgctxt in the .po files.
	 *
	 * Not currently exposed in PHP's gettext module; implemented to be compat
	 * with gettext.h's macros.
	 *
	 * @param string $domain domain identifier, or null for default domain
	 * @param string $context context identifier, should be some key like "menu|file"
	 * @param string $singular singular English source text
	 * @param string $plural plural English source text
	 * @param int $n number of items to control plural selection
	 * @return string original or translated message
	 */
	function dnpgettext($domain, $context, $singular, $plural, $n) {
		$msgid = $context . ITranslator::GETTEXT_CONTEXT_GLUE . $singular;
		$out = dngettext($domain, $msgid, $plural, $n);
		if ($out == $msgid) {
			return $singular;
		} else {
			return $out;
		}
	}
}

if (!function_exists('npgettext')) {
	function npgettext($context, $singular, $plural, $n) {
		$domain = textdomain(NULL);
		return dnpgettext($domain, $context, $singular, $plural, $n);
	}
}

interface ITranslator {
	/** The separator between msgctxt and msgid in a .mo file.
	 */
	const GETTEXT_CONTEXT_GLUE = "\x04";

	public function _($message);
	public function d_($domain, $message);
	public function dp_($domain, $context, $message);
	public function n_($singular, $plural, $count);
	public function np_($context, $singular, $plural, $count);
	public function p_($context, $message);
	public function dgettext($domain, $message);
	public function dngettext($domain, $singular, $plural, $count);
	public function dnpgettext($domain, $context, $singular, $plural, $count);
	public function dpgettext($domain, $context, $message);
	public function gettext($message);
	public function ngettext($singular, $plural, $count);
	public function npgettext($context, $singular, $plural, $count);
	public function pgettext($context, $message);
}
