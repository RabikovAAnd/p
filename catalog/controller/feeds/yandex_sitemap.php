<?php
class ControllerFeedYandexSitemap extends Controller {
    public function index() {
        // Путь для сохранения файлов карты сайта
        $outputDir = DIR_SITEMAP;
        $baseUrl = HTTP_SERVER;

        // 2.1 Список публичных категорий
        $categories = $this->getCategories();
        $this->generateSitemapFile('categories', $categories, $outputDir, $baseUrl);

        // 2.2 Список товаров
        $products = $this->getProducts();
        $this->generateSitemapFile('products', $products, $outputDir, $baseUrl);

        // 2.3 Список производителей
        $manufacturers = $this->getManufacturers();
        $this->generateSitemapFile('manufacturers', $manufacturers, $outputDir, $baseUrl);

        // 2.4 Индексный файл
        $this->generateIndexFile(['categories', 'products', 'manufacturers'], $outputDir, $baseUrl);

        echo "Yandex Sitemap successfully generated!";
    }

    // Метод для получения категорий
    private function getCategories() {
        $query = $this->db->query("SELECT category_guid FROM categories WHERE is_public = 1");
        return array_map(function($row) {
            return "index.php?route=catalog/categories&category_guid=" . $row['category_guid'];
        }, $query->rows);
    }

    // Метод для получения товаров
    private function getProducts() {
        $query = $this->db->query("SELECT guid FROM product");
        return array_map(function($row) {
            return "index.php?route=items/info&guid=" . $row['guid'];
        }, $query->rows);
    }

    // Метод для получения производителей
    private function getManufacturers() {
        $query = $this->db->query("SELECT manufacturer_id FROM manufacturers");
        return array_map(function($row) {
            return "index.php?route=manufacturers/info&manufacturer_id=" . $row['manufacturer_id'];
        }, $query->rows);
    }

    // Метод для генерации карты сайта
    private function generateSitemapFile($type, $links, $outputDir, $baseUrl) {
        $fileName = "{$outputDir}{$type}_sitemap.xml";
        $xml = new DOMDocument('1.0', 'UTF-8');
        $urlset = $xml->createElement('urlset');
        $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $xml->appendChild($urlset);

        foreach ($links as $link) {
            $url = $xml->createElement('url');
            $loc = $xml->createElement('loc', htmlspecialchars($baseUrl . $link));
            $url->appendChild($loc);
            $urlset->appendChild($url);
        }

        $xml->formatOutput = true;
        $xml->save($fileName);
    }

    // Метод для генерации индексного файла
    private function generateIndexFile($types, $outputDir, $baseUrl) {
        $indexFile = "{$outputDir}index_sitemap.xml";
        $xml = new DOMDocument('1.0', 'UTF-8');
        $sitemapindex = $xml->createElement('sitemapindex');
        $sitemapindex->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $xml->appendChild($sitemapindex);

        foreach ($types as $type) {
            $file = "{$outputDir}{$type}_sitemap.xml";
            if (file_exists($file)) {
                $sitemap = $xml->createElement('sitemap');
                $loc = $xml->createElement('loc', htmlspecialchars($baseUrl . basename($file)));
                $lastmod = $xml->createElement('lastmod', date('c', filemtime($file)));
                $sitemap->appendChild($loc);
                $sitemap->appendChild($lastmod);
                $sitemapindex->appendChild($sitemap);
            }
        }

        $xml->formatOutput = true;
        $xml->save($indexFile);
    }
}