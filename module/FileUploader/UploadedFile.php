<?php

namespace FileUploader;

class UploadedFile
{
    private array $file;
    private array $allowedExtensions = [];
    private int $maxFileSize = 10485760; // 10 MB in bytes

    public function __construct(array $file)
    {
        if (empty($file) || !isset($file['tmp_name']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            $this->file = [];
            return; // No file uploaded, but no error thrown.
        }

        $this->file = $file;
    }

    public function setAllowedExtensions(array $extensions): void
    {
        $this->allowedExtensions = array_map('strtolower', $extensions);
    }

    public function setMaxFileSize(int $bytes): void
    {
        $this->maxFileSize = $bytes;
    }

    public function hasFile(): bool
    {
        return !empty($this->file);
    }

    public function getOriginalName(): string
    {
        return $this->file['name'] ?? '';
    }

    public function getSize(): int
    {
        return $this->file['size'] ?? 0;
    }

    public function getMimeType(): string
    {
        return isset($this->file['tmp_name']) ? mime_content_type($this->file['tmp_name']) : '';
    }

    public function isValid(): bool
    {
        return $this->hasFile() 
            && $this->file['error'] === UPLOAD_ERR_OK 
            && $this->validateExtension() 
            && $this->validateFileSize();
    }

    private function validateExtension(): bool
    {
        if (!$this->hasFile()) {
            return false;
        }

        $extension = strtolower(pathinfo($this->getOriginalName(), PATHINFO_EXTENSION));

        if (!empty($this->allowedExtensions) && !in_array($extension, $this->allowedExtensions, true)) {
            throw new \RuntimeException("File extension '{$extension}' is not allowed.");
        }

        return true;
    }

    private function validateFileSize(): bool
    {
        if (!$this->hasFile()) {
            return false;
        }

        if ($this->getSize() > $this->maxFileSize) {
            throw new \RuntimeException("File size exceeds the maximum limit of {$this->maxFileSize} bytes.");
        }

        return true;
    }

    public function move(string $uploadDir): ?string
    {
        if (!$this->hasFile()) {
            return null; // No file to move.
        }

        if (!$this->isValid()) {
            throw new \RuntimeException("Invalid file upload.");
        }

        $originalName = $this->getOriginalName();
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $safeName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
        $newName = $safeName . '-' . uniqid() . '.' . $extension;
        $destination = rtrim($uploadDir, '/') . '/' . $newName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (!move_uploaded_file($this->file['tmp_name'], $destination)) {
            throw new \RuntimeException("Failed to move uploaded file.");
        }

        return $newName;
    }
}