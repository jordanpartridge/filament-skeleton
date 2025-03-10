<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Prefix
    |--------------------------------------------------------------------------
    |
    | This config option allows you to define a default prefix for
    | your icons. The dash separator will be applied automatically.
    |
    */

    'prefix' => 'fa',

    /*
    |--------------------------------------------------------------------------
    | Fallback
    |--------------------------------------------------------------------------
    |
    | This config option allows you to define a fallback icon when an icon
    | cannot be found. The default shown here uses the search-dollar icon.
    |
    */

    'fallback' => 'fas-circle-exclamation',

    /*
    |--------------------------------------------------------------------------
    | Default Set
    |--------------------------------------------------------------------------
    |
    | This config option allows you to define a default icon set.
    | It's likely that you may use either 'far', 'fas' or 'fab' more
    | often than others, so here you can define it for simplicity.
    |
    */

    'default' => 'fas',

    /*
    |--------------------------------------------------------------------------
    | Default Size
    |--------------------------------------------------------------------------
    |
    | This config option allows you to define a default width and height.
    | The default shown here is 1em, which is useful for most scenarios.
    |
    */

    'size' => [
        'width' => '1em',
        'height' => '1em',
    ],

    /*
    |--------------------------------------------------------------------------
    | Pro Regular Set
    |--------------------------------------------------------------------------
    |
    | This config option enables the use of the Regular set from Pro.
    | While this set is considered regular, Font Awesome specifies
    | this with the shorthand 'r'. This value is mapped to 'far'.
    |
    | Note: This is false by default as this is a premium set.
    |
    | @see https://fontawesome.com/how-to-use/on-the-web/setup/getting-started
    |
    */

    'pro.regular' => false,

    /*
    |--------------------------------------------------------------------------
    | Pro Light Set
    |--------------------------------------------------------------------------
    |
    | This config option enables the use of the Light set from Pro.
    | While this set is considered light, Font Awesome specifies
    | this with the shorthand 'l'. This value is mapped to 'fal'.
    |
    | Note: This is false by default as this is a premium set.
    |
    | @see https://fontawesome.com/how-to-use/on-the-web/setup/getting-started
    |
    */

    'pro.light' => false,

    /*
    |--------------------------------------------------------------------------
    | Pro Thin Set
    |--------------------------------------------------------------------------
    |
    | This config option enables the use of the Thin set from Pro.
    | While this set is considered thin, Font Awesome specifies
    | this with the shorthand 't'. This value is mapped to 'fat'.
    |
    | Note: This is false by default as this is a premium set.
    |
    | @see https://fontawesome.com/how-to-use/on-the-web/setup/getting-started
    |
    */

    'pro.thin' => false,

    /*
    |--------------------------------------------------------------------------
    | Pro Duotone Set
    |--------------------------------------------------------------------------
    |
    | This config option enables the use of the Duotone set from Pro.
    | While this set is considered duotone, Font Awesome specifies
    | this with the shorthand 'd'. This value is mapped to 'fad'.
    |
    | Note: This is false by default as this is a premium set.
    |
    | @see https://fontawesome.com/how-to-use/on-the-web/setup/getting-started
    |
    */

    'pro.duotone' => false,

    /*
    |--------------------------------------------------------------------------
    | Pro Sharp Set
    |--------------------------------------------------------------------------
    |
    | This config option enables the use of the Sharp set from Pro.
    | While this set is considered sharp, Font Awesome specifies
    | this with the shorthand 's'. This value is mapped to 'fas'.
    |
    | Note: This is false by default as this is a premium set.
    |
    | @see https://fontawesome.com/how-to-use/on-the-web/setup/getting-started
    |
    */

    'pro.sharp' => false,
];
