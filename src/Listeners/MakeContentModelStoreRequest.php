<?php

namespace Thtg88\MmCms\Listeners;

use Illuminate\Support\Str;
use Thtg88\MmCms\Events\ContentModelStored;

class MakeContentModelStoreRequest
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param \Thtg88\MmCms\Events\ContentModelStored $event
     * @return void
     */
    public function handle(ContentModelStored $event)
    {
        $model_name = Str::studly($event->content_model->name);
        $request_name = 'Store'.$model_name.'Request';

        if (!class_exists($request_name)) {
            \Artisan::call('make:request', [
                'name' => $request_name,
            ]);

            if (file_exists(app_path('Http/Requests/'.$request_name.'.php'))) {
                $file_content = file_get_contents(app_path('Http/Requests/'.$request_name.'.php'));

                if ($file_content !== false) {
                    $replace_content = $this->getContentModelRequestConstructor($model_name);

                    $file_content = str_replace("class ".$request_name." extends FormRequest".PHP_EOL."{".PHP_EOL, $replace_content, $file_content);

                    $replace_content = $this->getContentModelRequestImports($model_name);

                    $file_content = str_replace('use Illuminate\Foundation\Http\FormRequest;', $replace_content, $file_content);

                    file_put_contents(app_path('Http/Requests/'.$request_name.'.php'), $file_content);
                }
            }
        }
    }

    /**
     * Returns imports for the request from a given model name.
     *
     * @param string $model_name
     * @return string
     */
    private function getContentModelRequestImports($model_name)
    {
        $content = '';
        $content .= "use App\Repositories\\".$model_name."Repository;".PHP_EOL;
        $content .= "use Illuminate\Validation\Rule;".PHP_EOL;
        $content .= "use Thtg88\MmCms\Http\Requests\StoreRequest;";

        return $content;
    }

    /**
     * Returns the constructor for the request from a given model name.
     *
     * @param string $model_name
     * @return string
     */
    private function getContentModelRequestConstructor($model_name)
    {
        $content = '';
        $content .= "class Store".$model_name."Request extends StoreRequest".PHP_EOL;
        $content .= "{".PHP_EOL;
        $content .= "    /**".PHP_EOL;
        $content .= "     * Create a new request instance.".PHP_EOL;
        $content .= "     *".PHP_EOL;
        $content .= "     * @param	\Thtg88\MmCms\Repositories\\".$model_name."Repository	\$repository".PHP_EOL;
        $content .= "     * @return	void".PHP_EOL;
        $content .= "     */".PHP_EOL;
        $content .= "    public function __construct(".$model_name."Repository \$repository)".PHP_EOL;
        $content .= "    {".PHP_EOL;
        $content .= "        \$this->repository = \$repository;".PHP_EOL;
        $content .= "    }".PHP_EOL;
        $content .= PHP_EOL;

        return $content;
    }
}
