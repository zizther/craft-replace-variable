# Replace Variable plugin for Craft CMS 3.x

Replace general or config variables, and global fields

![Screenshot](resources/img/plugin-logo.png)

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require zizther/replace-variable

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Replace Variable.

## Replace Variable Overview

Can match general or config variables, and global fields
For example:
* {siteName}
* {config.general.custom.variableName}
* {config.customConfigFile.variableName}
* {globalHandle.fieldHandle}


## Using Replace Variable

Filter
`{{ 'something goes here {globalHandle.fieldHandle}' | rv }}`

Function
`{% set this = rv('something goes here {globalHandle.fieldHandle}') %}`
