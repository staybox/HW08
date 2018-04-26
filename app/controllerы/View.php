<?php
namespace Acme\Controller;
class View
{
    /**
     * @param string $filename
     * @param array $data
     */
    public function render(string $filename, array $data = [], $currentPage = null)
    {
        if (!empty($data)) {
            extract($data);
        }

        $file =realpath("../app/view").DIRECTORY_SEPARATOR. $filename . ".php";

        if (!file_exists($file)) {
            echo "Нет такого файла";
        }
        require($file);
    }
}