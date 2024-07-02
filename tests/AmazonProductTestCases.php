<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/generalTest.php';

class AmazonProductTestCases extends TestCase
{
    public function testScrapeAmazonProduct()
    {
        $url = 'https://www.amazon.ae/dp/B07W7CTLD1/ref=sspa_dk_detail_2?psc=1&pd_rd_i=B07W7CTLD1&pd_rd_w=XY46E&content-id=amzn1.sym.0d43935b-1f23-45b4-af79-954185cded88&pf_rd_p=0d43935b-1f23-45b4-af79-954185cded88&pf_rd_r=G8AGP3D7TNG19M80PJHE&pd_rd_wg=QMsI3&pd_rd_r=ca60185d-873c-448c-8119-9f5896552c91&s=beauty&sp_csd=d2lkZ2V0TmFtZT1zcF9kZXRhaWw';
        $result = scrapeAmazonProduct($url);

        $this->assertNotNull($result, "The result should not be null.");
        $this->assertNotEmpty($result['name'], "The product name should not be empty.");
        $this->assertNotEmpty($result['price'], "The product price should not be empty.");
        $this->assertNotEmpty($result['description'], "The product description should not be empty.");
        $this->assertNotEmpty($result['images'], "The product images should not be empty.");
    }

    public function testScrapeAmazonProductWithDifferentHTMLStructure()
    {
        $url = 'https://www.amazon.ae/dp/B0CG9Q8W6Z/ref=sspa_dk_detail_4?psc=1&pd_rd_i=B0CG9Q8W6Z&pd_rd_w=rBH2Q&content-id=amzn1.sym.0d43935b-1f23-45b4-af79-954185cded88&pf_rd_p=0d43935b-1f23-45b4-af79-954185cded88&pf_rd_r=4S5WTXGQCB0A0C7VZWR8&pd_rd_wg=SQhcC&pd_rd_r=afd1c590-e9ff-45ba-8ee6-b43dd99eac19&s=beauty&sp_csd=d2lkZ2V0TmFtZT1zcF9kZXRhaWw';
        $result = scrapeAmazonProduct($url);

        $this->assertNotNull($result, "The result should not be null.");
        $this->assertNotEmpty($result['name'], "The product name should not be empty.");
        $this->assertNotEmpty($result['price'], "The product price should not be empty.");
        $this->assertNotEmpty($result['description'], "The product description should not be empty.");
        $this->assertNotEmpty($result['images'], "The product images should not be empty.");
    }

    public function testScrapeAmazonProductWithMissingDescription()
    {
        $url = 'https://www.amazon.ae/dp/B08VJ3GXV1';
        $result = scrapeAmazonProduct($url);

        $this->assertNotNull($result, "The result should not be null.");
        $this->assertNotEmpty($result['name'], "The product name should not be empty.");
        $this->assertNotEmpty($result['price'], "The product price should not be empty.");
        $this->assertIsString($result['description'], "The description should be a string.");
        $this->assertNotEmpty($result['images'], "The product images should not be empty.");
    }
}
?>
