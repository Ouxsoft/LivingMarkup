# Changelog for LivingMarkup

All releases must adhere to [SemVer 2](https://semver.org/) naming convention and should adhere to [KeepAChangeLog](https://keepachangelog.com/en/1.0.0/) guidelines.

>MAJOR version - when you make incompatible API changes,
>
>MINOR version - when you add functionality in a backwards compatible manner, and
>
>PATCH version - when you make backwards compatible bug fixes.

## LivingMarkup [Unreleased]
Features hindering reuse as a LHTML processor library were moved to [Hoopless](https://github.com/ouxsoft/hoopless).
* Removed: Web server (/docker, /bin, /public, /var, etc.). [#b672884](https://github.com/ouxsoft/LivingMarkup/commit/b67288498b72c94e574ae47e0f095e5ead29ded9)
* Removed: Dynamic image generation. [#b672884](https://github.com/ouxsoft/LivingMarkup/commit/b67288498b72c94e574ae47e0f095e5ead29ded9)

## LivingMarkup 1.5.3
* Fixed: Docker environment [#401112e](https://github.com/ouxsoft/LivingMarkup/commit/401112e169c2a585df77e04e633258fdef1ae272)
* Added: Individual width and height parametrized image requests [#dd86ea7](https://github.com/ouxsoft/LivingMarkup/commit/dd86ea7439be126c0c96ddc3facb935dbd6ad577)
* Fixed: Image resize algorithm [#dd86ea7](https://github.com/ouxsoft/LivingMarkup/commit/dd86ea7439be126c0c96ddc3facb935dbd6ad577)

## LivingMarkup 1.5.2
* Added: process=false flag to skip elements [#738565b](https://github.com/hxtree/LivingMarkup/commit/738565b28c8acfcf25b44115b8f9fb003759b01f)
* Added: Code block module for styling code [#738565b](https://github.com/hxtree/LivingMarkup/commit/738565b28c8acfcf25b44115b8f9fb003759b01f)
* Fixed: DOMElement Arg removal [85ef96c](https://github.com/ouxsoft/LivingMarkup/commit/85ef96c4aea4c172c04f9e7b5db9ab6c56cdba08)
* Added: Code styles [#4026dab](https://github.com/ouxsoft/LivingMarkup/commit/84026dab3ee8c3cdfd9d34cf3dcbfa5fc0f94b7de)

## LivingMarkup 1.5.1
* Added: PNG image resize [#2b7b323](https://github.com/hxtree/LivingMarkup/commit/2b7b323bd882ff0ad5ae9a937d0f8a1449b862a1)
* Fixed: JPG image resize [#2b7b323](https://github.com/hxtree/LivingMarkup/commit/2b7b323bd882ff0ad5ae9a937d0f8a1449b862a1)
* Added: Image offset / focal point [#56397ca](https://github.com/hxtree/LivingMarkup/commit/56397ca7546b24291f63487ecb930e01398e66c3)
* Added: Custom SCSS build [#56397ca](https://github.com/hxtree/LivingMarkup/commit/56397ca7546b24291f63487ecb930e01398e66c3)

## LivingMarkup 1.5.0
Released: 2019-05-11. Notable changes:
* Added: Separate Core and Custom Modules [#e42fc61](https://github.com/hxtree/LivingMarkup/commit/e42fc61e2773e58e51e2e2da43b29ef2cb2e9b59)
* Added: Docker build option [#173059f](https://github.com/hxtree/LivingMarkup/commit/173059fbff37430cdd805be0ba06f8fbd8b099b6)
* Added: Bootstrap and Jquery [#3d5104f](https://github.com/hxtree/LivingMarkup/commit/3d5104f395115c9f5d48ec08e87b1474171e8410)
* Added: Sass Auto Compiler [#06fe0d3](https://github.com/hxtree/LivingMarkup/commit/06fe0d364545dbac2885c6ea53576e4a55cfc07d)
* Added: Router [#89679f1](https://github.com/hxtree/LivingMarkup/commit/89679f16f8cbffa90a8f0490adb97cb30edd89e3)
* Moved: Examples into Public Help [#e42fc61](https://github.com/hxtree/LivingMarkup/commit/e42fc61e2773e58e51e2e2da43b29ef2cb2e9b59)
* Fixed: PHP Unit Test [#e4826dd](https://github.com/hxtree/LivingMarkup/commit/e4826dd3de6ada117dbe3db5089bf9fc2f2bdd9e)

## LivingMarkup 1.4.1
Released: 2019-03-29. Notable changes:

* Updated: Started following Semantic Versioning 2 properly [#74724ce](https://github.com/hxtree/LivingMarkup/commit/00c7ad18fe09465c864a6bb5a20618fbd7ce8e83)
