# HI PDF Generator plugin for Craft CMS 3.x

This plugin allows you to generate PDFs from your Craft CMS 3.x templates.

![Screenshot](resources/img/plugin-logo.png)

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later, the typeset.sh phar file and the private typeset.sh composer package. 
To install the private package follow the instructions on the [typeset.sh php doc](https://typeset.sh/en/documentation/php).
The following step must be performed on the server where the plugin should get installed.

```bash
composer config -g http-basic.packages.typeset.sh "{PUBLIC_ID}" "{TOKEN}"
```

Create a new ```PUBLIC_ID``` and ```TOKEN``` for each project on [typeset.sh](https://typeset.sh/en/home).

## Update composer.json
Add the following to your composer.json file:

```
"repositories" : [
    {
        "type": "composer",
        "url": "https://packages.typeset.sh"
    }
]
```

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require /hi-pdf-generator

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for HI PDF Generator.

## HI PDF Generator Overview

-Insert text here-

## Configuring HI PDF Generator

-Insert text here-

## Using HI PDF Generator

-Insert text here-

## HI PDF Generator Roadmap

Some things to do, and ideas for potential features:

* Release it

Brought to you by [HI Digital](https://bitbucket.org/hi-schweiz/)
