<?php

namespace FileUploader;

class FileUploader
{
    private array $files;
    private static array $defaultExtensions = [
        'jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg', // Images
        'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', // Documents
        'txt', 'csv', 'zip', 'rar', '7z', 'tar', 'gz', 'xml', // Text and compressed files
        'mp3', 'wav', 'ogg', 'm4a', // Audio
        'mp4', 'avi', 'mov', 'mkv', 'webm', // Video
    ];

    public function __construct(array $files = null)
    {
        $this->files = $files ?? $_FILES;
    }

    /**
     * Check if a file exists in the request.
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($this->files[$key]) && $this->files[$key]['error'] === UPLOAD_ERR_OK;
    }

    /**
     * Get an uploaded file by key.
     *
     * @param string $key
     * @return UploadedFile|null
     */
    public function get(string $key): ?UploadedFile
    {
        if ($this->has($key)) {
            $file = new UploadedFile($this->files[$key]);
            $file->setAllowedExtensions(self::$defaultExtensions);
            return $file;
        }
        return null;
    }

    /**
     * Static method to handle file upload and storage.
     *
     * @param string $key
     * @param string|null $uploadDir
     * @param array|null $allowedExtensions
     * @param int $maxFileSize
     * @param array|null $files
     * @return string|null
     * @throws \RuntimeException
     */
    public static function store(string $key, string $uploadDir = null, ?array $allowedExtensions = null, int $maxFileSize = 10485760, ?array $files = null): ?string
    {
        $uploadDir = $uploadDir ?? $_SERVER['DOCUMENT_ROOT'] . '/uploads';
        $uploader = new self($files);

        if ($uploader->has($key)) {
            $file = $uploader->get($key);

            if ($file) {
                $file->setAllowedExtensions($allowedExtensions ?? self::$defaultExtensions);
                $file->setMaxFileSize($maxFileSize);

                if ($file->hasFile()) {
                    return $file->move($uploadDir);
                }

                throw new \RuntimeException("No valid file uploaded.");
            }
        }

        throw new \RuntimeException("No file uploaded with key: {$key}.");
    }

    /**
     * Static method to delete a file.
     *
     * @param string $fileName
     * @param string|null $folder
     * @return bool
     * @throws \RuntimeException
     */
    public static function delete(string $fileName, string $folder = null): bool
    {
        $baseDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads';
        $folder = $folder ? rtrim($folder, '/') : '';
        $filePath = $baseDir . ($folder ? "/{$folder}" : '') . '/' . ltrim($fileName, '/');

        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                return true;
            } else {
                throw new \RuntimeException("Failed to delete the file: {$filePath}.");
            }
        } else {
            throw new \RuntimeException("File not found: {$filePath}.");
        }
    }

}
