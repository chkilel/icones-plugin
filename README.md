# Ic么nes Form Widget  馃獎 馃帀 馃帄

[馃摉 **Release Notes**]

>鈩癸笍 **Plugin version 3 is compatible only with Octobercms 3 (New Ajax framwork and the backend upgrade to bootstrap 5), please use version 2 of the plugin for OCMS 1 and 2.**
> **You cannot upgrade from version `1.*/2.*` to `3.*`**

---
<br />
Access thousands of SVG icons as a backend form widget.

One library, over **133,000** vector icons, Modern replacement for icon fonts. Fast, easy to use.

- **128+** icon sets powered by [Iconify](https://iconify.design/)
- Browse the icons on [Iconify](https://icon-sets.iconify.design/) or on [Ic么nes](https://icones.netlify.app/)

![Ic么nes FormWidget](https://res.cloudinary.com/chkilel/image/upload/v1629852348/icones-plugin/README/IconesFinder-demo_kyztau.gif)

## Advantages of this form widget
Every time I use icon fonts, end users don't find them appealing, or even they don't find what they want.
Styling was challenging, with SVG icons you can apply classes and style them as you want.

There are many excellent icon sets available, some are available only as fonts and almost all of them load entire set even if you are displaying just few icons.

Ic么nes combines all those icon sets (more than 100) that makes it possible to use many icons from different icon sets on same page or in same application using one form widget.

Ic么nes combines pixel perfect rendering of SVG with ease of use of glyph fonts, while offering more choice than any glyph font.

You don't need to load any dependency at all.

You can use Font Awesome, Material Design Icons, Unicons, Dashicons, Emoji, ... and many other icon sets on same page or application using one form widget.

<br />

**TOC**

- [Ic么nes Form Widget  馃獎 馃帀 馃帄](#ic么nes-form-widget----)
  - [Advantages of this form widget](#advantages-of-this-form-widget)
  - [Upgrading from version `1.*` to `2.*` 馃毃](#upgrading-from-version-1-to-2-)
  - [Installation](#installation)
    - [Composer](#composer)
  - [How to use](#how-to-use)
  - [Field Options](#field-options)
    - [Form field showName option](#form-field-showname-option)
    - [Form field showIconSetName option](#form-field-showiconsetname-option)
    - [Form field size option](#form-field-size-option)
    - [Form field iconSets option](#form-field-iconsets-option)
- [Settings](#settings)
  - [Permissions](#permissions)
  - [Usage in Twig template](#usage-in-twig-template)
    - [Twig filter options](#twig-filter-options)
      - [Options detail](#options-detail)
  - [Usage in PHP](#usage-in-php)
  - [Usage in Backend List](#usage-in-backend-list)


## Upgrading from version `1.*` to `2.*` 馃毃

Ic么nes Form Widget 2.0 depend on version 2 of [Iconify Icon Sets](https://github.com/iconify/icon-sets).
If you are upgrading from version 1.* , you need to upgrade your Iconify Icon Sets to version 2.* also.
For that, run the following command in the root of your project:

```bash
composer require chkilel/icones-plugin --with-all-dependencies
# --with-all-dependencies will upgrade all dependencies also
```
then migrate the database:

```bash
php artisan october:up
```

## Installation
Simply install the plugin from the marketplace, if you run into problems because of composer dependencies, please use composer.

### Composer
If you prefer Composer or you run into problems when installing from the marketplace, run the following commands in the project鈥檚 root directory:
```bash
composer require chkilel/icones-plugin:^2.0.0 # For Octobercms 1 and 2
# 鈩癸笍 OR
composer require chkilel/icones-plugin:^3.0.0 # For Octobercms 3
# Then
php artisan october:up
```

## How to use
Icones registers a new backend form widget named `iconesfinder`.

You can access the Form Widget in your model's fields.yaml file or as **Custom Page Fields** for [static pages](https://github.com/rainlab/pages-plugin/blob/master/docs/documentation.md#custom-page-fields) by using `iconesfinder` as the field type.

- Usage example via yaml config:

```yaml
    my_awesome_icon:
        label: My super awesome icon
        type: iconesfinder
        showName: true
        showIconSetName: true
        size: large
        placeholder: -- Choose your icon --
        iconSets: # Icon sets to choose from, the icon sets must be enabled in the settings area
            - mdi # Material Design Icons
            - ant-design # Ant Design Icons
            - emojione # Emoji One (Colored)
            - logos # SVG Logos
```

- Usage example via Custom page fields for [Pages plugin](https://github.com/rainlab/pages-plugin/blob/master/docs/documentation.md#custom-page-fields):

```
    {variable   type="iconesfinder"
                name="my_awesome_icon"
                label="My awesome icon"
                showName="true"
                showIconSetName="true"
                size="large"
                iconSets="mdi|ant-design|emojione|logos|pages"
                placeholder="My placeholder"
                tab="My tab name"
                placement="secondary"
    }{/variable}
```

>
> Please pay attention to the spaces for **Custom Page Fields**, there is no space between
> the **option**, the **equal sign** `=` and the **value**

## Field Options
For each field you can specify these options:

Option | Description| Default if not set
------------- | ------------- | --------------
**showName** |**Optional**: Show the name of the **icon** beside the SVG in the field. Options: true, false.| true
**showIconSetName** |**Optional**: Show the name of the **icon set** beside the SVG in the field. Options: true, false.| true
**iconSets** |**Optional**: (abbreviated name of the icon set). Define the icon sets to choose from, the icon sets must be enable in the setting area. see [available icon sets](#form-field-iconSets-option) bellow for available options. *If it's not set, the user can choose from all enabled icon sets.*| All enabled icon sets in the settings area
**size** | **Optional**: Specifies the field size. Options: small, large.| Normal size
**placeholder** |**Optional**: The text to show when nothing is selected.| -- Choose an icon --  *Translated string*.


### Form field showName option

Show the name of the icon in the field.

Value | Appearance
------------- | -------------
true | ![showName set to true](https://res.cloudinary.com/chkilel/image/upload/v1629581583/icones-plugin/README/with-name_qppe6l.jpg)
false | ![showName set to false](https://res.cloudinary.com/chkilel/image/upload/v1629581582/icones-plugin/README/without-name_kmtuz8.jpg)


### Form field showIconSetName option

Show the name of the icon set in the field.

Value | Appearance
------------- | -------------
true | ![showIconSetName set to true](https://res.cloudinary.com/chkilel/image/upload/v1629581583/icones-plugin/README/with-icon-set-name_dvwn0g.jpg)
false | ![showIconSetName set to false](https://res.cloudinary.com/chkilel/image/upload/v1629581580/icones-plugin/README/without-icon-set-name_eynpzq.jpg)


### Form field size option

Set the size of the field.

Value | Appearance
------------- | -------------
small | ![small field size](https://res.cloudinary.com/chkilel/image/upload/v1629581582/icones-plugin/README/small_afhgob.jpg)
(Defaul if not set) | ![narmal field size](https://res.cloudinary.com/chkilel/image/upload/v1629581581/icones-plugin/README/normal_jvmooy.jpg)
large | ![large field size](https://res.cloudinary.com/chkilel/image/upload/v1629581581/icones-plugin/README/large_knqwd6.jpg)



### Form field iconSets option

For `iconSets` option, you can choose one or more from the possible values below, if not set, the user can choose from all enabled icon sets in the backend settings:

Possible values |Icon set real name |Total icons
------------- | ------------- | --------------:
academicons|Academicons|149
akar-icons|Akar Icons|398
ant-design|Ant Design Icons|789
arcticons|Arcticons|4304
bi|Bootstrap Icons|1668
bpmn|BPMN|112
brandico|Brandico|45
bx|BoxIcons|797
bxl|BoxIcons Logo|153
bxs|BoxIcons Solid|650
bytesize|Bytesize Icons|101
carbon|Carbon|1798
charm|Charm Icons|255
ci|coolicons|412
cib|CoreUI Brands|830
cif|CoreUI Flags|199
cil|CoreUI Free|554
circle-flags|Circle Flags|349
clarity|Clarity|1103
codicon|Codicons|413
cryptocurrency|Cryptocurrency Icons|471
dashicons|Dashicons|342
ei|Evil Icons|70
el|Elusive Icons|304
emojione|Emoji One (Colored)|1834
emojione-monotone|Emoji One (Monotone)|1403
emojione-v1|Emoji One (v1)|1262
entypo|Entypo+|321
entypo-social|Entypo+ Social|76
eos-icons|EOS Icons|253
ep|Element Plus|283
et|Elegant|100
eva|Eva Icons|490
fa|Font Awesome 4|678
fa-brands|Font Awesome 5 Brands|457
fa-regular|Font Awesome 5 Regular|151
fa-solid|Font Awesome 5 Solid|1001
fa6-brands|Font Awesome Brands|462
fa6-regular|Font Awesome Regular|162
fa6-solid|Font Awesome Solid|1387
fad|FontAudio|155
fe|Feather Icon|255
feather|Feather Icons|286
file-icons|File Icons|930
flag|Flag Icons|530
flagpack|Flagpack|255
flat-color-icons|Flat Color Icons|329
flat-ui|Flat UI Icons|100
fluent|Fluent UI System Icons|11468
fontelico|Fontelico|34
fontisto|Fontisto|615
foundation|Foundation|283
fxemoji|Firefox OS Emoji|1034
gala|Gala Icons|51
geo|GeoGlyphs|30
gg|css.gg|704
gis|Font-GIS|344
gridicons|Gridicons|201
grommet-icons|Grommet Icons|614
healthicons|Health Icons|1731
heroicons-outline|HeroIcons Outline|230
heroicons-solid|HeroIcons Solid|230
ic|Google Material Icons|10945
icomoon-free|IcoMoon Free|491
icon-park|IconPark|2657
icon-park-outline|IconPark Outline|2657
icon-park-solid|IconPark Solid|1937
icon-park-twotone|IconPark TwoTone|1915
iconoir|Iconoir|1151
icons8|Icons8 Windows 10 Icons|234
il|Icalicons|84
ion|IonIcons|1332
iwwa|Innowatio Font|105
jam|Jam Icons|940
la|Line Awesome|1544
line-md|Material Line Icons|298
logos|SVG Logos|1438
ls|Ligature Symbols|348
lucide|Lucide|625
majesticons|Majesticons|760
maki|Maki|208
map|Map Icons|167
material-symbols|Material Symbols|8001
mdi|Material Design Icons|7001
mdi-light|Material Design Light|267
medical-icon|Medical Icons|144
mi|Mono Icons|180
mono-icons|Mono Icons|180
nimbus|Nimbus|135
noto|Noto Emoji|3418
noto-v1|Noto Emoji (v1)|2157
octicon|Octicons|506
oi|Open Iconic|223
ooui|OOUI|322
openmoji|OpenMoji|4053
pepicons|Pepicons|410
ph|Phosphor|6282
pixelarticons|Pixelarticons|474
prime|Prime Icons|238
ps|PrestaShop Icons|479
quill|Quill Icons|140
radix-icons|Radix Icons|318
raphael|Raphael|266
ri|Remix Icon|2271
si-glyph|SmartIcons Glyph|799
simple-icons|Simple Icons|2263
simple-line-icons|Simple line icons|189
subway|Subway Icon Set|306
system-uicons|System UIcons|430
tabler|Tabler Icons|2016
teenyicons|Teenyicons|1200
topcoat|TopCoat Icons|89
twemoji|Twitter Emoji|3668
typcn|Typicons|336
uil|Unicons|1206
uim|Unicons Monochrome|296
uis|Unicons Solid|189
uit|Unicons Thin Line|214
uiw|uiw icons|214
vaadin|Vaadin Icons|636
vs|Vesper Icons|159
vscode-icons|VSCode Icons|1139
websymbol|Web Symbols Liga|85
whh|WebHostingHub Glyphs|2125
wi|Weather Icons|219
wpf|Icons8 Windows 8 Icons|200
zmdi|Material Design Iconic Font|777
zondicons|Zondicons|297
<span>| **Total icons for all icon sets**|**133 348**


# Settings
After installation, go to `Backend > Settings >icones` or type **icones** in the search field.

Initially, none of the icon sets is installed, you need to install the icon sets you want to allow the end user to use.

![Setting page](https://res.cloudinary.com/chkilel/image/upload/v1629581589/icones-plugin/README/setting-page_s3nxlc.png)


- You can enable installed icon sets:

![Disable icon set](https://res.cloudinary.com/chkilel/image/upload/v1629581580/icones-plugin/README/setting-disabled_inqv8q.png)


- Disable enabled ones:

![Enable icon set](https://res.cloudinary.com/chkilel/image/upload/v1629581580/icones-plugin/README/setting-enabled_wbst2v.png)


- Or completely delete an icon set.


> Please note that to delete an icon set, you need to disable it first.

 ![Disabled icon sets cannot be deleted](https://res.cloudinary.com/chkilel/image/upload/v1629581586/icones-plugin/README/setting-cannot-delete-enabled_qeuqc5.png)


## Permissions

The plugin registers two backend permissions to manage Ic么nes.
- **Access Ic么nes settings** : allow the user to enable and/or disable icon sets.
- **Manage icon sets installation end deletion** : allow the user to install and/or delete icon sets.

![Ic么ne permissions](https://res.cloudinary.com/chkilel/image/upload/v1629581581/icones-plugin/README/permissions_hgnil9.png)



## Usage in Twig template

Ic么nes plugin register a new filter `iconify()` to use in your templates, the filter generate an SVG icon.

### Twig filter options

`iconify` filter optionally accept an object with `key:value` paires to generate the SVG.
It will use default if used as `{{ my_var|iconify }}` without providing any parameter,
The options to use are listed below.

Examples of usages:
```twig
    {{ my_var|iconify }} {# Default options from stored value #}


    {{ my_var|iconify({'height': '24px', 'class':'w-10 h-10' }) }}


    {{ my_var | iconify({
                    'height' : '24px',
                    'width' : '24px',
                    'align' : 'center,middle,meet',
                    'color' : '#ff8000',
                    'rotate' : '90deg', // same as "'rotate' =>  1" or "'rotate' => '25%'"
                    'flip' : 'horizontal', // same as "'hFlip' => true"
                    'box' : true
                 });
       }}


   {#  Height and width will be set from viewBox attribute, using original icon's dimensions#}
   {{ my_var | iconify({ 'height' => 'auto'}) }}

```
#### Options detail
Key | Description | Default | Options
--- | --- | --- | ---
class | The css class to apply to the svg tag |  | CSS class to apply
width, height | Dimensions of icon. If only one attribute is set, another attribute will be set using icon's width/height ratio. If value is "auto", icon's original dimensions will be used. If both width and height are not set, height defaults to "1em". | "1em" | String such as "1em", "24px" or number.
hFlip, vFlip | Flip icon horizontally and/or vertically. | false | true or "true" or "1" (string or boolean),
flip | Alternative to "hFlip" and "vFlip" |  | String, value can be "horizontal", "vertical" or "horizontal,vertical"
rotate | Rotation. |  | Value can be in degrees "90deg" (only 90, 180 and 270 rotations are available), percentages "25%" (25%, 50% and 75% are aliases of 90deg, 180deg and 270deg) or number 1-3 (1 - 90deg, 2 - 180deg, 3 - 270deg).
inline | If true, code will include vertical-align style, making it behave like a glyph. | false | true or "true" or "1" (string or boolean),
color | custom color string to replace currentColor. This is useful when using icon as background image because background image cannot use currentColor |  |
box | If true, icon will include extra rectangle matching its view box. | false | true or "true" or "1" (string or boolean)
align | Alignment. This is useful if you have custom width and height set. Unlike other images, SVG keep aspect ratio (unless stated otherwise) when scaled. Value is comma or space separated string with possible strings (example: "left,top,crop"): |  |  [ left, right, center -> horizontal alignment ], [top, middle, bottom -> vertical alignment], [crop -> crop parts that go outside of boundaries], [meet -> scale icon down to fit entire icon (opposite of crop)]


## Usage in PHP

The ic么nes plugin value can also be used easily in PHP, with the obove options as follows:

```php
use Chkilel\Icones\Classes\JsonIcon;

$icon = new JsonIcon($value);
$icon->iconify(['inline'=>true, 'height'=>36]);

```

## Usage in Backend List

The ic么nes plugin can also be used on backend lists, it defines a new Column Types `iconesthumb` with the option to give a **height** (in px) to the output, e.g.

```yaml
icon:
    label: My awesome icon
    type: iconesthumb
    height: 36
```

![iconesthumb Column types with height option](https://res.cloudinary.com/chkilel/image/upload/v1629581582/icones-plugin/README/column-types-with-height_w97fgb.png)
