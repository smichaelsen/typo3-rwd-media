## RWD Media Partials
### For TYPO3 Fluid

This extension offers Fluid partials that can be used in your templates when you want to render responsive images and/or videos.

### Usage

Enable the usage of the partials in your extension by adding the following to your extension's TypoScript:

````
plugin.tx_myext {
    view {
        partialRootPaths.10 = EXT:my_ext/Resources/Private/Partials/
        partialRootPaths.1462872447 = EXT:rwd_media/Resources/Private/Partials/
    }
}
````

Then in any Fluid Template use it like this:

````
<f:render partial="Utility/ResponsiveImage" arguments="{image:myimage,width:'300'}"/>
````

Take a look into the ResponsiveImage partial file for documentation on the supported arguments.

Spoiler: The `image` argument accepts a lot of different input types like `\TYPO3\CMS\Core\Resource\FileReference`, `\TYPO3\CMS\Extbase\Domain\Model\FileReference`, a sys_file uid or a file string like "2:/my/folder/image.png". Just give it whatever you have in your hands.


For Video files use:
````
<f:render partial="Utility/ResponsiveVideo" arguments="{video:video}"/>
````

Or use the `ResponsiveMedia` partial for automatic detection of images or videos.
