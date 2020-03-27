<?php

namespace Thtg88\MmCms\Listeners;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Thtg88\MmCms\Events\ContentModelStored;

class MakeContentModelController
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
        $controller_name = $model_name.'Controller';

        if (class_exists($controller_name)) {
            return;
        }

        Artisan::call('make:controller', [
            'name' => $controller_name,
        ]);

        if (
            ! file_exists(
                Container::getInstance()
                    ->path('Http/Controllers/'.$controller_name.'.php')
            )
        ) {
            return;
        }

        $file_content = file_get_contents(
            Container::getInstance()
                ->path('Http/Controllers/'.$controller_name.'.php')
        );

        if ($file_content === false) {
            return;
        }

        $replace_content = $this->getContentModelControllerAdditionalContent(
            $model_name
        );

        $file_content = str_replace('//', $replace_content, $file_content);

        $replace_content = $this->getContentModelControllerImports($model_name);

        $file_content = str_replace(
            'use Illuminate\Http\Request;',
            $replace_content,
            $file_content
        );

        file_put_contents(
            Container::getInstance()
                ->path('Http/Controllers/'.$controller_name.'.php'),
            $file_content
        );
    }

    /**
     * Returns imports for the controller from a given model name.
     *
     * @param string $model_name
     * @return string
     */
    private function getContentModelControllerImports($model_name)
    {
        $content = '';
        $content .= "use App\Repositories\\".$model_name."Repository;".PHP_EOL;
        $content .= "use App\Http\Requests\\".$model_name."\Destroy".$model_name."Request;".PHP_EOL;
        $content .= "use App\Http\Requests\\".$model_name."\Store".$model_name."Request;".PHP_EOL;
        $content .= "use App\Http\Requests\\".$model_name."\Update".$model_name."Request;";

        return $content;
    }

    /**
     * Returns additional content for the controller from a given model name.
     *
     * @param string $model_name
     * @return string
     */
    private function getContentModelControllerAdditionalContent($model_name)
    {
        $content = '';
        $content .= "/**".PHP_EOL;
        $content .= "     * Create a new controller instance.".PHP_EOL;
        $content .= "     *".PHP_EOL;
        $content .= "     * @param \Thtg88\MmCms\Repositories\\".$model_name."Repository        \$repository".PHP_EOL;
        $content .= "     * @return void".PHP_EOL;
        $content .= "     */".PHP_EOL;
        $content .= "    public function __construct(".$model_name."Repository \$repository)".PHP_EOL;
        $content .= "    {".PHP_EOL;
        $content .= "        \$this->repository = \$repository;".PHP_EOL;
        $content .= "    }".PHP_EOL;
        $content .= PHP_EOL;
        $content .= "    /**".PHP_EOL;
        $content .= "     * Store a newly created resource in storage.".PHP_EOL;
        $content .= "     *".PHP_EOL;
        $content .= "     * @param \Thtg88\MmCms\Http\Requests\\".$model_name."\Store".$model_name."Request  \$request".PHP_EOL;
        $content .= "     * @return \Illuminate\Http\Response".PHP_EOL;
        $content .= "     */".PHP_EOL;
        $content .= "    public function store(Store".$model_name."Request \$request)".PHP_EOL;
        $content .= "    {".PHP_EOL;
        $content .= "        // Get input".PHP_EOL;
        $content .= "        \$input = \$request->all();".PHP_EOL;
        $content .= PHP_EOL;
        $content .= "        // Create".PHP_EOL;
        $content .= "        \$resource = \$this->repository->create(\$input);".PHP_EOL;
        $content .= PHP_EOL;
        $content .= "        return response()->json([".PHP_EOL;
        $content .= "            'success' => true,".PHP_EOL;
        $content .= "            'resource' => \$resource,".PHP_EOL;
        $content .= "        ]);".PHP_EOL;
        $content .= "    }".PHP_EOL;
        $content .= PHP_EOL;
        $content .= "    /**".PHP_EOL;
        $content .= "     * Update the specified resource in storage.".PHP_EOL;
        $content .= "     *".PHP_EOL;
        $content .= "     * @param \Thtg88\MmCms\Http\Requests\\".$model_name."\Update".$model_name."Request  \$request".PHP_EOL;
        $content .= "     * @param int \$id".PHP_EOL;
        $content .= "     * @return \Illuminate\Http\Response".PHP_EOL;
        $content .= "     */".PHP_EOL;
        $content .= "    public function update(Update".$model_name."Request \$request, \$id)".PHP_EOL;
        $content .= "    {".PHP_EOL;
        $content .= "        // Get input".PHP_EOL;
        $content .= "        \$input = \$request->all();".PHP_EOL;
        $content .= PHP_EOL;
        $content .= "        // Update".PHP_EOL;
        $content .= "        \$resource = \$this->repository->update(\$id, \$input);".PHP_EOL;
        $content .= PHP_EOL;
        $content .= "        // No need to check if found as done by authorization method".PHP_EOL;
        $content .= PHP_EOL;
        $content .= "        return response()->json([".PHP_EOL;
        $content .= "            'success' => true,".PHP_EOL;
        $content .= "            'resource' => \$resource,".PHP_EOL;
        $content .= "        ]);".PHP_EOL;
        $content .= "    }".PHP_EOL;
        $content .= PHP_EOL;
        $content .= "    /**".PHP_EOL;
        $content .= "     * Remove the specified resource from storage.".PHP_EOL;
        $content .= "     *".PHP_EOL;
        $content .= "     * @param \Thtg88\MmCms\Http\Requests\\".$model_name."\Destroy".$model_name."Request  \$request".PHP_EOL;
        $content .= "     * @param int \$id".PHP_EOL;
        $content .= "     * @return \Illuminate\Http\Response".PHP_EOL;
        $content .= "     */".PHP_EOL;
        $content .= "    public function destroy(Destroy".$model_name."Request \$request, \$id)".PHP_EOL;
        $content .= "    {".PHP_EOL;
        $content .= "        // Delete resource".PHP_EOL;
        $content .= "        \$resource = \$this->repository->destroy(\$id);".PHP_EOL;
        $content .= PHP_EOL;
        $content .= "        return response()->json([".PHP_EOL;
        $content .= "            'success' => true,".PHP_EOL;
        $content .= "            'resource' => \$resource,".PHP_EOL;
        $content .= "        ]);".PHP_EOL;
        $content .= "    }";

        return $content;
    }
}
