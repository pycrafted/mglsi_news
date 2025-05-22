<?php
class FileUploadService {
    private $uploadDir;
    private $allowedExtensions;

    public function __construct(string $uploadDir = 'uploads', array $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif']) {
        $this->uploadDir = __DIR__ . '/../../' . $uploadDir;
        $this->allowedExtensions = $allowedExtensions;
    }

    public function upload($file): ?string {
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }

        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $this->allowedExtensions)) {
            throw new Exception('Format d\'image non autorisé');
        }

        $newFileName = uniqid() . '.' . $fileExtension;
        $uploadFile = $this->uploadDir . '/' . $newFileName;

        if (!move_uploaded_file($file['tmp_name'], $uploadFile)) {
            throw new Exception('Erreur lors de l\'upload de l\'image');
        }

        return $newFileName;
    }
} 