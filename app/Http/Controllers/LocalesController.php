<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Translation\LoaderInterface;

class LocalesController extends Controller
{

    /**
     * Locale loader
     * @var LoaderInterface
     */
    protected $loader;
    /**
     * locale code. ex. (cz|en)
     * @var string
     */
    protected $locale;
    /**
     *
     * @var array
     */
    protected $data = [];

    public function __construct($locale = null)
    {
        $this->loader = app('translation.loader');
        $this->locale = $locale ? $locale : App::getLocale();

    }
    /**
     * Get translations for js front
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch(Request $request)
    {
//        sleep(5); // for async testing
        $locale = $request->input('locale', $this->locale);// set new locale if requested
        $modules = $request->input('module', []);
        foreach($modules as $module) {
            $data = $this->loader->load($locale, $module);
            $this->data[$module] = [
                'keys'   => array_keys($data),
                'values' => array_values($data)
            ];
        }
        return response()->json($this->data);
    }
}
