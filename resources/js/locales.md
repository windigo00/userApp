# Vuejs on Laravel Translation Tool

this js tool uses Laravel translator for filtering within Vie template

# INSTALL

place code in paths or reasonable choosing. you are going to link all parts probably anyway.
see also [Server part][SERVER SIDE] for backend configuration.

## [CLIENT SIDE]

add js to webpack if you use it

```mix.js(['resources/assets/js/classes/Locales.js'], 'public/js/classes/Locales.js');```

## [SERVER SIDE]

controller is using `translation.loader` class for fetching data. this is registered by `config/app.php` > `providers` > `Illuminate\Translation\TranslationServiceProvider::class`

### ROUTES

you need to setup the route. most likely in `app\Http\routes`.

example of `locales.php`:

```php
use App\Http\Controllers\LocalesController;
use Illuminate\Http\Request;
Route::get('/locales', function (Request $request) {
    if (!$request->ajax()) {
        throw new Exception('Locales se nepodařil nahrat');
    }

    $controller = app()->make(LocalesController::class);
    return $controller->fetch($request);
})->name('locales.module');
```
here mentioned `LocalesController` handles data fetching.

add your route to provider `App\Providers\RouteServiceProvider` somewhere.

```php
$router->group(['middleware' => ['web']], function ($router) {
    ...
    require app_path('Http/routes/locales.php');
    ...
});
```

# USAGE

first things first. import your translator class like this. path may vary for your case

```import { Locales } from '../../classes/Locales.js'```

## OPTIONS

 - `eventer` : `[Vue]` *REQUIRED!* Event manager. has to be supplied by user for encapsulation of events. you can just pass `new Vue()` in root app. 
 - `storage` : `[string|boolean]` If we should use web storage (local cache). `true` will use `localStorage`. `default` - `false`. it's best to use class constants for storage type. `Locales.STORAGE_LOCAL` and `Locales.STORAGE_SESSION` respectively. 
 - `route`   : `[string]` route to server where we get our data. `default` - `''`
 - `module`  : `[array|string]` which module(s) we want to request from server. `default` - `[]`
 - `locale`  : `[string]` what language we want to use. `default` - `'cz'`

## As global filter

> TODO: figure out how to initialize global [Vue filter](https://vuejs.org/v2/guide/filters.html).

## As component filter

Initialize instance of translator.

```javascript
var loc = new Locales({'route': locales_route, 'module' : 'captain', 'locale' => 'cz'});
```

this has to be done as local variable for your app/component because filters run in closure without `this`. we have to be able to access the instance somehow.

the best thing (what i found anyway) is to add it in component or app data. this way you can utilize data from controller like route translation and current system locales.

> TODO: idea - make Locales look for language set for current document if no locales are set from controller explicitly.

```javascript
...
{
    ...
    data(){
        loc = new Locales({'route': locales_route, 'module' : 'captain', 'locale' => 'cz'});
        return {
        ...
        locales : loc
        ...
        }
    }
    ...
}
...
```

i recommend initialize locales object only once and then pass it as a property to child components. `<component :locales=locales></component>`

in your `component.vue` you need to add local variable for filters.
```
...
var loc;
export default {
    ...
    props: ['locales', ...],
    ...
    filters: {
        ...
        translate(){
            return loc.translate(arguments);
        }
        ...
    },
    ...
}
...
```

### FILTERS

then you have to specify filter if you don't want to use this as global filter
Warning again: filters run without `this`. you need to use your previously
specified local variable with Locales instance.

just pass all arguments to translator. don't bother here much

```javascript
...
{
    ...
    filters: {
        ...
        translate(){ return loc.translate(arguments) }
        ...
    }
    ...
}
...
```

# [INITIALIZATION]

locales are loaded from server by ajax. you need to disable rendering of component you are about to translate until locales are loaded. this can be facilitated by adding `v-if="locales.loaded"` in your template root.

when loading, `Locales` fires two events. `loading.start` and `loading.stop`. you can utilize these for `loading` overlay handling.
it also sets own property `loaded` to true, if no error occurred during loading.



# [TRANSLATION IN TEMPLATES]

it works much like [Laravel translator](https://laravel.com/docs/5.2/localization). you have string and you can add replacement object.
i'm not sure about Vue but i guess the string has to be in double quotes. otherwise it's treated as variable by template renderer.


```html
{{ "general.Základní údaje" | translate }}
```
or

```html
{{ "general.Základní údaje :number" | translate({ number: 3.14 }) }}
```
in tag value
```html
<button :title='"general.Základní údaje" | translate' >btn</button>
<button :title='"general.Základní údaje :number" | translate({ number: 3.14 })' >btn</button>
```
or go absolutly crazy
```html
<button :title='"general.Základní údaje" | translate( { number: e => e.split(" ").map( function(ee){ return ee.charAt(0).toLocaleUpperCase() + ee.slice(1) } ).join(" ") } )' >btn</button>
```

> TODO: letter case handling is not implemented yet

# [TESTS]

there is a test component on path `<easyk>/public/test_vue_locales`

# [BUGS]

lemme know if you got here or you found a bug. thx :)
