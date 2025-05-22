<?php
class Layout {
    private $layoutFile;
    private $content;
    private $data;

    public function __construct(string $layoutFile = 'default') {
        $this->layoutFile = __DIR__ . '/../Views/layouts/' . $layoutFile . '.layout.php';
        $this->data = [];
    }

    public function setContent(string $content) {
        $this->content = $content;
    }

    public function setData(array $data) {
        $this->data = $data;
    }

    public function render() {
        if (!file_exists($this->layoutFile)) {
            throw new Exception("Layout non trouvé : {$this->layoutFile}");
        }

        extract($this->data);
        ob_start();
        require $this->layoutFile;
        return ob_get_clean();
    }
} 