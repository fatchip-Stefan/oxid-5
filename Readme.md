# PAYONE Payment for Oxid
![license LGPL](https://img.shields.io/badge/license-LGPL-blue.svg)
[![GitHub issues](https://img.shields.io/github/issues/PAYONE-GmbH/oxid-5.svg)](https://github.com/PAYONE-GmbH/oxid-5/issues)

# PAYMENT FOR YOUR OXID-SHOP 
The Payone-Payment-Module is already certified by OXID to guarantee faultless code quality and correct operation, but we are willing to do an even better job. The community here on Github is a great help for that and we are happy about your participation. Take a look at our released version and send us commits or other feedback to take care for the best possible solution.

## Important functions for OXID
*	Seamless integration in the checkout processes
*	Centralised administration within Oxid
*	The offered portfolio of payment options can be controlled depending on the consumer's credit rating
*	The payment extension is compatible with all OXID eShop editions of version 4: Community, Professional and Enterprise edition
*	Supports simplified PCI DSS conformity in accordance with SAQ A
*	Find all currently supported payment methods on www.payone.com/oxid

## More information
More information about OXID on https://www.payone.com/oxid or https://www.fatchip.de/Plugins/OXID-eShop/OXID-PAYONE-Connector.html<br>
Videoguide: Installation and configuration (German): https://www.youtube.com/playlist?list=PLlzKa20PSzulrW3Yg7XmP3rkvDywe-DMe 

## Requirements
Installed OXID eShop > v4.7.0

## Installation
1.	Extract the module-package.
2.	Copy the content of the folder "copy_this" into your shop root-folder (where config.inc.php lies).
3.	Go to Extensions->Modules, select the "PAYONE Payment for Oxid eShop" extension and press the "Activate" Button in the "Overview" tab.
4.	Next you need to deposit a transaction url in the PAYONE-Webinterface at Konfiguration -> Zahlungsportale -> YOUR_PORTAL -> Erweitert -> TransactionStatus URL. The URL has to look like this: http://->YOUR_SHOP<-/modules/fcPayOne/status.php
5.	Empty "tmp" folder.
6. 	There is a new menu item in the OXID-Interface named PAYONE. Here you can set your merchant connect data.

## Update
If you are updating from Version 1.52 or lower:
1.	Deactivate the "Payone FinanceGate"
2.	Delete the following files/folder from your server:

#####Folder application/contollers/admin:
* fcpayone_admin.php
* fcpayone_apilog.php
* fcpayone_apilog_list.php
* fcpayone_apilog_main.php
* fcpayone_boni.php
* fcpayone_boni_list.php
* fcpayone_boni_main.php
* fcpayone_common.php
* fcpayone_list.php
* fcpayone_log.php
* fcpayone_log_list.php
* fcpayone_main.php
* fcpayone_order.php
* fcpayone_protocol.php
* fcpayone_status_forwarding.php
* fcpayone_status_mapping.php
* fcpayone_support.php
* fcpayone_support_list.php
* fcpayone_support_main.php

#####Folder application/contollers/admin/inc:
* fcpayone_main.inc.php

#####Folder application/models:
* fcpoconfig.php
* fcporequest.php
* fcporequestlog.php
* fcpotransactionstatus.php

Folder application/views/admin/de:
* fcPayOne_lang.php

#####Folder application/views/admin/en:
* fcPayOne_lang.php

#####Folder application/views/admin/tpl:
* fcpayone.tpl
* fcpayone_apilog.tpl
* fcpayone_apilog_list.tpl
* fcpayone_apilog_main.tpl
* fcpayone_boni.tpl
* fcpayone_boni_list.tpl
* fcpayone_boni_main.tpl
* fcpayone_cc_preview.tpl
* fcpayone_list.tpl
* fcpayone_log.tpl
* fcpayone_log_list.tpl
* fcpayone_main.tpl
* fcpayone_order.tpl
* fcpayone_protocol.tpl
* fcpayone_status_forwarding.tpl
* fcpayone_status_mapping.tpl

#####Folder application/views/admin/tpl/popups:
* fcpayone_main.tpl

#####Folder modules/fcPayOne:
* completely!

#####Folder out\admin\img:
* certified_extension_100px.png
* logoclaim.gif

3.	Copy the content of "copy this" into your shop root-folder (where config.inc.php lies).
4.	Activate the "PAYONE Payment for Oxid eShop"

If you updating from version 2.x or higher:
1.	Deactivate the "PAYONE Payment for Oxid eShop"
2.	Copy the content of "copy this" into your shop root-folder (where config.inc.php lies).
3.	Activate the "PAYONE Payment for Oxid eShop"

## Notice
When you are using the creditcard iframe payment-method there is no transaction-id ( txid ) in the moment where the order is created. The transaction-id will be filled in seconds later, when the first "TransactionStatus" from Payone comes in. So when using pixi or another ERP where the transaction-id is needed, make sure to export the order only when the transaction-id is already there.

## About PAYONE
PAYONE provides business solutions for comprehensive automated processing of all payments in e-commerce. The payment service provider is part of the Sparkassen-Finanzgruppe and authorised as a credit institution by the German Federal Financial Supervisory Authority. PAYONE's service portfolio includes acceptance and processing for national and international payment methods, plus all payment services. Standardised interfaces and extensions allow simple integration into existing e-commerce and IT-systems whilst maintaining strict security standards.<br>
PAYONE ranks amongst the 50 fastest-growing technology companies in Germany and serves over 4.00 e-commerce clients from a variety of sectors and countries, including well-known companies such as Immonet, Globetrotter Ausrüstung, HD PLUS, Fujitsu, Zalando, Hawesko, Sony Music and Hallhuber. PAYONE employs a workforce of over 150.
