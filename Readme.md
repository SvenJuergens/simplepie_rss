# TYPO3 Extension SimplePie RSS

[![Latest Stable Version](https://img.shields.io/packagist/v/svenjuergens/simplepie-rss.svg)](https://packagist.org/packages/svenjuergens/simplepie-rss) [![Packagist](https://img.shields.io/packagist/dt/svenjuergens/simplepie-rss.svg)](https://packagist.org/packages/svenjuergens/simplepie-rss)

Display RSS feeds with the help of [SimplePie](http://simplepie.org/) in TYPO3.

## Requirements

- TYPO3 v13.4 LTS or v14
- PHP 8.2+

## Installation

```bash
composer require svenjuergens/simplepie-rss
```

## Configuration

This extension ships a TYPO3 **Site Set** (`svenjuergens/simplepie-rss`).
Add it as dependency in your site configuration:

```yaml
# config/sites/<identifier>/config.yaml
dependencies:
  - svenjuergens/simplepie-rss
```

Then add the content element "SimplePie RSS" via the page module wizard and
configure the feed URL, item limit and cache lifetime through the FlexForm.

## Customising templates

Override the template paths via TypoScript:

```typoscript
plugin.tx_simplepierss.view {
  layoutRootPaths.10 = EXT:mysitepackage/Resources/Private/ExtensionsOverwrite/simplepie_rss/Layouts/
  templateRootPaths.10 = EXT:mysitepackage/Resources/Private/ExtensionsOverwrite/simplepie_rss/Templates/
}
```

## Multiple template layouts

The FlexForm exposes a `settings.templateLayout` field. You can populate the
dropdown via Page TSconfig:

```typoscript
TCEFORM.tt_content.pi_flexform.simplepierss_simplepierssviewer.sDEF {
  settings\.templateLayout {
    addItems.secondLayout = my second Layout
    addItems.thirdLayout = my third Layout
  }
}
```

In your Fluid template branch on the selected layout:

```html
<f:if condition="{settings.templateLayout} == 'secondLayout'">
    ...
</f:if>
```
