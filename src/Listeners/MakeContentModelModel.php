<?php

namespace Thtg88\MmCms\Listeners;

use Illuminate\Support\Str;
use Thtg88\MmCms\Events\ContentModelStored;

class MakeContentModelModel
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

        \Artisan::call('make:model', [
            'name' => $model_name,
        ]);

        if (file_exists(app_path($model_name.'.php'))) {
            $file_content = file_get_contents(app_path($model_name.'.php'));

            if ($file_content !== false) {
                $replace_content = $this->getContentModelModelAdditionalContent($event->content_model->table_name);

                $file_content = str_replace('//', $replace_content, $file_content);

                file_put_contents(app_path($model_name.'.php'), $file_content);
            }
        }
    }

    /**
     * Returns additional content for the model from a given table name.
     *
     * @param string $table_name
     * @return string
     */
    private function getContentModelModelAdditionalContent($table_name)
    {
        $content = '';
        $content .= "/**".PHP_EOL;
        $content .= "     * The database table used by the model.".PHP_EOL;
        $content .= "     *".PHP_EOL;
        $content .= "     * @var string".PHP_EOL;
        $content .= "     */".PHP_EOL;
        $content .= "    protected \$table = '".$table_name."';".PHP_EOL;
        $content .= PHP_EOL;
        $content .= "    /**".PHP_EOL;
        $content .= "     * The primary key for the model.".PHP_EOL;
        $content .= "     *".PHP_EOL;
        $content .= "     * @var string".PHP_EOL;
        $content .= "     */".PHP_EOL;
        $content .= "    protected \$primaryKey = 'id';".PHP_EOL;
        $content .= PHP_EOL;
        $content .= "    /**".PHP_EOL;
        $content .= "     * The attributes that are mass assignable.".PHP_EOL;
        $content .= "     *".PHP_EOL;
        $content .= "     * @var array".PHP_EOL;
        $content .= "     */".PHP_EOL;
        $content .= "    protected \$fillable = [".PHP_EOL;
        $content .= "        'created_at',".PHP_EOL;
        $content .= "        // fillable attributes".PHP_EOL;
        $content .= "    ];".PHP_EOL;
        $content .= PHP_EOL;
        $content .= "    /**".PHP_EOL;
        $content .= "     * The attributes that should be visible in arrays.".PHP_EOL;
        $content .= "     *".PHP_EOL;
        $content .= "     * @var array".PHP_EOL;
        $content .= "     */".PHP_EOL;
        $content .= "    protected \$visible = [".PHP_EOL;
        $content .= "        'created_at',".PHP_EOL;
        $content .= "        'id',".PHP_EOL;
        $content .= "        // visible attributes".PHP_EOL;
        $content .= "    ];".PHP_EOL;
        $content .= PHP_EOL;
        $content .= "    /**".PHP_EOL;
        $content .= "     * The relations to eager load on every query.".PHP_EOL;
        $content .= "     *".PHP_EOL;
        $content .= "     * @var array".PHP_EOL;
        $content .= "     */".PHP_EOL;
        $content .= "    protected \$visible = [".PHP_EOL;
        $content .= "        // with attributes".PHP_EOL;
        $content .= "    ];".PHP_EOL;
        $content .= PHP_EOL;
        $content .= "    // RELATIONSHIPS".PHP_EOL;

        return $content;
    }
}
