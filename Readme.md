# TYPO3 Extension Simplepie RSS

[![Latest Stable Version](https://img.shields.io/packagist/v/svenjuergens/simplepie-rss.svg)](https://packagist.org/packages/svenjuergens/simplepie-rss) [![Packagist](https://img.shields.io/packagist/dt/svenjuergens/simplepie-rss.svg)](https://packagist.org/packages/svenjuergens/simplepie-rss)

Display RSS with help of http://simplepie.org/.

## Installation

Simply install the extension with Extension Manager or Composer
`composer require svenjuergens/simplepie-rss`

## Configuration
add TypoScript

## Use
add it on your site as ContentElement, paste path to RSS feed an that a limit.


### new with 2.1.0
added a Template Layout field in flexform

you can fill it in page tsconfig like that:
```typo3_typoscript
#################
#### TCEFORM ####
#################
TCEFORM {
  tt_content {
    pi_flexform {
      simplepierss_simplepierssviewer {
        sDEF {
          settings\.templateLayout {
            addItems.secondLayout = my second Layout
            addItems.thirdLayout = my third Layout
          }
        }
      }
    }
  }
}
```

in TypoScript overwrite the template file like

```typo3_typoscript
plugin.tx_simplepierss.view {
  layoutRootPaths {
    10 = EXT:mysitePackage/Resources/Private/ExtensionsOverwrite/simplepie_rss/Resources/Layouts/
  }
  templateRootPaths {
    10 = EXT:mysitePackage/Resources/Private/ExtensionsOverwrite/simplepie_rss/Resources/Templates/
  }
}
```

and use in ask for your new templateLayout like:

```html
<f:if condition="{settings.templateLayout} == 'secondLayout'">
     ....
</f:if>
```
