Without this fix, PHP 8 will throw and (uncaught) `TypeError: vsprintf(): Argument #2 ($args) must
be of type array, string given`.

The adjacent file 'ControlStructureSpacingSniff.php' has been modified as per [this fix](https://github.com/WordPress/WordPress-Coding-Standards/commit/7cd46bed1e6a7a2af3fe24c7f4a044da3076d8f4). It hasn't been
released so must be manually patched for now.

Copy the file into the equivilent directory in './vendor/...' overwiting the original
'ControlStructureSpacingSniff.php'.

**Warning**: If upstream has made changes to this file, this patched version may break wpcs. This
patched file is good for use with **wpcs 2.3.0**. If you use a different version, you will need to
patch the file manually line by line as per the link above.