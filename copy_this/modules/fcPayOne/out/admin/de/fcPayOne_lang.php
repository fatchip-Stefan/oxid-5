<?php
/** 
 * PAYONE OXID Connector is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PAYONE OXID Connector is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with PAYONE OXID Connector.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://www.payone.de
 * @copyright (C) Payone GmbH
 * @version   OXID eShop CE
 */
 

$sLangName  = "Deutsch";
// -------------------------------
// RESOURCE IDENTITFIER = STRING
// -------------------------------
$aLang = array(
    'charset'                                   => 'ISO-8859-15',
    'fcpo_admin_title'                          => 'PAYONE',
    'fcpo_main_title'                           => 'Konfiguration',
    'fcpo_main_log'                             => 'Transaktionen',
    'FCPO_MERCHANT_ID'                          => 'PAYONE Merchant ID',
    'FCPO_PORTAL_ID'                            => 'PAYONE Portal ID',
    'FCPO_PORTAL_KEY'                           => 'PAYONE Portal Key',
    'FCPO_OPERATION_MODE'                       => 'PAYONE Betriebsmodus',
    'FCPO_BONI_OPERATION_MODE'                  => 'Betriebsmodus',
    'FCPO_SUBACCOUNT_ID'                        => 'PAYONE Sub-Account ID',
    'FCPO_BANKACCOUNTCHECK'                     => 'Prüfung Bankverbindung',
    'FCPO_DEACTIVATED'                          => 'Deaktiviert',
    'FCPO_ACTIVATED'                            => 'Aktiviert',
    'FCPO_ACTIVATEDWITHPOS'                     => 'Aktiviert, mit Prüfung gegen POS-Sperrliste<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Nur Zahlmethode Lastschrift Deutschland)',
    'FCPO_LIVE_MODE'                            => 'Livemodus',
    'FCPO_TEST_MODE'                            => 'Testmodus',
    'fcpo_order_title'                          => 'PAYONE',
    'FCPO_REFNR'                                => 'Referenz-Nummer',
    'FCPO_TXID'                                 => 'PAYONE-Vorgangsnummer (txid)',
    'fcpo_action_appointed'                     => 'Bestellung',
    'fcpo_action_capture'                       => 'Abbuchung',
    'fcpo_action_paid'                          => 'Bezahlung',
    'fcpo_action_underpaid'                     => 'Unterzahlung',
    'fcpo_action_overpaid'                      => '<span style="color: red;">Überzahlung</span>',
    'fcpo_action_cancelation'                   => 'Rückbelastung',
    'fcpo_action_refund'                        => 'Rückerstattung',
    'fcpo_action_debit'                         => 'Forderung/Gutschrift',
    'fcpo_action_transfer'                      => 'Umbuchung',
    'fcpo_action_reminder'                      => 'Status Mahnverfahren',
    'fcpo_clearingtype_elv'                     => 'Lastschrift',
    'fcpo_clearingtype_cc'                      => 'Kreditkarte',
    'fcpo_clearingtype_vor'                     => 'Vorkasse',
    'fcpo_clearingtype_rec'                     => 'Rechnung',
    'fcpo_clearingtype_cod'                     => 'Nachnahme',
    'fcpo_clearingtype_sb'                      => 'Online-Überweisung',
    'fcpo_clearingtype_wlt'                     => 'e-Wallet',
    'fcpo_clearingtype_fnc'                     => 'Finanzierung',
    'fcpo_clearingtype_csh'                     => 'Barzahlen',
    'fcpo_clearingtype_fcpobillsafe'            => 'BillSAFE',
    'fcpo_clearingtype_fcpoklarna'              => 'Klarna Rechnung',
    'FCPO_CAPTURE_APPROVED'                     => 'Buchung war erfolgreich',
    'FCPO_CAPTURE_ERROR'                        => 'Fehler bei Buchung: ',
    'FCPO_DEBIT_APPROVED'                       => 'Gutschrift war erfolgreich',
    'FCPO_DEBIT_ERROR'                          => 'Fehler bei Gutschrift: ',
    'FCPO_LIST_HEADER_TXTIME'                   => 'Zeitpunkt',
    'FCPO_LIST_HEADER_ORDERNR'                  => 'Bestellnummer',
    'FCPO_LIST_HEADER_TXID'                     => 'Transaktionsnummer',
    'FCPO_LIST_HEADER_CLEARINGTYPE'             => 'Zahlmethode',
    'FCPO_LIST_HEADER_EMAIL'                    => 'Kunden-E-Mail',
    'FCPO_LIST_HEADER_PRICE'                    => 'Betrag',
    'FCPO_LIST_HEADER_TXACTION'                 => 'Status',
    'FCPO_EXECUTE'                              => 'Auslösen',
    'FCPO_CAPTURE'                              => 'Capture ( Abbuchen )',
    'FCPO_DEBIT'                                => 'Debit ( Gutschrift )',
    'FCPO_ARE_YOU_SURE'                         => 'Sind Sie sicher, dass Sie diese Aktion ausführen möchten?',
    'FCPO_DE'                                   => 'Deutschland',
    'FCPO_AT'                                   => 'Österreich',
    'FCPO_NL'                                   => 'Niederlande',
    'FCPO_HEADER_BANKACCOUNT'                   => 'Bankverbindung (optional)',
    'FCPO_BANKCOUNTRY'                          => 'Kontoland',
    'FCPO_BANKACCOUNT'                          => 'Kontonummer',
    'FCPO_BANKCODE'                             => 'Bankleitzahl',
    'FCPO_BANKACCOUNTHOLDER'                    => 'Kontoinhaber',
    'FCPO_SHOW'                                 => 'anzeigen',
    'FCPO_HIDE'                                 => 'verstecken',
    'FCPO_PAYMENTTYPE'                          => 'Zahlungsart',
    'FCPO_CARDEXPIREDATE'                       => 'Verfallsdatum',
    'FCPO_CARDTYPE'                             => 'Kartentyp',
    'FCPO_CARDPAN'                              => 'Maskierte Kartenummer',
    'FCPO_BALANCE'                              => 'Saldo',
    'FCPO_RECEIVABLE'                           => 'Zahlung',
    'FC_IS_PAYONE'								=> 'Dies ist eine PAYONE Zahlungsmethode',
    'FCPO_HELP_MERCHANTID'                      => 'Ihre PAYONE Merchant-ID (PAYONE Kundennummer) finden Sie auf allen Abrechnungen von PAYONE sowie rechts oben im PAYONE Merchant Interface (PMI).',
    'FCPO_HELP_PORTALID'                        => 'Bitte tragen Sie hier die ID des PAYONE Zahlungsportals ein, über welches die Zahlungen abgewickelt werden sollen.<br>Die Portal-ID finden Sie unter <a href="http://www.payone.de" target="_blank">http://www.payone.de</a> > Händler-Login unter dem Menüpunkt Konfiguration > Zahlungsportale<br><br>Alle relevanten Parameter zur Konfiguration erhalten Sie nach Auswahl von [editieren] unter dem Reiter [API-Parameter]',
    'FCPO_HELP_PORTALKEY'                       => 'Bitte tragen Sie hier den Key zur Absicherung des Datenaustausches ein. Dieser kann bei der Konfiguration des PAYONE Zahlungsportals von Ihnen frei festgelegt werden.<br>Die Konfiguration finden Sie unter <a href="http://www.payone.de" target="_blank">http://www.payone.de</a> > Händler-Login unter dem Menüpunkt Konfiguration > Zahlungsportale > [editieren] > Reiter [Erweitert] > Key<br><br>Alle relevanten Parameter zur Konfiguration erhalten Sie nach Auswahl des Reiters [API-Parameter]',
    'FCPO_HELP_OPERATIONMODE'                   => 'Hier können Sie für diese Zahlungsart festlegen ob die Zahlungen im Testmodus abgewickelt werden, oder ob diese Live ausgeführt werden. Bitte beachten Sie, dass für den Testmodus die definierten Testdaten verwendet werden müssen.',
    'FCPO_HELP_SUBACCOUNTID'                    => 'Bitte tragen Sie hier die ID des Sub-Accounts ein, über welchen die Zahlungen abgewickelt und zugeordnet werden sollen.<br>Die ID finden Sie unter <a href="http://www.payone.de" target="_blank">http://www.payone.de</a> > Händler-Login unter dem Menüpunkt Konfiguration > Accounts<br><br>Alle relevanten Parameter zur Konfiguration erhalten Sie unter <a href="http://www.payone.de" target="_blank">http://www.payone.de</a> > Händler-Login unter dem Menüpunkt Konfiguration > Zahlungsportale > [editieren] > Reiter [API-Parameter]',
    'FCPO_HELP_POSCHECK'                        => 'Hier können Sie definieren ob eine Prüfung der Bankverbindung gegen die POS-Sperrdatei durchgeführt werden soll. Bitte beachten Sie, dass die das Modul "Protect" beauftragt worden sein muss und die Prüfung nur für die Zahlungsart Lastschrift Deutschland durchgeführt wird.',
    'fcpo_admin_config'                         => 'PAYONE Konfiguration',
    'fcpo_admin_config_payment'                 => 'PAYONE Zahlungseinstellungen',
    'fcpo_admin_protocol'                       => 'PAYONE Protokolle / Logs',
    'FCPO_NO_TRANSACTION'                       => 'Keine Transaktion ausgewählt',
    'fcpo_admin_information'                    => 'PAYONE Information',
    'fcpo_admin_common'                         => 'Allgemein',
    'fcpo_admin_support'                        => 'Support',
    'fcpo_admin_api_logs'                       => 'API Logs',
    'FCPO_LIST_HEADER_TIMESTAMP'                => 'Zeit',
    'FCPO_LIST_HEADER_REQUEST'                  => 'Request',
    'FCPO_LIST_HEADER_RESPONSE'                 => 'Response',
    'FCPO_NO_APILOG'                            => 'Kein Log-Eintrag ausgewählt',
    'FCPO_ACTIVE_CREDITCARD_TYPES'              => 'Aktive Kreditkartenbrands',
    'FCPO_CREDITCARDBRANDS_INFOTEXT'            => 'Hier können Sie die einzelnen Kreditkartenbrands für die Zahlart Kreditkarte aktivieren und konfigurieren.<br>Bitte beachten Sie, dass der jeweilige Kreditkartenbrand bei PAYONE beauftragt worden sein muss.<br>Die Einstellung für die Zahlungsart Kreditkarte nehmen Sie unter PAYONE -> Konfiguration -> Zahlungsarten vor.',
    'FCPO_ACTIVE_ONLINE_UBERWEISUNG_TYPES'      => 'Aktive Online-Überweisungsarten',
    'FCPO_ONLINEUBERWEISUNG_INFOTEXT'           => 'Hier können Sie die einzelnen Online-Überweisungsarten für die Zahlart Online-Überweisung aktivieren und konfigurieren.<br>Bitte beachten Sie, dass die jeweilige Online-Überweisungsart bei PAYONE beauftragt worden sein muss.<br>Die Einstellung für die Zahlungsart Online-Überweisungsart nehmen Sie unter PAYONE -> Konfiguration -> Zahlungsarten vor.',
    'FCPO_CHANNEL'                              => 'Channel',
    'FCPO_AUTHORIZATION_METHOD'                 => 'Autorisierungs-Methode',
    'FCPO_PREAUTHORIZATION'                     => 'Vorautorisierung',
    'FCPO_PREAUTHORIZATION_HELP'                => 'Bei der Auswahl von "Vorautorisierung" wird der zu zahlende Betrag im Zuge der Bestellung reserviert [von PAYONE empfohlen]. Die Abbuchung (Capture) muss in diesem Fall in einem zweiten Schritt bei Auslieferung der Ware initiiert werden.',
    'FCPO_AUTHORIZATION'                        => 'Autorisierung',
    'FCPO_AUTHORIZATION_HELP'                   => 'Bei der Auswahl von "Autorisierung" wird der zu zahlende Betrag sofort im Zuge der Bestellung eingezogen.',
    'dyn_fcpayone'                              => 'PAYONE',
    'FCPO_ONLY_PAYONE'                          => 'Nur PAYONE',
    'ORDER_LIST_YOUWANTTOSTORNO'                => 'Wollen Sie diese Bestellung wirklich stornieren?\n ACHTUNG: ggf. offene PAYONE Vorgänge zu dieser Bestellung bitte vor dem Stornieren abschliessen.',
    'FCPO_ORDER_LIST_YOUWANTTODELETE'           => 'Wollen Sie diesen Eintrag wirklich löschen?\n ACHTUNG: ggf. offene PAYONE Vorgänge zu dieser Bestellung bitte vor dem Löschen abschliessen.',
    'fcpo_admin_config_bonicheck'               => 'Protect',
    'FCPO_ADDRESSCHECKTYPE'                     => 'Adressprüfung',
    'FCPO_NO_ADDRESSCHECK'                      => 'Keine Adressprüfung durchführen',
    'FCPO_BASIC_ADDRESSCHECK'                   => 'AdressCheck Basic',
    'FCPO_PERSON_ADDRESSCHECK'                  => 'AdressCheck Person',
    'FCPO_HELP_NO_ADDRESSCHECK'                 => 'Deaktivierung der Adressprüfung',
    'FCPO_HELP_BASIC_ADDRESSCHECK'              => 'Prüfung der Adresse auf Existenz sowie Ergänzung und Korrektur der Adresse (Möglich für Adressen aus Deutschland, Österreich, Schweiz, Niederlande, Belgien, Luxemburg, Frankreich, Italien, Spanien, Portugal, Dänemark, Schweden, Finnland, NorwegenPolen, Slowakei, Tschechien, Ungarn, USA, Kanada)',
    'FCPO_HELP_PERSON_ADDRESSCHECK'             => 'Prüfung ob die Person unter der angegebenen der Adresse bekannt ist, Prüfung der Adresse auf Existenz sowie Ergänzung und Korrektur der Adresse (nur Deutschland)',
    'FCPO_CONSUMERSCORETYPE'                    => 'Bonitätsprüfung',
    'FCPO_NO_BONICHECK'                         => 'Keine Bonitätsprüfung durchführen',
    'FCPO_HARD_BONICHECK'                       => 'Infoscore (Harte Merkmale)',
    'FCPO_ALL_BONICHECK'                        => 'Infoscore (Alle Merkmale)',
    'FCPO_ALL_SCORE_BONICHECK'                  => 'Infoscore (Alle Merkmale + Boniscore)',
    'FCPO_HELP_NO_BONICHECK'                    => 'Deaktivierung der Bonitätsprüfung',
    'FCPO_HELP_HARD_BONICHECK'                  => 'Prüfung auf so genannte "harte" Negativmerkmale (z.B. Verbraucherinsolvenzverfahren, Haftbefehl zur Eidesstattliche Versicherung oder Erzwingung Abgabe der Eidesstattlichen Versicherung). Die Bonitätsprüfung unterstützt ausschließlich die Prüfung von Käufern aus Deutschland.',
    'FCPO_HELP_ALL_BONICHECK'                   => 'Prüfung auf so genannte "harte" Negativmerkmale (z.B. Verbraucherinsolvenzverfahren, Haftbefehl zur Eidesstattliche Versicherung oder Erzwingung Abgabe der Eidesstattlichen Versicherung), "mittlere" Negativmerkmale (z.B. Mahnbescheid, Vollstreckungsbescheid oder Zwangsvollstreckung) und "weiche" Negativmerkmale (z.B. Inkasso-Mahnverfahren eingeleitet, Fortlauf des außergerichtlichen Inkasso-Mahnverfahrens nach Teilzahlung, Einstellung des außergerichtlichen Inkasso-Mahnverfahrens wegen Aussichtslosigkeit). Die Bonitätsprüfung unterstützt ausschließlich die Prüfung von Käufern aus Deutschland.',
    'FCPO_HELP_ALL_SCORE_BONICHECK'             => 'Prüfung auf so genannte "harte" Negativmerkmale (z.B. Verbraucherinsolvenzverfahren, Haftbefehl zur Eidesstattliche Versicherung oder Erzwingung Abgabe der Eidesstattlichen Versicherung), "mittlere" Negativmerkmale (z.B. Mahnbescheid, Vollstreckungsbescheid oder Zwangsvollstreckung) und "weiche" Negativmerkmale (z.B. Inkasso-Mahnverfahren eingeleitet, Fortlauf des außergerichtlichen Inkasso-Mahnverfahrens nach Teilzahlung, Einstellung des außergerichtlichen Inkasso-Mahnverfahrens wegen Aussichtslosigkeit). Die Bonitätsprüfung unterstützt ausschließlich die Prüfung von Käufern aus Deutschland.<br><br>Der BoniScore ist ein Scorewert und ermöglicht eine höhere Trennschärfe bei vorliegenden Negativmerkmalen.',
    'FCPO_HELP_BONI_OPERATIONMODE'              => 'Hier können Sie für die Bonitätsprüfung festlegen ob die Überprüfungen im Testmodus abgewickelt werden, oder ob diese Live ausgeführt werden.',
    'FCPO_SEND_ARTICLELIST'                     => 'Artikelliste versenden',
    'FCPO_HELP_SEND_ARTICLELIST'                => 'Bei Aktivierung wird in den vorgesehenen Anfragen an das PAYONE System der Warenkorb incl. der Artikeleinzelpreise mit versendet.<br>Diese Option muss aktiviert sein wenn sie das PAYONE Invoicing beauftragt haben.',
    'FCPO_CHECK_DEL_ADDRESS'                    => 'Lieferadresse prüfen',
    'FCPO_HELP_CHECK_DEL_ADDRESS'               => 'Zusätzliche Prüfung der Lieferadresse durch die Adressprüfung.',
    'FCPO_CORRECT_ADDRESS'                      => 'Korrigierte Adressen übernehmen',
    'FCPO_HELP_CORRECT_ADDRESS'                 => 'Übernahme der jeweils durch die Adressprüfung korrigierten Adresse anstatt der eingegebenen Adresse in Ihren Shop.',
    'FCPO_STATUS_WITH_USER_CORRECTION'          => 'User wird wieder zum Benutzerformular geschickt wenn:',
    'FCPO_ADDRESSCHECK_PPB'                     => 'Vor- & Nachname bekannt',
    'FCPO_ADDRESSCHECK_PHB'                     => 'Nachname bekannt',
    'FCPO_ADDRESSCHECK_PAB'                     => 'Vor- & Nachname nicht bekannt',
    'FCPO_ADDRESSCHECK_PKI'                     => 'Mehrdeutigkeit bei Name zu Anschrift',
    'FCPO_ADDRESSCHECK_PNZ'                     => 'Wenn nicht (mehr) zu Adresse zustellbar wird Benutzer zum Benutzerformular zurück geschickt',
    'FCPO_ADDRESSCHECK_PPV'                     => 'Person verstorben',
    'FCPO_ADDRESSCHECK_PPF'                     => 'Wenn Adresse postalisch falsch wird Benutzer zum Benutzerformular zurück geschickt',
    'FCPO_ADDRESSCHECK_PUG'                     => 'Wenn Gebäude nicht bekannt wird Benutzer zum Benutzerformular zurück geschickt',
    'FCPO_ADDRESSCHECK_PUZ'                     => 'Wenn Person umgezogen wird Benutzer zum Benutzerformular zurück geschickt',
    'FCPO_ADDRESSCHECK_UKN'                     => 'Wenn Werte unbekannt wird Benutzer zum Benutzerformular zurück geschickt',
    'FCPO_ADDRESSCHECK_PNP'                     => 'Wenn Adresse aufgrund eines falschen Namens nicht geprüft werden kann wird Benutzer zum Benutzerformular zurück geschickt',
    'FCPO_DURABILITY_BONICHECK'                 => 'Lebensdauer Bonitätsprüfung in Tagen',
    'FCPO_HELP_DURABILITY_BONICHECK'            => 'Anzahl in Tagen, nach der eine neue Bonitätsprüfung durchgeführt wird.<br><br>Bitte beachten Sie die Bestimmungen des BDSG und der Vertragsbedingungen bzgl. der Speicherung und der Lebensdauer der Bonitätsprüfungen. Es wird empfohlen, eine Lebensdauer von 1 Tag zu konfigurieren.',
    'FCPO_MODULE_VERSION'                       => 'Version Modul',
    'FCPO_STARTLIMIT_BONICHECK'                 => 'Bonitätsprüfung ab Warenwert',
    'FCPO_HELP_STARTLIMIT_BONICHECK'            => 'Bonitätsprüfung wird nur ausgeführt wenn der Warenwert höher als der hier konfigurierte Wert ist.<br><br>Wenn die Bonitätsprüfung immer durchgeführt werden soll, lassen Sie dieses Feld leer.',
    'FCPO_HELP_ASSIGNCOUNTRIES'                 => 'Wenn keine Länder zugewiesen sind, gilt die Zahlungsart für alle Länder.<br><br>Wenn Länder zugewiesen sind gelten die Zahlungsarten nur für die zugewiesenen Länder.<br><br>Geprüft werden Rechnungsland und Lieferland.',
    'FCPO_HELP_ASSIGNCOUNTRIES_2'               => 'Wenn keine Länder zugewiesen sind, gilt die Zahlungsart für alle Länder.<br><br>Wenn Länder zugewiesen sind gelten die Zahlungsarten nur für die zugewiesenen Länder.<br><br>Geprüft werden Rechnungsland und Lieferland.',
    'FCPO_HELP_ASSIGNCOUNTRIES_3'               => 'Wenn keine Länder zugewiesen sind, gilt die Zahlungsart für alle Länder.<br><br>Wenn Länder zugewiesen sind gelten die Zahlungsarten nur für die zugewiesenen Länder.<br><br>Geprüft werden Rechnungsland und Lieferland.',
    'fcpo_receivable_appointed1'                => 'Reservierung',
    'fcpo_receivable_appointed2'                => 'Forderung (Autorisierung)',
    'fcpo_receivable_capture'                   => 'Forderung (Capture)',
    'fcpo_receivable_debit1'                    => 'Forderung (Debit)',
    'fcpo_receivable_debit2'                    => 'Gutschrift (Debit/Refund)',
    'fcpo_receivable_reminder'                  => 'Mahnungsversand',
    'fcpo_receivable_cancelation'               => 'Rücklastschriftgebühr',
    'fcpo_payment_capture1'                     => 'Einzug',
    'fcpo_payment_capture2'                     => 'Auszahlung',
    'fcpo_payment_paid1'                        => 'Zahlungseingang',
    'fcpo_payment_paid2'                        => 'Rückbelastung',
    'fcpo_payment_underpaid1'                   => 'Unterzahlung',
    'fcpo_payment_underpaid2'                   => 'Rückbelastung',
    'fcpo_payment_debit1'                       => 'Einzug',
    'fcpo_payment_debit2'                       => 'Auszahlung',
    'fcpo_payment_transfer'                     => 'Umbuchung',
    'fcpo_payment'                              => 'Zahlung',
    'FCPO_MAIN_CONFIG_INFOTEXT'                 => 'Sie können für jede Zahlart einzeln konfigurieren, ob diese im Test- oder Livemodus abgewickelt werden soll. Die Einstellung finden Sie unter PAYONE -> Konfiguration -> Zahlungsarten. Wir empfehlen Ihnen nach der initialen Konfiguration sowie bei Konfigurationsänderungen zunächst alle Zahlungsprozesse im Testmodus durchzuführen.',
    'FCPO_BONICHECK_CONFIG_INFOTEXT'            => 'Bitte beachten Sie, dass Sie die nachfolgenden Optionen nur dann nutzen können, wenn Sie das Modul Protect von PAYONE beauftragt haben. Die Nutzung der Bonitätsprüfung und der Adressprüfung zieht variable Kosten pro Vorgang nach sich, die Sie Ihrem Vertrag entnehmen können.',
    'FCPO_BONICHECK_CONFIG_INFOTEXT_SMALL'      => 'Bitte nehmen Sie die Einstellungen für die Bonitätsprüfung mit Bedacht vor. Die Bonitätsprüfung wird nach Eingabe der Personendaten durchgeführt und beeinflusst die Zahlungsarten, die Ihren Kunden im Checkout-Prozess angeboten werden. Die Bonitätsprüfung sollte lediglich bei Zahlungsarten eingesetzt werden, die ein Zahlungsausfallrisiko für Sie nach sich ziehen (z.B. offene Rechnung oder Lastschrift). Sie konfigurieren dies über die Einstellung "Bonitätsindex" in der Konfiguration der jeweiligen Zahlart. Sie sollten in Ihrem Shop außerdem in geeigneter Weise darauf hinweisen, dass Sie Bonitätsprüfungen über die InfoScore Consumer Data GmbH durchführen.',
    'FCPO_INFOTEXT_SET_OPERATIONMODE'           => 'Wird individuell eingestellt unter PAYONE->Konfiguration->Zahlungseinstellungen',
    'FCPO_DEFAULT_BONI'                         => 'Standard Bonitäts-Index',
    'FCPO_HELP_DEFAULT_BONI'                    => 'Diesen Bonitäts-Index erhält der Kunde wenn er sich registriert.<br>Zweck: Wenn der Kunde noch nicht geprüft wurde und die Prüfung erst ab einem bestimmten Warenwert erfolgt ist dies der Bonitäts-Index der bis zur ersten tatsächlichen Prüfung berücksichtigt wird.<br><br>Wenn dieses Feld leer bleibt wird der Oxid-Standard gesetzt ( 1000 ).',
    'FCPO_SETTLE_ACCOUNT'                       => 'Saldenausgleich durchführen',
    'FCPO_HELP_SETTLE_ACCOUNT'                  => 'Deaktivieren sie für Teileinzüge die Checkbox "Saldenausgleich durchführen". Bei der letzten Teillieferung muss diese Option aktiviert werden, um einen Kontenausgleich durchzuführen.',
    'FCPO_CAPTURE_AMOUNT_GREATER_NULL'          => 'Der Betrag für einen Capture muss größer als 0,00 sein!',
    'FCPO_PREAUTHORIZED_AMOUNT'                 => 'Vorautorisierter Betrag',
    'FCPO_SAVEBANKDATA'                         => 'Speicherung der Bankdaten',
    'FCPO_HELP_SAVEBANKDATA'                    => 'Die Bankverbindung wird genau wie im OXID-Standard für die Payone Zahlart Lastschrift verschlüsselt gespeichert und steht beim nächsten Einkauf direkt für den Kunden bereit.',
    'FCPO_PRESAVE_ORDER'                        => 'Bestellung vor Authorisierung speichern',
    'FCPO_REDUCE_STOCK'                         => 'Lagerbestand reduzieren',
    'FCPO_HELP_REDUCE_STOCK'                    => 'Diese Einstellung hat nur Effekt wenn "Bestellung vor Authorisierung speichern" aktiviert ist und man während dem Bestellvorgang zur Bezahlung zu einem externen Bezahldienst ( z.B. Sofortüberweisung, PayPal oder Kreditkarte mit 3D Secure ) weitergeleitet wird. Die Einstellung gibt an ob vor der Umleitung oder erst wenn der Kunde zurückkommt vom Bezahldienst der Lagerbestand reduziert wird.',
    'FCPO_REDUCE_STOCK_BEFORE'                  => 'vor Authorisierung',
    'FCPO_REDUCE_STOCK_AFTER'                   => 'nach Authorisierung',
    'FCPO_HELP_PRESAVE_ORDER'                   => 'Die Bestellung wird schon vor der Authorisierung als unvollständige Bestellung abgespeichert. Dadurch steht die Bestellnummer auch Payone zur Verfügung.',
    'FCPO_VOUCHER'                              => 'Gutschein',
    'FCPO_DISCOUNT'                             => 'Rabatt',
    'FCPO_WRAPPING'                             => "Geschenkverpackung",
    'FCPO_GIFTCARD'                             => "Grußkarte",
    'FCPO_SURCHARGE'                            => 'Aufschlag',
    'FCPO_DEDUCTION'                            => 'Abschlag',
    'FCPO_SHIPPINGCOST'                         => "Versandkosten",
    'FCPO_PRODUCT_CAPTURE'                      => "Abbuchen",
    'FCPO_PRODUCT_AMOUNT'                       => "Menge",
    'FCPO_PRODUCT_PRICE'                        => "Einzelpreis",
    'FCPO_PRODUCT_TITLE'                        => "Produkt",
    'FCPO_COMPLETE_ORDER'                       => "Bestellung abschließen",
    'FCPO_CONSUMERSCORE_MOMENT'                 => "Moment der Bonitätsprüfung",
    'FCPO_CONSUMERSCORE_BEFORE'                 => "Vor Zahlartauswahl",
    'FCPO_CONSUMERSCORE_AFTER'                  => "Nach Zahlartauswahl",
    'FCPO_HELP_CONSUMERSCORE_MOMENT'            => "Hier können Sie definieren wann der Kunde geprüft werden soll. Die Bonitätsprüfung wird nur durchgeführt wenn der Bonitätsindex der Zahlart einen Wert größer 0 entspricht.<br><br>Optionen:<br><br><ul><li>Vor Zahlartauswahl<br>Die Bonität des Kunden wird geprüft, wenn die notwendigen Adress und Namesinformationen vorliegen. Dies geschieht vor der Auswahl der Zahlart. Diese Prüfung findet nicht sichtbar für den Kunden im Hintergrund statt.<br><br></li><li>Nach Zahlartauswahl<br>Bei Auswahl dieser Option erscheint ein Auswahlfeld in dem Sie auswählen können für welche Zahlarten eine anschließende Bonitätsprüfung stattfinden soll.</li></ul>",
    'sFCPOApprovalText_default'                 => "Hiermit erkläre ich mich einverstanden, dass eine Bonitätsprüfung durchgeführt wird.",
    'sFCPODenialText_default'                   => "Die Bonitätsprüfung hat ergeben, dass wir Ihnen die gewählte Zahlart leider nicht anbieten können. Bitte wählen Sie eine andere Zahlart",
    'FCPO_APPROVALTEXT'                         => "Hinweistext Zustimmung Bonit&auml;tspr&uuml;fung",
    'FCPO_DENIALTEXT'                           => "Hinweistext Zahlart abgelehnt",
    'FCPO_ORDERNOTCHECKED'                      => "Der Kunde hat der Bonitäts-Prüfung nicht zugestimmt!",
    'fcpo_admin_config_status_forwarding'       => "Transaktionsstatus - Weiterleitung",
    'fcpo_admin_config_status_mapping'          => "Transaktionsstatus - Mapping",
    'fcpo_admin_config_error_mapping'           => "Fehlermeldungs - Mapping",
    'fcpo_admin_config_add'                     => "Hinzufügen",
    'fcpo_admin_config_delete'                  => "löschen",
    'fcpo_admin_config_delete_confirm'          => "Möchten Sie diesen Eintrag wirklich l&ouml;schen?",
    'fcpo_admin_config_paymenttype'             => "Zahlart",
    'fcpo_admin_config_status_payone'           => "PAYONE Status",
    'fcpo_admin_config_status_shop'             => "Shop - Status",
    'fcpo_admin_config_status'                  => "Status",
    'fcpo_admin_config_url'                     => "URL",
    'fcpo_admin_config_timeout'                 => "Timeout",
    'fcpo_status_appointed'                     => "Zahlungsvorgang initiiert (APPOINTED)",
    'fcpo_status_capture'                       => "Buchung (CAPTURE)",
    'fcpo_status_paid'                          => "Bezahlt (PAID)",
    'fcpo_status_underpaid'                     => "Unterzahlung (UNDERPAID)",
    'fcpo_status_cancelation'                   => "Rücklastschrift (CANCELATION)",
    'fcpo_status_refund'                        => "Rückerstattung (REFUND)",
    'fcpo_status_debit'                         => "Buchung (DEBIT)",
    'fcpo_status_reminder'                      => "Status des Mahnverfahrens (REMINDER)",
    'fcpo_status_vauthorization'                => "Buchung auf Abrechnungskonto (VAUTHORIZATION)",
    'fcpo_status_vsettlement'                   => "Abrechnung eines Abrechnungskontos (VSETTLEMENT)",
    'fcpo_status_transfer'                      => "Umbuchung (TRANSFER)",
    'fcpo_status_invoice'                       => "Erzeugung eines Belegs (INVOICE)",

    'FCPO_CONFIG_GROUP_CONN'                    => "Verbindungs-Einstellungen",
    'FCPO_CONFIG_GROUP_GENERAL'                 => "Allgemein",
    'FCPO_CONFIG_GROUP_DEBITNOTE'               => "Lastschrift",
    'FCPO_CONFIG_GROUP_CREDITCARD'              => "Kreditkarte",
    'FCPO_CONFIG_GROUP_KLARNA'                  => "Klarna StoreIDs",
    'FCPO_CONFIG_GROUP_KLARNA_CAMPAIGNS'        => "Klarna Kampagnen",

    'FCPO_CONFIG_GROUP_PP_EXPRESS_LOGOS'        => "PayPal",
    'FCPO_CONFIG_ADD_PP_EXPRESS_LOGO'           => "Weitere Sprache hinzuf&uuml;gen",

    'FCPO_KLARNA_CAMPAIGNS'                     => "Kampagnen",
    'FCPO_KLARNA_CAMPAIGN_CODE'                 => "Kampagnen-Code",
    'FCPO_KLARNA_CAMPAIGN_TITLE'                => "Titel",
    'FCPO_KLARNA_ADD_CAMPAIGN'                  => "weitere Kampagne hinzuf&uuml;gen",
    'FCPO_KLARNA_DELETE_STORE_ID'               => "Löschen",
    'FCPO_KLARNA_STORE_ID_ADMIN'                => "StoreIDs",
    'FCPO_KLARNA_ADD_STORE_ID'                  => "weitere StoreID hinzufügen",

    'FCPO_CONFIG_DEBIT_BANKDATA'                => "Eingabe der Bankdaten",
    'FCPO_CONFIG_DEBIT_MULTISELECT'             => "Liste der unterstützten Kontoländer.<br>Für Mehrfachmarkierung STRG-Taste gedrückt halten.",
    'FCPO_CONFIG_DEBIT_GER'                     => "Nur bei Deutschen Konten",
    'FCPO_CONFIG_DEBIT_SHOW_OLD_FIELDS'         => "zusätzlich Kontonummer/Bankleitzahl anzeigen",

    'FCPO_CONFIG_DEBIT_MANDATE'                 => "Mandatserteilung",
    'FCPO_CONFIG_DEBIT_MANDATE_TEXT'            => 'Die Mandatserteilung erfolgt mit dem kostenpflichtigen Request "managemandate".<br>Dieser Request beinhaltet einen bankaccountcheck. Allerdings ist hier keine Abfrage<br>der POS-Sperrliste möglich.',
    'FCPO_CONFIG_DEBIT_MANDATE_ACTIVE'          => "Mandatserteilung aktiv",
    'FCPO_CONFIG_DEBIT_MANDATE_DOWNLOAD'        => "Download Mandat als PDF",
    'FCPO_CONFIG_DEBIT_MANDATE_DOWNLOAD_TEXT'   => 'Diese Option kann nur ausgewählt werden, wenn bei PAYONE das Produkt<br>"SEPA-Mandate als PDF" gebucht wurde.',
    'FCPO_CONFIG_DEBIT_MANDATE_DOWNLOAD_ACTIVE' => "Download Mandat als PDF",

    'FCPO_HELP_REFPREFIX'                       => "Bei Requests an PAYONE muss immer eine eindeutige Referenznummer übermittelt werden. Diese wird aus einer laufenden Nummer, normalerweise startend bei 1, generiert. Werden mit den gleichen PAYONE Account-Daten mehrere Shops betrieben ( z.B. Live- und Test-System ) kommt es zu Problemen wenn die Referenznummer schonmal verwendet wurde. Mit verschiedenen Präfixen auf den verschiedenen Systemen kann dies vermieden werden.",
    'FCPO_REFPREFIX'                            => "Referenznummer Präfix ( Optional )",

    'FCPO_MANDATE_PDF'                          => "SEPA Mandat-Pdf",
    'FCPO_MANDATE_DOWNLOAD'                     => "Download",

    'FCPO_EXPORT_CONFIG'                        => "Konfiguration exportieren",

    'FCPO_ASSIGN_COUNTRIES'                     => "L&auml;nder zuordnen",
    'FCPO_COUNTRIES'                            => "L&auml;nder",
    'FCPO_LANGUAGE'                             => "Sprache",
    'FCPO_CURRENCY'                             => "W&auml;hrung",

    'FCPO_HELP_KLARNA_CAMPAIGNS'                => "Die Bestellungen werden bei Klarna nur akzeptiert, wenn die Kombination aus Land, Sprache und W&auml;hrung zusammen passt.<br>Sie m&uuml;ssen diese Kombinationen hier auch hinterlegen und der Kunde bekommt dann nur die passenden Kampagnen angezeigt.",

    'FCPO_PAYPAL_DELADDRESS'                    => 'Rechnungsadresse bei fehlender Lieferadresse als Lieferadresse &uuml;bergeben.',
    'FCPO_HELP_PAYPAL_DELADDRESS'               => 'Wird f&uuml;r den PayPal Verk&auml;uferschutz ben&ouml;tigt.',
    'FCPO_PAYPAL_LOGOS'                         => 'Hier k&ouml;nnen Sie die verwendeten PayPal Express Logos hinterlegen.',
    'FCPO_PAYPAL_LOGOS_ACTIVE'                  => 'Aktiv',
    'FCPO_PAYPAL_LOGOS_LANG'                    => 'Sprache',
    'FCPO_PAYPAL_LOGOS_LOGO'                    => 'Logo',
    'FCPO_PAYPAL_LOGOS_UPLOAD'                  => 'Hochladen',
    'FCPO_PAYPAL_LOGOS_DEFAULT'                 => 'Standard',
    'FCPO_PAYPAL_LOGOS_NOT_EXISTING'            => 'Kein Logo vorhanden!',

    'ORDER_OVERVIEW_FCPO_ELV_BLZ'               => "BLZ",
    'ORDER_OVERVIEW_FCPO_ELV_KTONR'             => "Kontonummer",
    'ORDER_OVERVIEW_FCPO_ELV_IBAN'              => "IBAN",
    'ORDER_OVERVIEW_FCPO_ELV_BIC'               => "BIC",

    'FCPO_CC_CONFIG'                            => 'Feldkonfiguration',
    'FCPO_CC_STANDARD_STYLE'                    => 'Standardstil',
    'FCPO_CC_ERRORS'                            => 'Fehlerausgabe',

    'FCPO_CC_STANDARD_INPUT'                    => 'Eingabe',
    'FCPO_CC_STANDARD_SELECTION'                => 'Auswahl',
    'FCPO_CC_STANDARD_FIELDS'                   => 'Felder',
    'FCPO_CC_STANDARD_IFRAME'                   => 'Iframe',

    'FCPO_CC_ACTIVE'                            => 'Aktiv',
    'FCPO_CC_LANGUAGE'                          => 'Sprache',
    'FCPO_CC_SELECT'                            => 'Auswahl',

    'FCPO_CC_ERRORLANG_DE'                      => 'Deutsch',
    'FCPO_CC_ERRORLANG_EN'                      => 'Englisch',
    'FCPO_CC_CUSTOM_TEMPLATE'                   => 'Benutzerdefinierte Anpassung hosted-Iframe',
    'FCPO_CC_PREVIEW'                           => 'Vorschau',

    'FCPO_CREDITCARD'                           => 'Karte:',
    'FCPO_NUMBER'                               => 'Nummer:',
    'FCPO_CARD_SECURITY_CODE'                   => 'Prüfziffer:',
    'FCPO_VALID_UNTIL'                          => 'Gültig bis:',
    'FCPO_FIRSTNAME'                            => 'Vorname:',
    'FCPO_LASTNAME'                             => 'Nachname:',

    'FCPO_PREVIEW_NOTICE'                       => '&Auml;nderungen sind in der Vorschau erst nach dem Speichern sichtbar!',

    'FCPO_CC_TYPE'                              => "Anfragetyp",
    'FCPO_HELP_CC_TYPE'                         => "hosted-Iframe: Die Eingabefelder werden in einem von Payone gelieferten Iframe angezeigt ( PCI DSS 3.0 konform ).<br>AJAX - Die Kreditkarten-Informationen werden mittels AJAX an Payone gesendet.",

    'FCPO_CC_HEADER_TYPE'                       => 'Typ',
    'FCPO_CC_HEADER_DIGIT_COUNT'                => 'Anzahl<br>Zeichen',
    'FCPO_CC_HEADER_DIGIT_MAX'                  => 'Zeichen<br>Max',
    'FCPO_CC_HEADER_IFRAME'                     => 'Iframe',
    'FCPO_CC_HEADER_WIDTH'                      => 'Breite',
    'FCPO_CC_HEADER_HEIGHT'                     => 'H&ouml;he',
    'FCPO_CC_HEADER_STYLE'                      => 'Stil',
    'FCPO_CC_HEADER_CSS'                        => 'CSS',

    'FCPO_CC_ROW_CC_Number'                     => 'Kreditkartennummer',
    'FCPO_CC_ROW_CC_CVC'                        => 'Kartenpr&uuml;fziffer',
    'FCPO_CC_ROW_CC_Month'                      => 'G&uuml;ltigkeitsmonat',
    'FCPO_CC_ROW_CC_Year'                       => 'G&uuml;ltigkeitsjahr',

    'FCPO_CC_TYPE_NUMERIC'                      => 'Numerisch',
    'FCPO_CC_TYPE_PASSWORD'                     => 'Passwort',
    'FCPO_CC_TYPE_TEXT'                         => 'Text',

    'FCPO_CC_IFRAME_STANDARD'                   => 'Standard',
    'FCPO_CC_IFRAME_CUSTOM'                     => 'Benutzerdefiniert',

    'FCPO_CONFIG_GROUP_PAYOLUTION'              => 'Payolution',
    'FCPO_PAYOLUTION_B2BMODE'                   => 'Payolution im B2B-Modus betreiben',
    'FCPO_HELP_PAYOLUTION_B2BMODE'              => 'Bei aktiviertem B2B Modus und vom Benutzer angegebenem Firmennamen wird die USt-IdNr. abgefragt. Bei B2C Kunden wird stattdessen das Geburtsdatum abgefragt.',
    'FCPO_PAYOLUTION_COMPANY'                   => 'Firmenname',
    'FCPO_HELP_PAYOLUTION_COMPANY'              => 'Der hier eingegebene Firmenname wird beim einblenden des Einwilligungstextes verwendet.',
    'FCPO_PAYOLUTION_MODE'                      => 'Payolution im Testmodus betreiben',
    'FCPO_PAYOLUTION_AUTH_USER'                 => 'Payolution Benutzername',
    'FCPO_HELP_PAYOLUTION_AUTH_USER'            => 'Benutzername, der benötigt wird um Vertragsinhalte (z. B. Ratenkauf) über einen sicheren Kanalabzufragen',
    'FCPO_PAYOLUTION_AUTH_SECRET'               => 'Payolution Passwort',
    'FCPO_HELP_PAYOLUTION_AUTH_SECRET'          => 'Passwort, welches benötigt wird um Vertragsinhalte (z. B. Ratenkauf) über einen sicheren Kanalabzufragen.',
    'FCPO_SHOW_SOFO_IBAN_FIELDS'                => 'IBAN/BIC - Felder anzeigen',
    'FCPO_CC_USE_CVC'                           => 'Kartenprüfziffer als Pflichtfeld abfragen',
    'fcpo_admin_config_payone_error_message'    => 'Payone Fehlermeldung',
    'fcpo_admin_config_status_language'         => 'Sprache',
    'fcpo_admin_config_status_own_error_message'=> 'Eigene Fehlermeldung',
    'FCPO_CONFIG_DEBIT_BIC_MANDATORY'           => 'BIC abfragen',
    'fcpo_admin_config_error_iframe_mapping'    => 'Eigene Fehlermeldungen für Hosted iFrame',
    'fcpo_admin_config_payone_error_code'       => 'Fehlerkennung',
    'FCPO_CONFIG_GROUP_RATEPAY'                 => 'RatePay',
    'FCPO_PROFILES_RATEPAY'                     => 'RatePay Profile',
    'FCPO_RATEPAY_DELETE_PROFILE'               => 'Profil löschen',
    'FCPO_RATEPAY_ADD_PROFILE'                  => 'Profil hinzufügen',
    'FCPO_PROFILES_RATEPAY_CURRENCY'            => 'Währung',
    'FCPO_PROFILES_RATEPAY_PAYMENT'             => 'RatePay Zahlungsmethode',
    'FCPO_RATEPAY_PROFILE_TOGGLE_DETAILS'       => 'Konfigurationsdetails dieses Profils ein-/ausblenden',
    'FCPO_RATEPAY_PROFILE_DETAILS_FOR_ID'       => 'Profilkonfiguration für ShopID',
    'FCPO_RATEPAY_GENERAL_SETTINGS'             => 'RatePay Einstellungen',
    'FCPO_RATEPAY_B2BMODE'                      => 'RatePay im B2B-Modus betreiben',
    'FCPO_HELP_RATEPAY_B2BMODE'                 => 'Bei aktiviertem B2B Modus und vom Benutzer angegebenem Firmennamen wird die USt-IdNr. abgefragt. Bei B2C Kunden wird stattdessen das Geburtsdatum abgefragt.',
    'FCPO_MALUSHANDLING'                        => 'Personstatus Abzug Handling',
    'FCPO_PERSONSTATUS'                        	=> 'Personstatus',
    'FCPO_MALUS'                        		=> 'Abzug',
    'FCPO_MALUS_PPB'                            => 'Person kann f&uuml;r diese Adresse best&auml;tigt werden',
    'FCPO_MALUS_PHB'                            => 'Nachname bekannt',
    'FCPO_MALUS_PAB'                            => 'Vor- und Nachname unbekannt',
    'FCPO_MALUS_PKI'                            => 'Mehrdeutigkeit in Name und Adresse',
    'FCPO_MALUS_PNZ'                            => 'Kann nicht geliefert werden',
    'FCPO_MALUS_PPV'                            => 'Person verstorben',
    'FCPO_MALUS_PPF'                            => 'Details der postalischen Adresse sind inkorrekt',
    'FCPO_HELP_MALUS'                           => 'Die konfigurierten Abz&uuml;ge werden entsprechend dem R&uuml;ckgabewert der Adresspr&uuml;fung vom Bonit&auml;ts-Wert des Kunden abgezogen. Der Bonit&auml;ts-Wert kann 0 hierbei nicht unterschreiten.',
    'FCPO_SHADOW_BASKET'                        => 'Schatten-Warenkorb',
    'FCPO_POSSIBLE_FRAUD_DETECTED'              => 'Ein möglicher Betrugsversuch wurde entdeckt. Bitte prüfen Sie diesen Warenkorb gegen die Bestellung.',
    'FCPO_GENERAL_SHADOWBASKET_BRUTTO'          => 'Bruttosumme des Prüfwarenkorbs',
    'FCPO_GENERAL_SHADOWBASKET_NETTO'           => 'Nettosumme des Prüfwarenkorbs',
    'FCPO_CONFIG_GROUP_PAYDIREKT'               => 'Paydirekt',
    'FCPO_PAYDIREKT_OVERCAPTURE'                => 'Overcapture erlauben?',
    'FCPO_HELP_PAYDIREKT_OVERCAPTURE'           => 'Erlaubt den Einzug eines um 10% höheren Betrags basierend auf der vorautorisierten Summe.<br><b>Bitte aktivieren Sie diese Option nur in Absprache mit Paydirekt!</b>',
);

/*
[{ oxmultilang ident="GENERAL_YOUWANTTODELETE" }]
*/
