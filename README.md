# HI PDF Generator plugin for Craft CMS 3.x

This plugin allows you to generate PDFs from your Craft CMS 3.x templates.

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later, the typeset.sh phar file and the private typeset.sh composer
package. Create a new ```PUBLIC_ID``` and ```TOKEN``` for each project on [typeset.sh](https://typeset.sh/en/home).

## Update composer.json

Add the following to your composer.json file:

```
 "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/hi-digital/pdf-generator"
    },
    {
      "type": "composer",
      "url": "https://packages.typeset.sh"
    }
  ]
```

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project. Configure composer to get access to the private typeset.sh composer
   package. You must do this on the server where the package is used too.
   ```bash
   composer config -g http-basic.packages.typeset.sh "{PUBLIC_ID}" "{TOKEN}"
   ```

2. Create a new github access token or use a existing to access the private package. To manage your github access tokens
   go
   to [https://github.com/settings/tokens](https://github.com/settings/tokens). Or skip
   this step and follow the bash instructions on step 3.

3. Tell Composer to load the plugin

   ```bash
   composer require hidigital/hi-pdf-generator
   ```

2. In the Control Panel, go to Settings → Plugins and click the “Install” button for HI PDF Generator.

## HI PDF Generator Overview

PDFs can be created and displayed directly in the template or saved as asset with a predefined path and filename.

### Supported CSS Styles

Typeset.sh supports CSS3 and all the modern stuff like flex and grid layout! Check the
[typeset.sh documentation](https://typeset.sh/en/documentation/css) for all supported css styles.
If you need some good examples go to the [typeset.sh demo page](https://typeset.sh/en/demo).

## Configuring HI PDF Generator

Go to the plugin settings and select the craft asset volume where the PDFs should be saved. If you want to define a sub
folder for the PDFs, you can do this by setting the path in the sub folder field.

## Using HI PDF Generator

### Inline PDFs in templates

The pdf markup will be returned as string. Use the raw filter to display the pdf in the template. Otherwise, the PDF
will not be displayed correctly and a pdf error will occur.

```bash
{{ craft.hiPdf.generatePdf({
     template: '_templates/printmaker/pdfTemplate',
     filename: 'Projektauswahl' ~ ' - ' ~ siteName,
     title: 'Projektauswahl',
     destination: 'inline',
     variables: {
         entries: selectedProjects,
     }
 })|raw }}
```

### As file saved in the asset volume

The file path gets returned as string.

```bash
 {% set fileUrl = craft.hiPdf.generatePdf({
     template: '_templates/printmaker/pdfTemplate',
     filename: entry.title,
     title: entry.title ,
     destination: 'file',
     variables: {
         entry,
     },
 }) %}   
```

Display a download button for the file

````html
<a href="{{ file }}" download>Download</a>
````

or redirect to the file path.

```bash
{% redirect file %}
```

## This mess doesn't work at all?

If you have any problems with the plugin, don't hesitate to check the code by yourself. The plugin is as simple as it
can.

## HI PDF Generator Roadmap

* Release a version for craft 4
* Add some more cool stuff to the plugin

Brought to you by [HI Schweiz](https://github.com/hi-digital/)
