<?php

namespace Thtg88\MmCms\Listeners;

use Illuminate\Support\Str;
use Thtg88\MmCms\Events\ContentModelStored;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
     * @param ContentModelStored $event
     * @return void
     */
    public function handle(ContentModelStored $event)
    {
        $model_name = Str::studly($event->content_model->name);
        $controller_name = $model_name.'Controller';

        if (!class_exists($controller_name)) {
            \Artisan::call('make:controller', [
                'name' => $controller_name,
            ]);

            if (file_exists(app_path('Http/Controllers/'.$controller_name.'.php'))) {
                $file_content = file_get_contents(app_path('Http/Controllers/'.$controller_name.'.php'));

                if ($file_content !== false) {
                    $replace_content = $this->getContentModelControllerAdditionalContent($model_name);

                    $file_content = str_replace('//', $replace_content, $file_content);

                    $replace_content = $this->getContentModelControllerImports($model_name);

                    $file_content = str_replace('use Illuminate\Http\Request;', $replace_content, $file_content);

                    file_put_contents(app_path('Http/Controllers/'.$controller_name.'.php'), $file_content);
                }
            }
        }
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
        $content .= "// Repositories\n";
        $content .= "use App\Repositories\\".$model_name."Repository;\n";
        $content .= "// Requests\n";
        $content .= "use App\Http\Requests\\".$model_name."\Destroy".$model_name."Request;\n";
        $content .= "use App\Http\Requests\\".$model_name."\Store".$model_name."Request;\n";
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
        $content .= "/**\n";
        $content .= "     * Create a new controller instance.\n";
        $content .= "     *\n";
        $content .= "     * @param \Thtg88\MmCms\Repositories\\".$model_name."Repository        \$repository\n";
        $content .= "     * @return void\n";
        $content .= "     */\n";
        $content .= "    public function __construct(".$model_name."Repository \$repository)\n";
        $content .= "    {\n";
        $content .= "        \$this->repository = \$repository;\n";
        $content .= "    }\n";
        $content .= "\n";
        $content .= "    /**\n";
        $content .= "     * Store a newly created resource in storage.\n";
        $content .= "     *\n";
        $content .= "     * @param \Thtg88\MmCms\Http\Requests\\".$model_name."\Store".$model_name."Request  \$request\n";
        $content .= "     * @return \Illuminate\Http\Response\n";
        $content .= "     */\n";
        $content .= "    public function store(Store".$model_name."Request \$request)\n";
        $content .= "    {\n";
        $content .= "        // Get input\n";
        $content .= "        \$input = \$request->all();\n";
        $content .= "\n";
        $content .= "        // Create\n";
        $content .= "        \$resource = \$this->repository->create(\$input);\n";
        $content .= "\n";
        $content .= "        return response()->json([\n";
        $content .= "            'success' => true,\n";
        $content .= "            'resource' => \$resource,\n";
        $content .= "        ]);\n";
        $content .= "    }\n";
        $content .= "\n";
        $content .= "    /**\n";
        $content .= "     * Update the specified resource in storage.\n";
        $content .= "     *\n";
        $content .= "     * @param \Thtg88\MmCms\Http\Requests\\".$model_name."\Update".$model_name."Request  \$request\n";
        $content .= "     * @param int \$id\n";
        $content .= "     * @return \Illuminate\Http\Response\n";
        $content .= "     */\n";
        $content .= "    public function update(Update".$model_name."Request \$request, \$id)\n";
        $content .= "    {\n";
        $content .= "        // Get input\n";
        $content .= "        \$input = \$request->all();\n";
        $content .= "\n";
        $content .= "        // Update\n";
        $content .= "        \$resource = \$this->repository->update(\$id, \$input);\n";
        $content .= "\n";
        $content .= "        // No need to check if found as done by authorization method\n";
        $content .= "\n";
        $content .= "        return response()->json([\n";
        $content .= "            'success' => true,\n";
        $content .= "            'resource' => \$resource,\n";
        $content .= "        ]);\n";
        $content .= "    }\n";
        $content .= "\n";
        $content .= "    /**\n";
        $content .= "     * Remove the specified resource from storage.\n";
        $content .= "     *\n";
        $content .= "     * @param \Thtg88\MmCms\Http\Requests\\".$model_name."\Destroy".$model_name."Request  \$request\n";
        $content .= "     * @param int \$id\n";
        $content .= "     * @return \Illuminate\Http\Response\n";
        $content .= "     */\n";
        $content .= "    public function destroy(Destroy".$model_name."Request \$request, \$id)\n";
        $content .= "    {\n";
        $content .= "        // Delete resource\n";
        $content .= "        \$resource = \$this->repository->destroy(\$id);\n";
        $content .= "\n";
        $content .= "        return response()->json([\n";
        $content .= "            'success' => true,\n";
        $content .= "            'resource' => \$resource,\n";
        $content .= "        ]);\n";
        $content .= "    }";

        return $content;
    }
}
