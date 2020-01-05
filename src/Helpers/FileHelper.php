<?php

namespace Thtg88\MmCms\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Thtg88\MmCms\Repositories\Repository;

/**
 * Helper methods for database.
 */
class FileHelper
{
    /**
     * Builds a new filename from an uploaded file,
     * by pre-pending a unique id to the slug of the filename,
     * conserving the original file extension
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    public function buildFilename(UploadedFile $file)
    {
        // Get original file extension
        $extension = $file->getClientOriginalExtension();

        // Get length of extension
        $extension_length = strlen($extension);

        // Get original file name
        $filename = $file->getClientOriginalName();

        // Extension position
        $extension_position = strpos($filename, $extension, -$extension_length);

        // Remove file extension
        if ($extension_position === strlen($filename) - $extension_length) {
            $filename = substr($filename, 0, $extension_position);
        }

        // Prepend unique id to slug of filename
        return uniqid().'-'.Str::slug($filename).'.'.$extension;
    }

    /**
     * Stores a file from a given uploaded file and repository.
     * This creates a folder with 777 permissions if N/A.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param \Thtg88\MmCms\Repositories\Repository $repository
     * @return string
     */
    public function store(UploadedFile $file, Repository $repository)
    {
        $filename = $this->buildFilename($file);

        // Folder is userfiles/table-name folder
        $folder = 'public/userfiles/'.$repository->getName();

        $fully_qualified_folder = storage_path('app/'.$folder);

        if (!is_dir($fully_qualified_folder)) {
            mkdir($fully_qualified_folder, 0777, true);
        }

        // Store file
        $file_path = $file->storeAs($folder, $filename);

        // Amend path to be reachable from symlink

        if (strpos($file_path, 'public') === 0) {
            $file_path = substr($file_path, strlen('public'));
        }

        return '/storage'.$file_path;
    }
}
